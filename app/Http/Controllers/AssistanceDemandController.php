<?php

namespace App\Http\Controllers;

use App\DataTables\AssistanceDemandDataTable;
use App\Models\AssistanceDemand;
use App\Models\Demand;
use App\Models\ExpoPushToken;
use App\Models\LostPersonDemand;
use App\Models\PartnerDecision;
use App\Models\Region;
use App\Models\TestimonyDemand;
use App\Models\Type;
use App\Models\User;
use App\Services\DemandAssignmentService;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssistanceDemandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AssistanceDemandDataTable $dataTable)
    {
        return $dataTable->render('assistance.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regions = Region::all();
        $types = Type::where('category', 'assistance')->get();
        return view('assistance.create', compact('regions', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'region' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'required|numeric|string',
            'file' => 'nullable|file|mimes:png,txt,pdf,jpeg,jpg|max:2048',
            'requestSubmitter' => 'required|array',
            'requestSubmitter.*' => 'required|in:concernedPerson,otherPerson'
        ]);

        $assistanceDemand = new AssistanceDemand();
        $assistanceDemand->requestSubmitter = $request->requestSubmitter ? $request->requestSubmitter[0] : 'anonymous'; // Assuming single type is selected
        $assistanceDemand->region = $request->region;
        $assistanceDemand->save();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(storage_path('app/public/uploads/demands/'), $file_name);
        }

        $demand = $assistanceDemand->demand()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'region' => $request->region,
            'file' => $file_name ?? null,
            'description' => $request->description,
        ]);
        if ($request->request_type) {
            $demand->types()->attach($request->request_type);
        }
        return redirect()->route('assistance.index')->with('success', 'assistance Demand created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $status = $request->query('status');

        if ($status === 'pending') {
            $assistanceDemand = AssistanceDemand::with('demand')->findOrFail($id);
            $demand = $assistanceDemand->demand()->first();
            $type = $demand->types()->first();
            return view('assistance.show', compact('assistanceDemand', 'demand', 'type'));

        }
        $partnerDecision = PartnerDecision::findOrFail($id);
        $demand = $partnerDecision->demand;
        $assistanceDemand = $demand->demandable;
        $type = $demand->types()->first();

        $user_id = $partnerDecision->user_id;
        $user = User::findOrFail($user_id);
        $user_name = $user->name;

        return view('assistance.show', compact('assistanceDemand', 'type', 'partnerDecision', 'user_name', 'demand'));

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $assistance = AssistanceDemand::with('demand')->findOrFail($id);
        $regions = Region::all();
        return view('assistance.edit', compact('assistance', 'regions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'required|numeric',
            'file' => 'nullable|file|mimes:png,jpeg,jpg|max:2048',
            'requestSubmitter' => 'required|array',
            'requestSubmitter.*' => 'required|in:concernedPerson,otherPerson'
        ]);


        $assistanceDemand = AssistanceDemand::with('demand')->findOrFail($id);


        $assistanceDemand->demand->first_name = $request->first_name;
        $assistanceDemand->demand->last_name = $request->last_name;
        $assistanceDemand->demand->email = $request->email;
        $assistanceDemand->demand->phone_number = $request->phone_number;
        $assistanceDemand->demand->description = $request->description;


        if ($request->hasFile('file')) {
            $filePath = public_path('uploads');

            if ($assistanceDemand->demand->file) {
                $existingFile = $filePath . '/' . $assistanceDemand->demand->file;
                if (file_exists($existingFile)) {
                    unlink($existingFile);
                }
            }

            $file = $request->file('file');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(storage_path('app/public/uploads/demands/'), $file_name);

            $assistanceDemand->demand->file = $file_name;
        }


        $assistanceDemand->requestSubmitter = $request->requestSubmitter ? $request->requestSubmitter[0] : 'otherPerson'; // Assuming single type is selected
        $assistanceDemand->region = $request->region;
        $assistanceDemand->save();
        $assistanceDemand->demand->save();

        return redirect()->route('assistance.index')
            ->with('success', 'assistance Demand updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $assistanceDemand = AssistanceDemand::with('demand')->findOrFail($id);
        $assistanceDemand->delete();

        return redirect()->route('assistance.index')->with('success', __('deleted_successfully'));
    }

    public function pending(string $id)
    {
        $assistanceDemand = Demand::findOrFail($id);

        $assistanceDemand->status = 'pending';

        $assistanceDemand->save();

        return redirect()->route('assistance.index')->with('success', 'assistance pending.');
    }


    public function refused($id)
    {

        $assistanceDemand = Demand::findOrFail($id);

        $assistanceDemand->status = 'done';

        $assistanceDemand->save();

        return redirect()->route('assistance.index')->with('success', 'assistance done.');
    }


    public function assignAssistanceDemandCreate($id)
    {
        $partners = User::get();
        $assistanceDemand = AssistanceDemand::findOrFail($id);
        return view('assistance.create-partner', compact('id', 'partners', 'assistanceDemand'));
    }

    public function assignAssistanceDemandStore(Request $request, $id, DemandAssignmentService $assignmentService)
    {
        $request->validate([
            'partner' => 'required|exists:users,id',
        ]);

        $assignmentService->assignToPartner(
            AssistanceDemand::findOrFail($id),
            User::findOrFail($request->partner)
        );

        return redirect()->route('assistance.index')->with('success', 'Assistance demand assigned, email sent, and decision recorded successfully.');
    }

    public function assignLostPersonDemandCreate($id)
    {
        $partners = User::get();
        $lostPersonDemand = LostPersonDemand::findOrFail($id);
        return view('lostPerson.create-partner', compact('id', 'partners', 'lostPersonDemand'));

    }

    public function assignLostPersonDemandStore(Request $request, $id, DemandAssignmentService $assignmentService)
    {
        $request->validate([
            'partner' => 'required|exists:users,id',
        ]);

        $assignmentService->assignToPartner(
            LostPersonDemand::findOrFail($id),
            User::findOrFail($request->partner)
        );

        return redirect()->route('lostPerson.index')->with('success', 'lost Person demand assigned, email sent, and decision recorded successfully.');
    }

    public function assignTestimonyDemandCreate($id)
    {
        $partners = User::get();
        $testimonyDemand = TestimonyDemand::findOrFail($id);
        return view('testimony.create-partner', compact('id', 'partners', 'testimonyDemand'));

    }

    public function assignTestimonyDemandStore(Request $request, $id, DemandAssignmentService $assignmentService)
    {
        $request->validate([
            'partner' => 'required|exists:users,id',
        ]);

        $assignmentService->assignToPartner(
            TestimonyDemand::findOrFail($id),
            User::findOrFail($request->partner)
        );

        return redirect()->route('testimony.index')->with('success', 'testimony demand assigned, email sent, and decision recorded successfully.');
    }


    public function accept($id)
    {
        $assistanceDemand = Demand::findOrFail($id);

        $assistanceDemand->status = 'in progress';

        $assistanceDemand->save();

        return redirect()->route('assistance.index')->with('success', 'assistance accepted.');
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
        $phoneNumber = $demand->phone_number;
        $devices = ExpoPushToken::where('phone_number', $phoneNumber)->get();
        $messages = [
            new ExpoMessage([
                'title' => __('demand_treated'),
                'body' => __('your_demand_is_treated'),
            ]),
        ];
        foreach ($devices as $device) {
            try {
                (new Expo)->send($messages)->to($device->push_token)->push();

            } catch (\Exception $exception) {
                Log::error($exception->getMessage());
            }
        }
        return redirect()->back()->with('success', 'Demand closed successfully.');
    }

    public function changeType(Request $request, $id)
    {
        $demand = Demand::findOrFail($id);
        switch ($demand->demand_type) {
            case 'App\Models\AssistanceDemand':
                $demandable = AssistanceDemand::findOrFail($demand->demandable_id);
                break;
            case 'App\Models\TestimonyDemand':
                $demandable = TestimonyDemand::findOrFail($demand->demandable_id);
                break;
            default :
                $demandable = LostPersonDemand::findOrFail($demand->demandable_id);
        }
        if ($request->demand_type == 'App\Models\AssistanceDemand') {
            if ((!$demand->phone_number) || ($demand->phone_number == 'not-specified')) {
                return redirect()->back()->with('error', 'Can not change demand type.');
            }
        }
        switch ($request->demand_type) {
            case 'App\Models\AssistanceDemand':
                $newDemandable = new AssistanceDemand();
                $newDemandable->save();
                break;
            case 'App\Models\TestimonyDemand':
                $newDemandable = new TestimonyDemand();
                $newDemandable->save();
                break;
            default :
                $newDemandable = new LostPersonDemand();
                $newDemandable->save();
        }
        $demand->demandable_type = $request->demand_type;
        $demand->demandable_id = $newDemandable->id;
        $demand->save();
        return redirect()->route('assistance.index')->with('success', __('Demand type updated successfully.'));
    }
}
