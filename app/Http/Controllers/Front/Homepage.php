<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Mail;

//Models
use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use App\Models\Contact;

class Homepage extends Controller
{
    public function __construct()
    {
        view()->share('pages', Page::orderBy('order', 'ASC')->get());
        view()->share('categories', Category::inRandomOrder()->get());
    }

    public function index()
    {
        $data['articles'] = Article::orderBy('created_at', 'DESC')->paginate(2);
        $data['articles']->withPath(url('sayfa'));

        return view('front.homepage', $data);
    }

    public function single($category, $slug)
    {
        $category = Category::whereSlug($category)->first() ?? abort(403, 'Böyle Bir Kategori Bulunamadı.');
        $article = Article::whereSlug($slug)->whereCategoryId($category->id)->first() ?? abort(403, 'Böyle Bir Sayfa Bulunamadı.');
        $article->increment('hit');

        $data['article'] = $article;
        // dd($article);
        return view('front.single', $data);
    }

    public function category($slug)
    {
        $category = Category::whereSlug($slug)->first() ?? abort(403, 'Böyle Bir Kategori Bulunamadı.');
        $data['category'] = $category;
        $data['articles'] = Article::where('category_id', $category->id)->orderBy('created_at', 'DESC')->paginate(1);
        return view('front.category', $data);
    }

    public function page($slug)
    {
        $page = Page::whereSlug($slug)->first() ?? abort(403, 'Böyle Bir Kategori Bulunamadı.');
        $data['page'] = $page;
        return view('front.page', $data);
    }

    public function contact()
    {
        return view('front.contact');
    }

    public function contactpost(Request $request)
    {
        $rules = [
            'name' => 'required|min:5',
            'email' => 'required|email',
            'topic' => 'required',
            'message' => 'required|min:10'
        ];

        $validate = Validator::make($request->post(), $rules);

        if ($validate->fails()) {
            return redirect()->route('contact')->withErrors($validate)->withInput();
        }

        Mail::send([],[], function ($message) use ($request){
            $message->from('iletisim@hakanefendi.com','Blog Sitesi');
            $message->to('iletisim@hakanefendi.com');
            $message->setBody('Mesajı gönderen: '.$request->name.'<br>
            Mesajı Gönderen Mail: '.$request->email.'<br>
            Mesajı Konusu: '.$request->topic.'<br>
            Mesajı : '.$request->message.'<br>
            Tarih : '.now().'<br>','text/html');
            $message->subject($request->name.' mesaj gonderdi');
        });

        /*
        $contact = new Contact;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->topic = $request->topic;
        $contact->message = $request->message;
        $contact->save();
*/

        return redirect()->route('contact')->with('success', 'Mesajınız tarafımıza iletildi. Teşekkür ederiz.');

    }
}
