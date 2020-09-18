<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Page;


class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::orderBy('order', 'ASC')->get();
        return view('back.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages = Page::all();
        return view('back.pages.create', compact('pages'));
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
        $maxOrder = Page::max('order') + 1;
        $page = new Page;
        $page->title = $request->title;
        $page->content = $request->contentNot;
        $page->order = $maxOrder;
        $page->slug = str_slug($request->title);

        if ($request->hasFile('image')) {
            $imageName = str_slug($request->title) . date('dmY_His') . '.' . $request->image->getClientOriginalExtension();
            //dd($imageName);
            $request->image->move(public_path('uploads/pages'), $imageName);
            $page->image = 'uploads/pages/' . $imageName;
        }
        $page->save();
        toastr()->success('Başarılı.', 'Sayfa Başarı ile oluşturuldu.');
        return redirect()->route('admin.sayfalar.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('back.pages.update', compact('page', 'page'));
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
        $page = Page::findOrFail($id);
        $page->title = $request->title;
        $page->content = $request->contentNot;
        $page->slug = str_slug($request->title);

        if ($request->hasFile('image')) {
            if (File::exists($page->image)) {
                File::delete(public_path($page->image));
            }
            $imageName = str_slug($request->title) . date('dmY_His') . '.' . $request->image->getClientOriginalExtension();
            //dd($imageName);
            $request->image->move(public_path('uploads/pages'), $imageName);
            $page->image = 'uploads/pages/' . $imageName;
        }
        $page->save();
        toastr()->success('Başarılı.', 'Makale Başarı ile güncellendi.');
        return redirect()->route('admin.sayfalar.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //return $id;
    }

    public function delete($id)
    {
        Page::find($id)->delete();
        toastr('Sayfa \"Silinen Sayfalar\" bölümüne taşındı');
        return redirect()->route('admin.sayfalar.index');
    }

    public function silinenler()
    {
        $pages = Page::onlyTrashed()->orderBy('deleted_at', 'ASC')->get();
        return view('back.pages.trashed', compact('pages'));
    }

    public function hardDelete($id)
    {
        $pages = Page::onlyTrashed()->find($id);
        if (File::exists($pages->image)) {
            File::delete(public_path($pages->image));
        }

        $pages->forceDelete();
        toastr('Sayfa Tamamen Silindi Dostum...');
        return redirect()->route('admin.trashed.page');
    }

    public function recovery($id)
    {
        Page::onlyTrashed()->find($id)->restore();
        toastr()->success('Başarılı.', 'Silme İşlemi Geri Alındı');
        return redirect()->route('admin.trashed.page');
    }

    public function durumSwitch(Request $request)
    {
        $page = Page::findOrFail($request->id);
        $page->status = $request->statu == 'true' ? 1 : 0;
        //toastr()->success('Başarılı.', 'Makale Başarı ile oluşturuldu.');
        $page->save();
    }

    public function sirala(Request $request){

        foreach ($request->get('sayfaTR') as $key => $order){
            Page::whereId($order)->update(['order'=>$key]);
        }

    }
}
