<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Models\News;
use App\Models\TestimonyDemand;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('users.index');
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users'],
            'password' => 'required',
        ], [
            'name.required' => __('name_is_required'),
            'email.required' => __('enter_your_email_please'),
            'email.email' => __('verify_email_format'),
            'email.unique' => __('enter_unique_email_please'),
            'password.required' => __('enter_password_please'),
        ]);
        $isAdmin = false ;
        if ($request->role == 'admin'){
            $isAdmin = true;
        }
        User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'is_admin' => $isAdmin,
        ]);
        return redirect()->route('admins.index')->with('success', __('created_successfully'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users,email,' . $id],
            'password' => 'nullable',
        ], [
            'name.required' => __('name_is_required'),
            'email.required' => __('enter_your_email_please'),
            'email.email' => __('verify_email_format'),
            'email.unique' => __('enter_unique_email_please'),
        ]);

        $user = User::findOrFail($id);

        $data = [
            'email' => $request->email,
            'name' => $request->name,
        ];
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        return redirect()->route('admins.index')->with('success', __('updated_successfully'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id) ;
        $user->delete();
        return redirect()->route('admins.index')->with('success', __('deleted_successfully'));
    }
}
