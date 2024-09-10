<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/privacy-policy",
     *     summary="Get the privacy policy",
     *     tags={"Privacy Policy"},
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="The locale for the privacy policy content",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="en"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Privacy policy content",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="content",
     *                 type="string"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Privacy policy not found"
     *     )
     * )
     */
    public function show(Request $request) : JsonResponse
    {
        $locale = $request->header('Accept-Language', 'en');
        $policy = PrivacyPolicy::first();

        if (!$policy) {
            return response()->json(['error' => 'Privacy Policy not found'], 404);
        }

        $content = match ($locale) {
            'fr' => $policy->description_fr,
            'ar' => $policy->description_ar,
            default => $policy->description_en,
        };

        if ($content === null) {
            return response()->json(['error' => 'Content not available for the specified language'], 404);
        }

        return response()->json(['content' => $content]);
    }

//    /**
//     * @OA\Put(
//     *     path="/privacy-policy/{id}",
//     *     summary="Update the privacy policy",
//     *     tags={"Privacy Policy"},
//     *     @OA\Parameter(
//     *         name="id",
//     *         in="path",
//     *         required=true,
//     *         @OA\Schema(
//     *             type="integer"
//     *         ),
//     *         description="Privacy policy ID"
//     *     ),
//     *     @OA\RequestBody(
//     *         required=true,
//     *         @OA\JsonContent(
//     *             type="object",
//     *             @OA\Property(property="description_en", type="string"),
//     *             @OA\Property(property="description_fr", type="string"),
//     *             @OA\Property(property="description_ar", type="string")
//     *         )
//     *     ),
//     *     @OA\Response(
//     *         response=200,
//     *         description="Privacy policy updated",
//     *         @OA\JsonContent(ref="#/components/schemas/PrivacyPolicy")
//     *     ),
//     *     @OA\Response(
//     *         response=404,
//     *         description="Privacy policy not found"
//     *     )
//     * )
//     */
//    public function update(Request $request, $id) : JsonResponse
//    {
//        $request->validate([
//            'description_en' => 'required|string',
//            'description_fr' => 'required|string',
//            'description_ar' => 'required|string',
//        ]);
//
//        $policy = PrivacyPolicy::findOrFail($id);
//        $policy->update($request->only('description_en', 'description_fr', 'description_ar'));
//
//        return response()->json($policy);
//    }
}
