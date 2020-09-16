<?php

use Illuminate\Support\Facades\Route;

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
    Route::get('makaleler/SilinenMakaleler','Back\ArticleController@silinenler')->name('trashed.article');
    Route::resource('makaleler', 'Back\ArticleController');
    Route::get('/switch','Back\ArticleController@switch')->name('switch');
    Route::get('/deleteArticle/{id}','Back\ArticleController@delete')->name('article.delete');
    Route::get('/deleteArticleHard/{id}','Back\ArticleController@hardDelete')->name('article.hardDelete');
    Route::get('/recoveryArticle/{id}','Back\ArticleController@recovery')->name('article.recovery');

    //KATEGORI ROUTE'S
    Route::get('kategoriler','Back\CategoryController@index')->name('category.index');

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

