<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    /**
     * @OA\Get(
     *     path="/news/popular",
     *     summary="Get popular news",
     *     tags={"News"},
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="The locale for the news items",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="en"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A list of popular news",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="news",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/NewsResource")
     *             )
     *         )
     *     )
     * )
     */
    public function popularNews() : JsonResponse
    {
        $locale = request()->header('Accept-Language', config('app.locale'));
        $news = News::getPopularNews($locale);
        return response()->json([
            'news' => NewsResource::collection($news)
        ]);
    }


    /**
     * @OA\Get(
     *     path="/news",
     *     summary="Get paginated list of news",
     *     tags={"News"},
     *     @OA\Parameter(
     *         name="perPage",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             default=15
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="The locale for the news items",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="en"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A paginated list of news",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="perPage",
     *                 type="integer"
     *             ),
     *             @OA\Property(
     *                 property="nextCursor",
     *                 type="string",
     *                 nullable=true
     *             ),
     *             @OA\Property(
     *                 property="previousCursor",
     *                 type="string",
     *                 nullable=true
     *             ),
     *             @OA\Property(
     *                 property="news",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/NewsResource")
     *             )
     *         )
     *     )
     * )
     */
    public function index() : JsonResponse
    {
        $perPage = request('perPage', config('pagination.per_page'));
        $locale = request()->header('Accept-Language', config('app.locale'));
        $news = News::getNews($locale, $perPage);

        return response()->json([
            'perPage' => $news->perPage(),
            'nextCursor' => $news->nextCursor()?->encode(),
            'previousCursor' => $news->previousCursor()?->encode(),
            'news' => NewsResource::collection($news)
        ]);
    }



    /**
     * @OA\Get(
     *     path="/news/{id}",
     *     summary="Get news by ID",
     *     description="Retrieve a news item by its ID",
     *     tags={"News"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *         description="ID of the news item"
     *     ),
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="The locale for the news item",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="en"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The news item",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="news",
     *                 ref="#/components/schemas/NewsResource"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="News item not found"
     *     )
     * )
     */
    public function getNewsById($id) : JsonResponse
    {
        $locale = request()->header('Accept-Language', config('app.locale'));
        $news = News::findNewsById($id, $locale);
        return response()->json([
            'news' => NewsResource::make($news)
        ]);
    }

}
