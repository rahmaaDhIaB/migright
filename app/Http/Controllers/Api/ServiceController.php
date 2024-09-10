<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    /**
     * @OA\Get(
     *     path="/services",
     *     operationId="getServices",
     *     tags={"Services"},
     *     summary="Get services by category and region",
     *     description="Retrieve services filtered by category and/or region. If no filters are provided, all services are returned.",
     *     @OA\Parameter(
     *         name="category_id",
     *         in="query",
     *         description="ID of the category",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="region_id",
     *         in="query",
     *         description="ID of the region",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful retrieval of services",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="services",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/ServiceResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\AdditionalProperties(
     *                     @OA\Property(type="array", @OA\Items(type="string"))
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getServices(Request $request)
    {

        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'region_id' => 'nullable|exists:regions,id',
        ]);

        $query = Service::query();

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('region_id')) {
            $query->where('region_id', $request->region_id);
        }

        $services = $query->get();

        return response()->json([
            'services' => ServiceResource::collection($services),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/services/{id}",
     *     operationId="getServiceById",
     *     tags={"Services"},
     *     summary="Get service by ID",
     *     description="Retrieve a service by its ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the service",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful retrieval of service",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="service",
     *                 ref="#/components/schemas/ServiceResource"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Service not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Service] {id}")
     *         )
     *     )
     * )
     */
    public function getServiceById($id)
    {
        $service = Service::findOrFail($id);
        return response()->json([
           'service' => ServiceResource::make($service),
        ]);
    }


}
