<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// This is where you do your API Routing.
// If you want to see what the code below does, you have to add /api before, so in this case it'll be "http://127.0.0.1:8000/api/posts"

// Route::get("/posts", function(){
//     return response()->json([
//         "posts" => [
//             [
//                 "title" => "Post One",
//                 "content" => "This is my first post"
//             ], 
//             [
//                 "title" => "Post Two",
//                 "content" => "This is my second post"
//             ], 
//             [
//                 "title" => "Post Three",
//                 "content" => "This is my third post"
//             ]
//         ]
//     ]);
// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
