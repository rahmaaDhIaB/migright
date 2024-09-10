<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CancellationReasonResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\RegionResource;
use App\Models\CancellationReason;
use App\Models\Category;
use App\Models\Region;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{

    /**
     * Retrieve all categories and regions.
     *
     * This method fetches all categories and regions from the database and returns them
     * in a JSON response. Each category and region is represented by its ID and name.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/service-configurations",
     *     operationId="getConfigurations",
     *     tags={"Configurations"},
     *     summary="Get all categories and regions",
     *     description="Returns all categories and regions.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="categories",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Category 1")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="regions",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Region 1")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getConfigurations()
    {
        $categories = Category::all();
        $regions = Region::all();
        return response()->json([
            'categories' => CategoryResource::collection($categories),
            'regions' => RegionResource::collection($regions),
            'cancellationReasons' => CancellationReasonResource::collection(CancellationReason::all()),
        ]);
    }
}
