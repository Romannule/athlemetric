<?php

use Illuminate\Http\Request;
use App\Association;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api'], function() {
    // Fetch Associations
    Route::get('associations', function() {
        return Association::latest()->orderBy('created_at', 'desc')->get();
    });

    // Get Single Association
    Route::get('association/{id}', function($id) {
        return Association::findOrFail($id);
    });

    // Add Association
    Route::post('association/store', function(Request $request) {
        return Association::create(['name' => $request->input(['name']), 'code' => $request->input(['code'])]);
    });

    // Update Association
    Route::patch('association/{id}', function(Request $request, $id) {
        Association::findOrFail($id)->update(['name' => $request->input(['name']), 'code' => $request->input(['code'])]);
    });

    // Delete Association
    Route::delete('association/{id}', function($id) {
        return Association::destroy($id);
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
