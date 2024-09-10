<?php

namespace App\Http\Controllers;

use App\DataTables\NewsDataTable;
use App\DataTables\UserDataTable;
use App\Models\ExpoPushToken;
use App\Models\News;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(NewsDataTable $dataTable)
    {
        return $dataTable->render('news.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {

        $request->validate([
            'title_fr' => 'nullable',
            'title_ar' => 'nullable',
            'title_en' => 'nullable',
            'description_en' => 'nullable',
            'description_fr' => 'nullable',
            'description_ar' => 'nullable',
            'image' => 'required|file|mimes:png,jpeg,jpg|max:2048'
        ]);

        $news = new News();
        $news->title_ar = $request->title_ar;
        $news->description_ar = $request->description_ar;
        $news->title_fr = $request->title_fr;
        $news->description_fr = $request->description_fr;
        $news->title_en = $request->title_en;
        $news->description_en = $request->description_en;
//        dd('ahla', $news->description_en,$news->description_ar,$news->description_fr);

        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $file_name = time() . $file->getClientOriginalName();
            $file->move(storage_path('app/public/uploads/images'), $file_name);
            $news->image = $file_name;
        }

        $news->save();
        $tokens = ExpoPushToken::pluck('push_token');
        $messages = [
            new ExpoMessage([
                'title' => __('new_article'),
                'body' => __('there_is_a_new_article'),
            ]),
        ];

        foreach ($tokens as $token) {
            try {
                (new Expo)->send($messages)->to($token)->push();
            } catch (\Exception $exception) {
                Log::error($exception->getMessage());
            }
        }

        return redirect()->route('news.index')
            ->with('success', 'News created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $news = News::findOrFail($id);
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $news = News::findOrFail($id);
        return view('news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title_fr' => 'nullable',
            'title_ar' => 'nullable',
            'title_en' => 'nullable',
            'description_en' => 'nullable',
            'description_fr' => 'nullable',
            'description_ar' => 'nullable',
            'image' => 'nullable|file|mimes:png,jpeg,jpg|max:2048'
        ]);

        $news = News::findOrFail($id);

        $news->title_ar = $request->title_ar;
        $news->description_ar = $request->description_ar;
        $news->title_fr = $request->title_fr;
        $news->description_fr = $request->description_fr;
        $news->title_en = $request->title_en;
        $news->description_en = $request->description_en;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filePath = public_path('uploads');
            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move(storage_path('app/public/uploads/images'), $fileName);

            if ($news->image) {
                $oldImagePath = $filePath . '/' . $news->image;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $news->image = $fileName;
        }

        $news->save();

        return redirect()->route('news.index')
            ->with('success', 'News updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = News::findOrFail($id);
        $news->delete();
        return redirect()->route('news.index')->with('success', __('deleted_successfully'));
    }


    public function archive($id)
    {
        $news = News::findOrFail($id);
        $news->is_archive = true;
        $news->save();

        return redirect()->route('news.index')->with('success', 'News archived successfully.');
    }

    public function archives(NewsDataTable $dataTable)
    {
//        $archivedNews = News::where('is_archive', true)->get();
        return redirect()->route('news.index', ["is_archive" => true]);

    }


    public function restore($id)
    {
        $news = News::findOrFail($id);
        $news->is_archive = false;
        $news->save();

        return redirect()->route('news.index')->with('success', 'News restored successfully.');
    }


}
