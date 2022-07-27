<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing  

// All Listings
// Route::get('/', function () {
//     return view('listings', [
//         // "heading" => "Latest Listings", // Passing a variable called "heading" that has the value "Lastest Listings"
//         "listings" => Listing::all()
//     ]);
// });

// Single Listing
// Route::get("/listings/{id}", function($id){
//     $listing = Listing::find($id);
//     if($listing){
//         return view("listing", ["listing" => $listing]);
//     } else {
//         abort("404");
//     }
// });

// Better way to do the listing above.
// Route::get("/listings/{listing}", function(Listing $listing){
//     return view("listing", ["listing" => $listing]);
// });

// All listings
Route::get('/', [ListingController::class, "index"]);

// Show Create Form
Route::get("/listings/create", [ListingController::class, "create"])
    ->middleware("auth");

// Store new listing
Route::post("/listings", [ListingController::class, "store"])
    ->middleware("auth");

// Show edit form
Route::get("/listings/{listing}/edit", [ListingController::class, "edit"])
    ->middleware("auth");

// Update listing
Route::put("/listings/{listing}", [ListingController::class, "update"])
    ->middleware("auth");

// Delete listing
Route::delete("/listings/{listing}", [ListingController::class, "destroy"])
    ->middleware("auth");

// Manage Listings
Route::get("/listings/manage", [ListingController::class, "manage"])
    ->middleware("auth");

// Single Listing
Route::get("/listings/{listing}", [ListingController::class, "show"]); // NOTE: This line must be at the very bottom, otherwise, it will not allow all the other routes that have "/listings/xxx" to work properly.

// Show Register/Create Form
Route::get("/register", [UserController::class, "create"])
    ->middleware("guest");

// Create New User
Route::post("/users", [UserController::class, "store"]);

// User Logout
Route::post("/logout", [UserController::class, "logout"])
    ->middleware("auth");

// Show Login Form
Route::get("/login", [UserController::class, "login"])
    ->name("login")
    ->middleware("guest");

// Login User
Route::post("/users/authenticate", [UserController::class, "authenticate"]);

// Route::get("/hello", function(){
//     return response("<h1>Hello World</h1>", 200)
//         ->header("Content-Type", "text/plain") // Making the content type "text/plain" will stop the website from loading the h1 element, and instead print it literally.
//         ->header("foo", "bar"); // You can also make custom headers.
// });

// // Adding a variable(wildcard) to the route.
// Route::get("/posts/{id}", function($id){
//     // dd($id); // dd() stands for "Die and Dump", it prints the value given to it, then stops the application, meaning anything written after that will not run.
//     // ddd($id); // ddd() stands for "Die, Dump and Debug". It's similar to dd() but instead of giving us a 404 page, it gives us a report of where it ran and the errors to help us debug.
//     return response("Post " . $id);
// })->where("id", "[0-9]+"); // where() puts a contraint on what can be the value of id using regular expression. In this case we want it to only include numbers.


// // Getting values that are passed like this 127.0.0.1:8000/search/?name=Brad&city=Boston
// Route::get("/search", function(Request $request){
//     // dd($request); // Print all the request content
//     // dd($request->query()); // query() returns the parameters we gave. We can also specify the parameter name to get a specific parameter like this query("city")
//     dd($request->name . " " . $request->city); // You can also do it this way. The way used in the tutorial.
// });