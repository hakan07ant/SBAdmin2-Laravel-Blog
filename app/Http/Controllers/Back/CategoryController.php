<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('back.category.index', compact('categories'));
    }

    public function create(Request $request)
    {

        $varmi = Category::whereSlug(str_slug($request->category))->first();

        if ($varmi) {
            toastr()->error('Bu kategori zaten mevcut..', '<i class="fa fa-exclamation-triangle"></i>');
            return redirect()->back();
        }
        //print_r($request->post());
        $category = new Category;
        $category->name = $request->category;
        $category->slug = str_slug($request->category);
        $category->save();
        toastr()->success('Kategori Eklendi', 'Başarılı');
        //return redirect()->route('admin.category.index');
        return redirect()->back();


    }

    public function guncelle(Request $request)
    {
        $isSlug = Category::whereSlug(str_slug($request->slug))->whereNotIn('id', [$request->id])->first();
        $isName = Category::whereName($request->kategori)->whereNotIn('id', [$request->id])->first();

        if ($isSlug or $isName) {
            toastr()->error('Bu kategori zaten mevcut..', '<i class="fa fa-exclamation-triangle"></i>');
            return redirect()->back();
        }
        //print_r($request->post());
        $category = Category::find($request->id);
        $category->name = $request->kategori;
        $category->slug = str_slug($request->slug);
        $category->save();
        toastr()->success('Kategori Eklendi', 'Başarılı');
        //return redirect()->route('admin.category.index');
        return redirect()->back();
    }

    public function switch(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->status = $request->statu == 'true' ? 1 : 0;
        $category->save();
    }

    public function sil(Request $request)
    {
        $category = Category::findOrFail($request->deletedID);
        if ($request->deletedID == 1) {
            toastr()->error('Bu kategori silinemez', 'Hata');
            return redirect()->back();
        }
        $message='';
        $count = $category->articleCount();
        if ($count > 0) {
            Article::where('category_id', $category->id)->update(['category_id' => '1']);
            $defaultCategory = Category::find(1);
            $message='Bu kategoriye ait ' . $count . ' adet makale "' . $defaultCategory->name . '" kategorisine taşındı.';
        }
        toastr()->success($message, 'Kategori Silindi.');
        $category->delete();
        return redirect()->back();
    }

    public function getData(Request $request)
    {
        $category = Category::findOrFail($request->id);
        return response()->json($category);
    }
}
