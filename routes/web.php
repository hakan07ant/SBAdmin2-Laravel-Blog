<?php

use Illuminate\Support\Facades\Route;

Route::get('sitebakimda',function (){
    return view('front.bakim');
});

/*
|--------------------------------------------------------------------------
| BackendRoute
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('isLogin')->group(function () {
    Route::get('giris', 'Back\AuthController@login')->name('login');
    Route::post('giris', 'Back\AuthController@loginPost')->name('login.post');
});

Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function () {
    Route::get('panel', 'Back\Dashboard@index')->name('dashboard');

    //MAKALE ROUTE'S

    Route::get('/switchArticle', 'Back\ArticleController@durumSwitch')->name('DurumSwitch');
    Route::get('makaleler/SilinenMakaleler', 'Back\ArticleController@silinenler')->name('trashed.article');
    Route::resource('makaleler', 'Back\ArticleController');
    Route::get('/deleteArticle/{id}', 'Back\ArticleController@delete')->name('article.delete');
    Route::get('/deleteArticleHard/{id}', 'Back\ArticleController@hardDelete')->name('article.hardDelete');
    Route::get('/recoveryArticle/{id}', 'Back\ArticleController@recovery')->name('article.recovery');

    //KATEGORI ROUTE'S
    Route::get('kategoriler', 'Back\CategoryController@index')->name('category.index');
    Route::post('kategoriler/create', 'Back\CategoryController@create')->name('category.create');
    Route::get('/kategori/status', 'Back\CategoryController@switch')->name('category.switch');
    Route::get('/kategori/getData', 'Back\CategoryController@getData')->name('category.getdata');
    Route::post('kategori/guncelle', 'Back\CategoryController@guncelle')->name('category.update');
    Route::post('kategori/sil', 'Back\CategoryController@sil')->name('category.sil');

    //SAYFALAR ROUTE'S
    Route::get('/switchPage', 'Back\PagesController@durumSwitch')->name('DurumSwitchPage');
    Route::get('sayfalar/SilinenSayfa', 'Back\PagesController@silinenler')->name('trashed.page');
    Route::resource('sayfalar', 'Back\PagesController');
    Route::get('/deleteSayfa/{id}', 'Back\PagesController@delete')->name('sayfa.delete');
    Route::get('/deleteArticleHard/{id}', 'Back\PagesController@hardDelete')->name('sayfa.hardDelete');
    Route::get('/recoveryArticle/{id}', 'Back\PagesController@recovery')->name('sayfa.recovery');
    Route::get('/sayfa/sirala', 'Back\PagesController@sirala')->name('sayfa.sirala');

    //CONFIG ROUTE'S
    Route::post('/ayarlar/update', 'Back\ConfigController@update')->name('config.update');
    Route::get('/ayarlar', 'Back\ConfigController@index')->name('config.index');
    //CIKIS ROUTE'S
    Route::get('cikis', 'Back\AuthController@logout')->name('logout');
});


/*
|--------------------------------------------------------------------------
| Front Route
|--------------------------------------------------------------------------
*/

Route::get('/iletisim', 'Front\Homepage@contact')->name('contact');
Route::post('/iletisim', 'Front\Homepage@contactpost')->name('contact.post');
Route::get('/', 'Front\Homepage@index')->name('homepage');
Route::get('/sayfa', 'Front\Homepage@index');
Route::get('/kategori/{category}', 'Front\Homepage@category')->name('category');
Route::get('/{category}/{slug}', 'Front\Homepage@single')->name('single');
Route::get('/{sayfa}', 'Front\Homepage@page')->name('page');

