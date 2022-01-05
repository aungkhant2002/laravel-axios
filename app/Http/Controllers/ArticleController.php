<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreArticleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
//        return $request;
        $validation = Validator::make($request->all(), [
            "name" => "required|min:3",
            "price" => "required|integer|min:100",
            "photo" => "required|file|mimetypes:image/jpeg,image/png",
        ]);

        if ($validation->fails()) {
            return response()->json([
                "status" => "fail",
                "errors" => $validation->errors(),
            ]);
        }

        $photo = $request->file("photo");
        $newName = uniqid()."_photo.".$photo->extension();
        $photo->storeAs("public/photo", $newName);
        $img = Image::make($photo);
        $img->fit(300, 300)->save("storage/thumbnail/".$newName);



        $article = new Article();
        $article->name = $request->name;
        $article->price = $request->price;
        $article->photo = $newName;
        $article->save();

        $article->original_photo = asset("storage/photo/".$article->photo);
        $article->thumbnail = asset("storage/thumbnail/".$article->photo);
        $article->time = $article->created_at->diffForHumans();

        return response()->json([
            "status" => "success",
            "info" => $article,
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $article->original_photo = asset("storage/photo/".$article->photo);
        $article->thumbnail = asset("storage/thumbnail/".$article->photo);
        return $article;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateArticleRequest $request
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }
}
