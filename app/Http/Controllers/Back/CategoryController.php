<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

        if ($varmi){
            toastr()->error('Bu kategori zaten mevcut..','<i class="fa fa-exclamation-triangle"></i>');
            return redirect()->back();
        }
        //print_r($request->post());
        $category->name = $request->category;
        $category = new Category;
        $category->slug = str_slug($request->category);
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
}
