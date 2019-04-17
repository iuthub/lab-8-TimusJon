<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', [
    'uses' => 'PostController@getIndex',
    'as' => 'blog.index'
]);

Route::get('post/{id}', [
    'uses' => 'PostController@getPost',
    'as' => 'blog.post'
]);

Route::get('about', function () {
    return view('other.about');
})->name('other.about');

Route::post('create', function (
    \Illuminate\Http\Request $request,
    \Illuminate\Validation\Factory $validator
) {
    $validation = $validator->make($request->all(), [
        'title' => 'required|min:5',
        'content' => 'required|min:10'
    ]);
    if ($validation->fails()) {
        return redirect()->back()->withErrors($validation);
    }
    return redirect()
        ->route('admin.index')
        ->with('info', 'Post created , Title: ' . $request->input('title'));
})->name('admin.create');

Route::post('edit', function (
    \Illuminate\Http\Request $request,
    \Illuminate\Validation\Factory $validator
) {
    $validation = $validator->make($request->all(), [
        'title' => 'required|min:5',
        'content' => 'required|min:10'
    ]);
    if ($validation->fails()) {
        return redirect()->back()->withErrors($validation);
    }
    return redirect()
        ->route('admin.index')
        ->with('info', 'Post edited , new Title: ' . $request->input('title'));
})->name('admin.update');


Route::group(['prefix' => 'admin'], function () {
    Route::get('', [
        'uses' => 'PostController@getAdminIndex',
        'as' => 'admin.index'
    ]);

    Route::get('create', [
        'uses' => 'PostController@getAdminCreate',
        'as' => 'admin.create'
    ]);

    Route::post('create', [
        'uses' => 'PostController@postAdminCreate',
        'as' => 'admin.create'
    ]);

    Route::get('edit/{id}', [
        'uses' => 'PostController@getAdminEdit',
        'as' => 'admin.edit'
    ]);

    Route::post('edit', [
        'uses' => 'PostController@postAdminUpdate',
        'as' => 'admin.update'
    ]);
});
