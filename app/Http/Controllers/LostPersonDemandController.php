<?php

namespace App\Http\Controllers;

use App\DataTables\AssistanceDemandDataTable;
use App\DataTables\LostPersonDemandDataTable;
use App\Models\AssistanceDemand;
use App\Models\Demand;
use App\Models\ExpoPushToken;
use App\Models\LostPersonDemand;
use App\Models\PartnerDecision;
use App\Models\Region;
use App\Models\TestimonyDemand;
use App\Models\User;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LostPersonDemandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LostPersonDemandDataTable $dataTable)
    {
        return $dataTable->render('lostPerson.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regions = Region::all();
        $nationalities = $nationalities = [
            "Afghan",
            "Albanian",
            "Algerian",
            "American",
            "Andorran",
            "Angolan",
            "Antiguans",
            "Argentinean",
            "Armenian",
            "Australian",
            "Austrian",
            "Azerbaijani",
            "Bahamian",
            "Bahraini",
            "Bangladeshi",
            "Barbadian",
            "Barbudans",
            "Batswana",
            "Belarusian",
            "Belgian",
            "Belizean",
            "Beninese",
            "Bhutanese",
            "Bolivian",
            "Bosnian",
            "Brazilian",
            "British",
            "Bruneian",
            "Bulgarian",
            "Burkinabe",
            "Burmese",
            "Burundian",
            "Cambodian",
            "Cameroonian",
            "Canadian",
            "Cape Verdean",
            "Central African",
            "Chadian",
            "Chilean",
            "Chinese",
            "Colombian",
            "Comoran",
            "Congolese",
            "Costa Rican",
            "Croatian",
            "Cuban",
            "Cypriot",
            "Czech",
            "Danish",
            "Djibouti",
            "Dominican",
            "Dutch",
            "East Timorese",
            "Ecuadorean",
            "Egyptian",
            "Emirian",
            "Equatorial Guinean",
            "Eritrean",
            "Estonian",
            "Ethiopian",
            "Fijian",
            "Filipino",
            "Finnish",
            "French",
            "Gabonese",
            "Gambian",
            "Georgian",
            "German",
            "Ghanaian",
            "Greek",
            "Grenadian",
            "Guatemalan",
            "Guinea-Bissauan",
            "Guinean",
            "Guyanese",
            "Haitian",
            "Herzegovinian",
            "Honduran",
            "Hungarian",
            "Icelander",
            "Indian",
            "Indonesian",
            "Iranian",
            "Iraqi",
            "Irish",
            "Italian",
            "Ivorian",
            "Jamaican",
            "Japanese",
            "Jordanian",
            "Kazakhstani",
            "Kenyan",
            "Kittian and Nevisian",
            "Kuwaiti",
            "Kyrgyz",
            "Laotian",
            "Latvian",
            "Lebanese",
            "Liberian",
            "Libyan",
            "Liechtensteiner",
            "Lithuanian",
            "Luxembourger",
            "Macedonian",
            "Malagasy",
            "Malawian",
            "Malaysian",
            "Maldivan",
            "Malian",
            "Maltese",
            "Marshallese",
            "Mauritanian",
            "Mauritian",
            "Mexican",
            "Micronesian",
            "Moldovan",
            "Monacan",
            "Mongolian",
            "Moroccan",
            "Mosotho",
            "Motswana",
            "Mozambican",
            "Namibian",
            "Nauruan",
            "Nepalese",
            "New Zealander",
            "Nicaraguan",
            "Nigerian",
            "Nigerien",
            "North Korean",
            "Northern Irish",
            "Norwegian",
            "Omani",
            "Pakistani",
            "Palauan",
            "Panamanian",
            "Papua New Guinean",
            "Paraguayan",
            "Peruvian",
            "Polish",
            "Portuguese",
            "Qatari",
            "Romanian",
            "Russian",
            "Rwandan",
            "Saint Lucian",
            "Salvadoran",
            "Samoan",
            "San Marinese",
            "Sao Tomean",
            "Saudi",
            "Scottish",
            "Senegalese",
            "Serbian",
            "Seychellois",
            "Sierra Leonean",
            "Singaporean",
            "Slovakian",
            "Slovenian",
            "Solomon Islander",
            "Somali",
            "South African",
            "South Korean",
            "Spanish",
            "Sri Lankan",
            "Sudanese",
            "Surinamer",
            "Swazi",
            "Swedish",
            "Swiss",
            "Syrian",
            "Taiwanese",
            "Tajik",
            "Tanzanian",
            "Thai",
            "Togolese",
            "Tongan",
            "Trinidadian or Tobagonian",
            "Tunisian",
            "Turkish",
            "Tuvaluan",
            "Ugandan",
            "Ukrainian",
            "Uruguayan",
            "Uzbekistani",
            "Venezuelan",
            "Vietnamese",
            "Welsh",
            "Yemenite",
            "Zambian",
            "Zimbabwean"
        ];

        return view('lostPerson.create', compact('regions', 'nationalities'));

    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {

        $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'date' => 'required|date',
            'notification_sender' => 'array',
            'notification_sender.*' => 'in:parent,friend,neighbor,other',
            'missing_person_gender' => 'array',
            'missing_person_gender.*' => 'in:female,male',
            'missing_person_age' => 'array',
            'missing_person_age.*' => 'in:minor,adult',
            'nationality' => 'nullable|string|max:255',
            'description' => 'required|string|max:1000',
            'file' => 'nullable|file|mimes:png,jpeg,jpg,pdf|max:2048',
            'group_type' => 'required|in:single,group',
            'number_of_missing_persons' => 'nullable|integer|min:1',
        ]);

        $file_name = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(storage_path('app/public/uploads/demands/'), $file_name);
        }

        $lostPersonDemand = new LostPersonDemand();
        $lostPersonDemand->region = $request->region;
        $lostPersonDemand->date = $request->date;
        $lostPersonDemand->notification_sender = $request->notification_sender ? implode(',', $request->notification_sender) : null;
        $lostPersonDemand->missing_person_gender = $request->missing_person_gender ? implode(',', $request->missing_person_gender) : null;
        $lostPersonDemand->missing_person_age = $request->missing_person_age ? implode(',', $request->missing_person_age) : null;
        $lostPersonDemand->nationality = $request->nationality;
        $lostPersonDemand->group_type = $request->group_type;
        $lostPersonDemand->number_of_missing_persons = $request->group_type === 'group' ? $request->number_of_missing_persons : null;
        $lostPersonDemand->location = $request->location ;
        $lostPersonDemand->save();

        $lostPersonDemand->demand()->create([
            'description' => $request->description,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'file' => $file_name,
            'group_type' => $request->group_type,
            'number_of_missing_persons' => $request->group_type === 'group' ? $request->number_of_missing_persons : null,
        ]);
        return redirect()->route('lostPerson.index')->with('success', 'Lost Person Demand created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request,string $id)
    {
        $status = $request->query('status');

        if ($status === 'pending') {
            $lostPersonDemand = LostPersonDemand::with('demand')->findOrFail($id);
            $demand = $lostPersonDemand->demand()->first();
            $type = $demand->types()->first();
            return view('lostPerson.show', compact('lostPersonDemand','demand' ,'type'));

        }
        $partnerDecision = PartnerDecision::findOrFail($id);
        $demand = $partnerDecision->demand;
        $lostPersonDemand = $demand->demandable;
        $type = $demand->types()->first();

        $user_id = $partnerDecision->user_id ;
        $user = User::findOrFail($user_id);
        $user_name= $user->name ;

        return view('lostPerson.show', compact('lostPersonDemand', 'type', 'partnerDecision', 'user_name','demand'));

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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $lostPerson = LostPersonDemand::with('demand')->findOrFail($id);
        $regions = Region::all();
        $nationalities = $nationalities = [
            "Afghan",
            "Albanian",
            "Algerian",
            "American",
            "Andorran",
            "Angolan",
            "Antiguans",
            "Argentinean",
            "Armenian",
            "Australian",
            "Austrian",
            "Azerbaijani",
            "Bahamian",
            "Bahraini",
            "Bangladeshi",
            "Barbadian",
            "Barbudans",
            "Batswana",
            "Belarusian",
            "Belgian",
            "Belizean",
            "Beninese",
            "Bhutanese",
            "Bolivian",
            "Bosnian",
            "Brazilian",
            "British",
            "Bruneian",
            "Bulgarian",
            "Burkinabe",
            "Burmese",
            "Burundian",
            "Cambodian",
            "Cameroonian",
            "Canadian",
            "Cape Verdean",
            "Central African",
            "Chadian",
            "Chilean",
            "Chinese",
            "Colombian",
            "Comoran",
            "Congolese",
            "Costa Rican",
            "Croatian",
            "Cuban",
            "Cypriot",
            "Czech",
            "Danish",
            "Djibouti",
            "Dominican",
            "Dutch",
            "East Timorese",
            "Ecuadorean",
            "Egyptian",
            "Emirian",
            "Equatorial Guinean",
            "Eritrean",
            "Estonian",
            "Ethiopian",
            "Fijian",
            "Filipino",
            "Finnish",
            "French",
            "Gabonese",
            "Gambian",
            "Georgian",
            "German",
            "Ghanaian",
            "Greek",
            "Grenadian",
            "Guatemalan",
            "Guinea-Bissauan",
            "Guinean",
            "Guyanese",
            "Haitian",
            "Herzegovinian",
            "Honduran",
            "Hungarian",
            "Icelander",
            "Indian",
            "Indonesian",
            "Iranian",
            "Iraqi",
            "Irish",
            "Italian",
            "Ivorian",
            "Jamaican",
            "Japanese",
            "Jordanian",
            "Kazakhstani",
            "Kenyan",
            "Kittian and Nevisian",
            "Kuwaiti",
            "Kyrgyz",
            "Laotian",
            "Latvian",
            "Lebanese",
            "Liberian",
            "Libyan",
            "Liechtensteiner",
            "Lithuanian",
            "Luxembourger",
            "Macedonian",
            "Malagasy",
            "Malawian",
            "Malaysian",
            "Maldivan",
            "Malian",
            "Maltese",
            "Marshallese",
            "Mauritanian",
            "Mauritian",
            "Mexican",
            "Micronesian",
            "Moldovan",
            "Monacan",
            "Mongolian",
            "Moroccan",
            "Mosotho",
            "Motswana",
            "Mozambican",
            "Namibian",
            "Nauruan",
            "Nepalese",
            "New Zealander",
            "Nicaraguan",
            "Nigerian",
            "Nigerien",
            "North Korean",
            "Northern Irish",
            "Norwegian",
            "Omani",
            "Pakistani",
            "Palauan",
            "Panamanian",
            "Papua New Guinean",
            "Paraguayan",
            "Peruvian",
            "Polish",
            "Portuguese",
            "Qatari",
            "Romanian",
            "Russian",
            "Rwandan",
            "Saint Lucian",
            "Salvadoran",
            "Samoan",
            "San Marinese",
            "Sao Tomean",
            "Saudi",
            "Scottish",
            "Senegalese",
            "Serbian",
            "Seychellois",
            "Sierra Leonean",
            "Singaporean",
            "Slovakian",
            "Slovenian",
            "Solomon Islander",
            "Somali",
            "South African",
            "South Korean",
            "Spanish",
            "Sri Lankan",
            "Sudanese",
            "Surinamer",
            "Swazi",
            "Swedish",
            "Swiss",
            "Syrian",
            "Taiwanese",
            "Tajik",
            "Tanzanian",
            "Thai",
            "Togolese",
            "Tongan",
            "Trinidadian or Tobagonian",
            "Tunisian",
            "Turkish",
            "Tuvaluan",
            "Ugandan",
            "Ukrainian",
            "Uruguayan",
            "Uzbekistani",
            "Venezuelan",
            "Vietnamese",
            "Welsh",
            "Yemenite",
            "Zambian",
            "Zimbabwean"
        ];
        return view('lostPerson.edit', compact('lostPerson', 'regions', 'nationalities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'date' => 'required|date',
            'notification_sender' => 'array',
            'notification_sender.*' => 'in:parent,friend,neighbor,other',
            'missing_person_gender' => 'array',
            'missing_person_gender.*' => 'in:female,male',
            'missing_person_age' => 'array',
            'missing_person_age.*' => 'in:minor,adult',
            'nationality' => 'nullable|string|max:255',
            'description' => 'required|string|max:1000',
            'file' => 'nullable|file|mimes:png,jpeg,jpg,pdf|max:2048',
            'group_type' => 'required|in:single,group',
            'number_of_missing_persons' => 'nullable|integer|min:1',
        ]);


        $lostPersonDemand = LostPersonDemand::with('demand')->findOrFail($id);
        $lostPersonDemand->demand->description = $request->description;
        $lostPersonDemand->demand->first_name = $request->first_name;
        $lostPersonDemand->demand->last_name = $request->last_name;

        if ($request->hasFile('file')) {
            $filePath = public_path('uploads');

            if ($lostPersonDemand->demand->file) {
                $existingFile = $filePath . '/' . $lostPersonDemand->demand->file;
                if (file_exists($existingFile)) {
                    unlink($existingFile);
                }
            }

            $file = $request->file('file');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(storage_path('app/public/uploads/demands/'), $file_name);

            $lostPersonDemand->demand->file = $file_name;
        }


        $lostPersonDemand->region = $request->region;
        $lostPersonDemand->date = $request->date;
        $lostPersonDemand->notification_sender = $request->notification_sender ? $request->notification_sender[0] : 'other';
        $lostPersonDemand->missing_person_gender = $request->missing_person_gender ? $request->missing_person_gender[0] : '';
        $lostPersonDemand->missing_person_age = $request->missing_person_age ? $request->missing_person_age[0] : '';


        $lostPersonDemand->nationality = $request->nationality;
        $lostPersonDemand->group_type = $request->group_type;
        $lostPersonDemand->number_of_missing_persons = $request->group_type === 'group' ? $request->number_of_missing_persons : null;
        $lostPersonDemand->location = $request->location ;

        $lostPersonDemand->demand->save();
        $lostPersonDemand->save();


        return redirect()->route('lostPerson.index')->with('success', 'Lost Person Demand updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lostPersonDemand = lostPersonDemand::with('demand')->findOrFail($id);
        $lostPersonDemand->delete();

        return redirect()->route('lostPerson.index')->with('success', __('deleted_successfully'));
    }


    public function pending(string $id)
    {
        $lostPerson = Demand::findOrFail($id);

        $lostPerson->status = 'pending';

        $lostPerson->save();

        return redirect()->route('lostPerson.index')->with('success', 'lostPerson is pending.');
    }


    public function refused($id)
    {

        $lostPerson = Demand::findOrFail($id);

        $lostPerson->status = 'refused';

        $lostPerson->save();

        return redirect()->route('lostPerson.index')->with('success', 'lostPerson refused.');
    }

    public function accept($id)
    {
        $lostPerson = Demand::findOrFail($id);

        $lostPerson->status = 'done';

        $lostPerson->save();

        return redirect()->route('lostPerson.index')->with('success', 'lostPerson accepted.');
    }


}
