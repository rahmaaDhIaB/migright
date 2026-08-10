<?php

namespace App\Http\Controllers;

use App\DataTables\TestimonyDemandDataTable;
use App\Models\AssistanceDemand;
use App\Models\Demand;
use App\Models\ExpoPushToken;
use App\Models\News;
use App\Models\PartnerDecision;
use App\Models\Region;
use App\Models\TestimonyDemand;
use App\Models\Type;
use App\Models\User;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestimonyDemandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TestimonyDemandDataTable $dataTable)
    {
        return $dataTable->render('testimony.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::where('category','testimony')->get();
        return view('testimony.create',compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'description' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'required|numeric|string',
            'file' => 'file|mimes:png,pdf,jpeg,mp4,mov,avi,docx,pptx|max:50480',
            'type' => 'array',
            'type.*' => 'in:anonymous,identified'
        ]);

        $filePath = public_path('uploads');

        $testimonyDemand = new TestimonyDemand();
        $testimonyDemand->type = $request->type ? $request->type[0] : 'anonymous'; // Assuming single type is selected

        $testimonyDemand->save();

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(storage_path('app/public/uploads/demands/'), $file_name);
        }


        // Create associated Demand
        $demand = $testimonyDemand->demand()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'description' => $request->description,
            'type' => $request->type,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'file' => $file_name ?? null,
        ]);
        if ($request->request_type){
            $demand->types()->attach($request->request_type) ;
        }

        return redirect()->route('testimony.index')->with('success', 'testimony Demand created successfully.');
    }

    /**
     * Display the specified resource.
     */


    public function show(Request $request,string $id)
    {
        $status = $request->query('status');

        if ($status === 'pending') {
            $testimonyDemand = TestimonyDemand::with('demand')->findOrFail($id);
            $demand = $testimonyDemand->demand()->first();
            $type = $demand->types()->first();
            return view('testimony.show', compact('testimonyDemand','demand' ,'type'));

        }
        $partnerDecision = PartnerDecision::findOrFail($id);
        $demand = $partnerDecision->demand;
        $testimonyDemand = $demand->demandable;
        $type = $demand->types()->first();

        $user_id = $partnerDecision->user_id ;
        $user = User::findOrFail($user_id);
        $user_name= $user->name ;

        return view('testimony.show', compact('testimonyDemand', 'type', 'partnerDecision', 'user_name','demand'));

    }


    public function treated(Request $request, string $id)
    {

        $request->validate([
            'comment' => 'required|string',
            'file' => 'nullable|file|mimes:png,jpeg,pdf,pptx,xls,doc,csv,jpg|max:2048',
        ]);
        $partnerDecision = PartnerDecision::findOrFail($id);
        $this->authorizeDecisionAccess($partnerDecision);
        $partnerDecision->status = 'accepted';
        $partnerDecision->comment = $request->input('comment');


        if ($request->hasFile('file')) {
            $filePath = public_path('uploads');

            if ($partnerDecision->file) {
                $existingFile = $filePath . '/' . $partnerDecision->file;
                if (file_exists($existingFile)) {
                    unlink($existingFile);
                }
            }

            $file = $request->file('file');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(storage_path('app/public/uploads/demands/'), $file_name);

            $partnerDecision->file = $file_name;
        }
        $partnerDecision->save();
        return redirect()->back()->with('success', 'Demand accepted successfully.');
    }


    public function notreated(Request $request, string $id)
    {
        $request->validate([
            'comment' => 'nullable|string',
            'file' => 'nullable|file|mimes:png,jpeg,pdf,pptx,xls,doc,csv,jpg|max:2048',
        ]);
        $partnerDecision = PartnerDecision::findOrFail($id);
        $this->authorizeDecisionAccess($partnerDecision);
        $partnerDecision->status = 'refused';
        if ($request->filled('comment')) {
            $partnerDecision->comment = $request->input('comment');
        }

        if ($request->hasFile('file')) {
            $filePath = public_path('uploads');
            if ($partnerDecision->file) {
                $existingFile = $filePath . '/' . $partnerDecision->file;
                if (file_exists($existingFile)) {
                    unlink($existingFile);
                }
            }
            $file = $request->file('file');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(storage_path('app/public/uploads/demands/'), $file_name);
            $partnerDecision->file = $file_name;
        }
        $partnerDecision->save();

        return redirect()->back()->with('success', 'Demand refused successfully.');
    }


    public function cloture(Request $request, string $id)
    {
        $request->validate([
            'admin_comment' => 'required|string',
            'partner_decision_file' => 'nullable|file|mimes:png,jpeg,pdf,pptx,xls,doc,csv,jpg|max:2048',
        ]);

        $partnerDecision = PartnerDecision::findOrFail($id);
        $demand = $partnerDecision->demand;


        if ($request->filled('admin_comment')) {
            $demand->admin_comment = $request->input('admin_comment');
        }

        if ($request->hasFile('partner_decision_file')) {
            $filePath = public_path('uploads');
            if ($demand->partner_decision_file) {
                $existingFile = $filePath . '/' . $demand->partner_decision_file;
                if (file_exists($existingFile)) {
                    unlink($existingFile);
                }
            }
            $partner_decision_file = $request->file('partner_decision_file');
            $file_name = time() . '_' . $partner_decision_file->getClientOriginalName();
            $partner_decision_file->move(storage_path('app/public/uploads/demands/'), $file_name);
            $demand->partner_decision_file = $file_name;
        }

        $partnerDecision->status = 'closed';
        $partnerDecision->save();
        $demand->status = 'done';
        $demand->save();

        $phoneNumber = $demand->phone_number ;
        $devices = ExpoPushToken::where('phone_number', $phoneNumber)->get();
        $messages = [
            new ExpoMessage([
                'title' => __('demand_treated'),
                'body' => __('your_demand_is_treated'),
            ]),
        ];
        foreach ($devices as $device){
            try {
                (new Expo)->send($messages)->to($device->push_token)->push();

            }catch (\Exception $exception){
                Log::error($exception->getMessage());
            }
        }
        return redirect()->back()->with('success','Demand closed successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $testimony = TestimonyDemand::with('demand')->findOrFail($id);
        $types = Type::where('category','testimony')->get();
        return view('testimony.edit', compact('testimony','types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'description' => 'required|string|max:255',
            'phone_number' => 'required|numeric|string',
            'file' => 'nullable|file|mimes:png,pdf,jpeg,jpg|max:2048',
            'type' => 'array',
            'type.*' => 'in:anonymous,identified'
        ]);

        // Find the TestimonyDemand instance by id
        $testimonyDemand = TestimonyDemand::findOrFail($id);

        $demand = $testimonyDemand->demand;
        $demand->first_name = $request->first_name;
        $demand->last_name = $request->last_name;
        $demand->email = $request->email;
        $demand->description = $request->description;
        $demand->phone_number = $request->phone_number;
        $demand->save();

        $testimonyDemand->save();

        // Process the file upload if 'file' is present in the request
        if ($request->hasFile('file')) {
            // Path to store the files
            $filePath = public_path('uploads');

            if ($testimonyDemand->demand->file) {
                $existingFile = $filePath . '/' . $testimonyDemand->demand->file;
                if (file_exists($existingFile)) {
                    unlink($existingFile);
                }
            }

            $file = $request->file('file');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(storage_path('app/public/uploads/demands/'), $file_name);

            $testimonyDemand->demand->file = $file_name;
        }

        $testimonyDemand->type = $request->type ? $request->type[0] : 'anonymous'; // Assuming single type is selected



        $testimonyDemand->demand->save();
        $testimonyDemand->save();

        return redirect()->route('testimony.index')
            ->with('success', 'Testimony Demand updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $testimonyDemand = testimonyDemand::with('demand')->findOrFail($id);
        $testimonyDemand->delete();

        return redirect()->route('testimony.index')->with('success', __('deleted_successfully'));
    }

    public function pending(string $id)
    {
        $testimonyDemand = Demand::findOrFail($id);

        $testimonyDemand->status = 'pending';

        $testimonyDemand->save();

        return redirect()->route('testimony.index')->with('success', 'testimony pending.');
    }


    public function refused($id)
    {

        $testimonyDemand = Demand::findOrFail($id);

        $testimonyDemand->status = 'refused';

        $testimonyDemand->save();

        return redirect()->route('testimony.index')->with('success', 'testimony refused.');
    }

    public function accept($id)
    {
        $testimonyDemand = Demand::findOrFail($id);

        $testimonyDemand->status = 'done';

        $testimonyDemand->save();

        return redirect()->route('testimony.index')->with('success', 'testimony accepted.');
    }

}
