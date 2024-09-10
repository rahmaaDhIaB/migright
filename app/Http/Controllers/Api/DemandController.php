<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssistanceDemandRequest;
use App\Http\Requests\LostPersonRequest;
use App\Http\Requests\TestimonyRequest;
use App\Http\Resources\DemandResource;
use App\Http\Resources\TypeResource;
use App\Models\AssistanceDemand;
use App\Models\Demand;
use App\Models\LostPersonDemand;
use App\Models\Region;
use App\Models\TestimonyDemand;
use App\Models\Type;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class DemandController extends Controller
{

    /**
     * @OA\Get(
     *     path="/demands",
     *     summary="Get demands by phone number",
     *     description="Retrieve a list of demands filtered by a given phone number.",
     *     tags={"Demands"},
     *     @OA\Parameter(
     *         name="phone",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *         description="The phone number to filter demands by."
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A list of demands",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="demands",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/DemandResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request. Phone number is required."
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required'
        ]);
        $phoneNumber = $request->get('phone');
        $demands = Demand::where('phone_number', $phoneNumber)->where('demandable_type','App\Models\AssistanceDemand')->where('status','!=','cancelled')->get();
        return response()->json([
            'demands' => DemandResource::collection($demands),
        ]);
    }

    /**
     * @OA\Post(
     *     path="/demands/testimonials",
     *     summary="Submit a testimony",
     *     description="Submit a testimony demand",
     *     tags={"Demands"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TestimonyRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The testimony demand",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="demand",
     *                 ref="#/components/schemas/DemandResource"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */

    public function submitTestimonial(TestimonyRequest $request): JsonResponse
    {
        $testimonyDemand = new TestimonyDemand();
        $testimonyDemand->type = $request->testimonyType;
        $testimonyDemand->save();
        $this->storeDemand($testimonyDemand, $request);
        return response()->json([
            'demand' => DemandResource::make($testimonyDemand->demand)
        ]);
    }

    /**
     * @OA\Post(
     *     path="/demands/testimonials/{id}",
     *     summary="Update a testimony",
     *     description="Update an existing testimony demand",
     *     tags={"Demands"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the testimony demand",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TestimonyRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The updated testimony demand",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="demand",
     *                 ref="#/components/schemas/DemandResource"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Testimony demand not found"
     *     )
     * )
     */
    public function updateTestimonialDemand(TestimonyRequest $request, $id): JsonResponse
    {
        $demand = Demand::findOrFail($id);
        if ($demand->demandable_type != TestimonyDemand::class) {
            return response()->json([
                'message' => 'Can not perform this action'
            ], 403);
        }
        $testimonyDemand = $demand->demandable;
        $testimonyDemand->type = $request->testimonyType;
        $testimonyDemand->save();
        $this->updateDemand($testimonyDemand, $request);
        return response()->json([
            'demand' => DemandResource::make($testimonyDemand->demand)
        ]);
    }

    /**
     * @OA\Post(
     *     path="/demands/assistance",
     *     summary="Submit an assistance demand",
     *     description="Submit an assistance demand",
     *     tags={"Demands"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AssistanceDemandRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The assistance demand",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="demand",
     *                 ref="#/components/schemas/DemandResource"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function submitAssistanceDemand(AssistanceDemandRequest $request): JsonResponse
    {
        $assistanceDemand = new AssistanceDemand();
        if (($request->region) && ($request->region != 'no-region')) {
            $region = Region::findOrFail($request->region);
            $assistanceDemand->region = $region->name;
        }
        $assistanceDemand->requestSubmitter = $request->assistanceType;
        $assistanceDemand->save();
        $this->storeDemand($assistanceDemand, $request);
        return response()->json([
            'demand' => DemandResource::make($assistanceDemand->demand)
        ]);
    }

    /**
     * @OA\Post (
     *     path="/demands/assistance/{id}",
     *     summary="Update an assistance demand",
     *     description="Update an existing assistance demand",
     *     tags={"Demands"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the assistance demand",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AssistanceDemandRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The updated assistance demand",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="demand",
     *                 ref="#/components/schemas/DemandResource"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Assistance demand not found"
     *     )
     * )
     */
    public function updateAssistanceDemand(AssistanceDemandRequest $request, $id): JsonResponse
    {
        $demand = Demand::findOrFail($id);
        if ($demand->demandable_type != AssistanceDemand::class) {
            return response()->json([
                'message' => 'Can not perform this action'
            ], 403);
        }
        $assistanceDemand = $demand->demandable;

        if (($request->region) && ($request->region != 'no-region')) {
            $region = Region::findOrFail($request->region);
            $assistanceDemand->region = $region->name;
        }
        $assistanceDemand->requestSubmitter = $request->assistanceType;
        $assistanceDemand->save();
        $this->updateDemand($assistanceDemand, $request);
        return response()->json([
            'demand' => DemandResource::make($assistanceDemand->demand)
        ]);
    }

    /**
     * @OA\Post(
     *     path="/demands/lost-person",
     *     summary="Submit a lost person demand",
     *     description="Submit a lost person demand",
     *     tags={"Demands"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LostPersonRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The lost person demand",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="demand",
     *                 ref="#/components/schemas/DemandResource"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function submitLostPersonDemand(LostPersonRequest $request): JsonResponse
    {
        $lostPersonDemand = new LostPersonDemand();
        if (($request->region) && ($request->region != 'no-region')) {
            $region = Region::findOrFail($request->region);
            $lostPersonDemand->region = $region->name;
        }
        $lostPersonDemand->date = $request->date;
        $lostPersonDemand->notification_sender = $request->notificationSender;
        $lostPersonDemand->missing_person_gender = $request->gender;
        $lostPersonDemand->missing_person_age = $request->age;
        $lostPersonDemand->nationality = $request->nationality;
        $lostPersonDemand->location = $request->missingPersonGeoLocation ;
        $lostPersonDemand->save();
        $this->storeDemand($lostPersonDemand, $request);
        return response()->json([
            'demand' => DemandResource::make($lostPersonDemand->demand)
        ]);
    }

    /**
     * @OA\Post (
     *     path="/demands/lost-person/{id}",
     *     summary="Update a lost person demand",
     *     description="Update an existing assistance demand",
     *     tags={"Demands"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the lost person demand",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LostPersonRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The updated lost person demand",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="demand",
     *                 ref="#/components/schemas/DemandResource"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Assistance demand not found"
     *     )
     * )
     */
    public function updateLostPersonDemand(LostPersonRequest $request, $id): JsonResponse
    {
        $demand = Demand::findOrFail($id);
        if ($demand->demandable_type != LostPersonDemand::class) {
            return response()->json([
                'message' => 'Can not perform this action'
            ], 403);
        }
        $lostPersonDemand = $demand->demandable;

        if (($request->region) && ($request->region != 'no-region')) {
            $region = Region::findOrFail($request->region);
            $lostPersonDemand->region = $region->name;
        }
        $lostPersonDemand->date = $request->date;
        $lostPersonDemand->notification_sender = $request->notificationSender;
        $lostPersonDemand->missing_person_gender = $request->gender;
        $lostPersonDemand->missing_person_age = $request->age;
        $lostPersonDemand->nationality = $request->nationality;
        $lostPersonDemand->save();
        $this->updateDemand($lostPersonDemand, $request);
        return response()->json([
            'demand' => DemandResource::make($lostPersonDemand->demand)
        ]);
    }

    /**
     * @OA\Get(
     *     path="/demands/{id}",
     *     summary="Get demand by ID",
     *     description="Retrieve a demand by its ID",
     *     tags={"Demands"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *         description="ID of the demand"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The demand",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="demand",
     *                 ref="#/components/schemas/DemandResource"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Demand not found"
     *     )
     * )
     */
    public function getDemandById($id): JsonResponse
    {
        $demand = Demand::findOrFail($id);
        return response()->json([
            'demand' => DemandResource::make($demand)
        ]);
    }

    public function getTestimonialTypes()
    {
        $locale = request()->header('Accept-Language', config('app.locale'));
        $types = Type::getTestimonialTypes($locale);
        return response()->json([
            'types' => TypeResource::collection($types)
        ]);
    }

    public function getAssistanceTypes()
    {
        $locale = request()->header('Accept-Language', config('app.locale'));
        $types = Type::getAssistanceTypes($locale);
        return response()->json([
            'types' => TypeResource::collection($types)
        ]);
    }

    public function getLostPersonTypes()
    {
        $locale = request()->header('Accept-Language', config('app.locale'));
        $types = Type::getLostPersonTypes($locale);
        return response()->json([
            'types' => TypeResource::collection($types)
        ]);
    }

    private function storeDemand($demand, $request): void
    {
        $storedDemand = $demand->demand()->create([
            'first_name' => $request->get('firstName'),
            'last_name' => $request->get('lastName'),
            'phone_number' => $request->get('phone'),
            'email' => $request->get('email'),
            'description' => $request->get('description') ?? 'not-specified',
            'voice_message' => $request->get('voiceMessage'),
        ]);
        if (($request->assistanceNature) && ($request->assistanceNature != 'no-nature')) {
            $storedDemand->types()->attach($request->assistanceNature);
        }
        if (($request->testimonyNature) && ($request->testimonyNature != 'no-nature')) {
            $storedDemand->types()->attach($request->testimonyNature);
        }
        if ($request->has('file')) {
            $file = $request->file('file');
            $file_name = time() . $file->getClientOriginalName();
            $file->move(storage_path('app/public/uploads/demands'), $file_name);
            $demand->demand->file = $file_name;
            $demand->demand->save();
        }
        if ($request->has('voiceMessage')) {
            $file = $request->file('voiceMessage');
            $file_name = time() . $file?->getClientOriginalName();
            $file->move(storage_path('app/public/uploads/demands'), $file_name);
            $demand->demand->voice_message = $file_name;
            $demand->demand->save();
        }
    }

    private function updateDemand($demand, $request): void
    {
        $updatedDemand = $demand->demand()->update([
            'first_name' => $request->get('firstName'),
            'last_name' => $request->get('lastName'),
            'phone_number' => $request->get('phone'),
            'email' => $request->get('email'),
            'description' => $request->get('description'),
            'voice_message' => $request->get('voiceMessage'),
        ]);
        $updatedDemand = Demand::findOrFail($updatedDemand);
        if (($request->assistanceNature) && ($request->assistanceNature != 'no-nature')) {
            $updatedDemand->types()->attach($request->assistanceNature);
        }
        if (($request->testimonyNature) && ($request->testimonyNature != 'no-nature')) {
            $updatedDemand->types()->attach($request->testimonyNature);
        }
        if ($request->has('file')) {
            $file = $request->file('file');
            $file_name = time() . $file->getClientOriginalName();
            $file->move(storage_path('app/public/uploads/demands'), $file_name);
            $demand->demand->file = $file_name;
            $demand->demand->save();
        }
        if ($request->has('voiceMessage')) {
            $file = $request->file('voiceMessage');
            $file_name = time() . $file->getClientOriginalName();
            $file->move(storage_path('app/public/uploads/demands'), $file_name);
            $demand->demand->voice_message = $file_name;
            $demand->demand->save();
        }
    }


    /**
     * @OA\Post(
     *      path="/demands/{id}/cancel",
     *      operationId="cancelDemand",
     *      tags={"Demands"},
     *      summary="Cancel a demand",
     *      description="Allows an authenticated user to cancel a demand by providing a reason",
     *      @OA\Parameter(
     *          name="id",
     *          description="Demand ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="cancellation_reason_id", type="integer", example=1)
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Demand cancelled successfully")
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found"
     *      )
     * )
     */
    public function cancelDemandById(Request $request, $id)
    {
        $request->validate([
            'cancellation_reason_id' => 'required|exists:cancellation_reasons,id',
        ]);
        $demand = Demand::findOrFail($id);
        $demand->cancellation_reason_id = $request->cancellation_reason_id;
        $demand->status = 'cancelled';
        $demand->save();
        return response()->json(['message' => 'Demand cancelled successfully'], 200);
    }

    public function cancelTestimonialDemand(Request $request)
    {
        $request->validate([
            'cancellation_reason_id' => 'required|exists:cancellation_reasons,id',
        ]);
        $testimony = TestimonyDemand::create($request->all());
        $this->storeDemand($testimony, $request);
        $testimony->demand->status = 'cancelled';
        $testimony->demand->cancellation_reason_id = request('cancellation_reason_id');
        $testimony->demand->save();
        return response()->json([
            'message' => 'Demand cancelled successfully'
        ]);
    }

    public function cancelAssistanceDemand(Request $request)
    {
        $request->validate([
           'cancellation_reason_id' => 'required|exists:cancellation_reasons,id',
        ]);
        $assistance = AssistanceDemand::create($request->all());
        $storedDemand = $assistance->demand()->create([
            'first_name' => $request->get('firstName') ?? 'not-specified',
            'last_name' => $request->get('lastName') ?? 'not-specified',
            'phone_number' => $request->get('phone') ?? 'not-specified',
            'email' => $request->get('email') ?? 'not-specified',
            'description' => $request->get('description') ?? 'not-specified',
            'voice_message' => $request->get('voiceMessage'),
        ]);
        $storedDemand->status = 'cancelled';
        $storedDemand->cancellation_reason_id = $request->get('cancellation_reason_id');
        $storedDemand->save();
        return response()->json([
            'message' => 'Demand cancelled successfully'
        ]);
    }

    public function cancelLostPersonDemand(Request $request)
    {
        $request->validate([
            'cancellation_reason_id' => 'required|exists:cancellation_reasons,id',
        ]);
        $lostPersonDemand = LostPersonDemand::create($request->all());
        $this->storeDemand($lostPersonDemand, $request);
        $lostPersonDemand->demand->status = 'cancelled';
        $lostPersonDemand->demand->cancellation_reason_id = request('cancellation_reason_id');
        $lostPersonDemand->demand->save();
        return response()->json([
            'message' => 'Demand cancelled successfully'
        ]);
    }
}



