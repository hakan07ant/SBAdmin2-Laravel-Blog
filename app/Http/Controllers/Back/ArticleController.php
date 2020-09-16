<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\File;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'ASC')->get();
        return view('back.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('back.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        //dd($request->post());
        $article = new Article;
        $article->title = $request->title;
        $article->category_id = $request->category;
        $article->content = $request->contentNot;
        $article->slug = str_slug($request->title);

        if ($request->hasFile('image')) {
            $imageName = str_slug($request->title) . date('dmY_His') . '.' . $request->image->getClientOriginalExtension();
            //dd($imageName);
            $request->image->move(public_path('uploads'), $imageName);
            $article->image = 'uploads/' . $imageName;
        }
        $article->save();
        toastr()->success('Başarılı.', 'Makale Başarı ile oluşturuldu.');
        return redirect()->route('admin.makaleler.index');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        //dd($article);
        $categories = Category::all();
        return view('back.articles.update', compact('categories', 'article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'min:3',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);
        //dd($request->post());
        $article = Article::findOrFail($id);
        $article->title = $request->title;
        $article->category_id = $request->category;
        $article->content = $request->contentNot;
        $article->slug = str_slug($request->title);

        if ($request->hasFile('image')) {
            $imageName = str_slug($request->title) . date('dmY_His') . '.' . $request->image->getClientOriginalExtension();
            //dd($imageName);
            $request->image->move(public_path('uploads'), $imageName);
            $article->image = 'uploads/' . $imageName;
        }
        $article->save();
        toastr()->success('Başarılı.', 'Makale Başarı ile güncellendi.');
        return redirect()->route('admin.makaleler.index');


    }

    public function switch(Request $request)
    {
        $article = Article::findOrFail($request->id);
        $article->status = $request->statu == 'true' ? 1 : 0;
        //toastr()->success('Başarılı.', 'Makale Başarı ile oluşturuldu.');
        $article->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Article::find($id)->delete();
        toastr('Makale \"Silinen Makaleler\" bölümüne taşındı');
        return redirect()->route('admin.makaleler.index');
    }

    public function hardDelete($id)
    {
        $articles = Article::onlyTrashed()->find($id);
        if (File::exists($articles->image)) {
            File::delete(public_path($articles->image));
        }

        $articles->forceDelete();
        toastr('Makale Tamamen Silindi Dostum...');
        return redirect()->route('admin.trashed.article');
    }

    public function silinenler()
    {
        $articles = Article::onlyTrashed()->orderBy('deleted_at', 'ASC')->get();
        return view('back.articles.trashed', compact('articles'));
    }

    public function recovery($id)
    {
        Article::onlyTrashed()->find($id)->restore();
        toastr()->success('Başarılı.', 'Silme İşlemi Geri Alındı');
        return redirect()->route('admin.trashed.article');

    }

    public function destroy($id)
    {
        //
    }
}
