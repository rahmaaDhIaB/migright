<?php
namespace App\Http\Controllers;

use App\DataTables\NewsDataTable;
use App\DataTables\PrivacyPolicyDataTable;
use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;

class PrivacyPolicyController extends Controller
{
    public function create()
    {
        return view('privacy-policy.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description_fr' => 'required|string',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
        ]);

        $data = $request->all();

        PrivacyPolicy::create($data);

        return redirect()->route('privacy-policy.index')->with('success', 'Politique de confidentialité créée avec succès.');
    }

    public function edit($id)
    {
        $policy = PrivacyPolicy::findOrFail($id);
        return view('privacy-policy.edit', ['privacyPolicy' => $policy]);
    }

    public function update(Request $request, $id)
    {
        $privacyPolicy = PrivacyPolicy::findOrFail($id);

        $request->validate([
            'description_fr' => 'required|string',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
        ]);

        $data = $request->all();

        $privacyPolicy->update($data);

        return redirect()->route('privacy-policy.index')->with('success', 'Politique de confidentialité mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $policy = PrivacyPolicy::findOrFail($id);
        $policy->delete();

        return redirect()->route('privacy-policy.index')->with('success', 'Politique de confidentialité supprimée avec succès.');
    }

    public function show($id)
    {
        $privacyPolicy = PrivacyPolicy::findOrFail($id);
        return view('privacy-policy.show', ['privacyPolicy' => $privacyPolicy]);
    }



    public function index(PrivacyPolicyDataTable $dataTable)
    {
        return $dataTable->render('privacy-policy.index');
    }
}
