<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{

    // Get and Show all listings
    public function index(){
        return view('listings.index', [
            "listings" => Listing::latest()->filter(request(["tag", "search"]))->paginate(6) // latest() will get the listings in a decending order, filter() will filter them based on the attributes you give. paginate(num) will determine how many items it shows per page, based on the number you give it.
        ]); // there is also ->simplePaginate(), which changes the style of the page controller shown on the web page.
    }

    // Show a single listing
    public function show(Listing $listing){
        return view("listings.show", ["listing" => $listing]);
    }

    // Show listing creation form.
    public function create(){
        return view("listings.create");
    }

    // Store new listing
    public function store(Request $request){
        $formFields = $request->validate([ // validating the data
            "title" => "required",
            "company" => ["required", Rule::unique("listings", "company")], // Rule:unique(table name, column name)
            "location" => "required",
            "website" => "required",
            "email" => ["required", "email"], // "email means the data should be formatted like an email.
            "tags" => "required",
            "description" => "required"
        ]);

        if($request->hasFile("logo")){
            $formFields["logo"] = $request->file("logo")->store("logos", "public"); // request->file() will add it to the $formFields, while store() will save it to our public folder.
        }

        $formFields["user_id"] = auth()->id();

        Listing::create($formFields);

        return redirect("/")->with("message", "Listing created successfully"); // with() is a way of sending a flash message. You could also use session()->flash()
    }

    // Show Edit form
    public function edit(Listing $listing){
        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()){
            abort(403, "Unauthorized Action");
        }

        return view("listings.edit", ["listing" => $listing]);
    }

    // Update listing
    public function update(Request $request, Listing $listing){
        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()){
            abort(403, "Unauthorized Action");
        }

        $formFields = $request->validate([ // validating the data
            "title" => "required",
            "company" => "required",
            "location" => "required",
            "website" => "required",
            "email" => ["required", "email"], 
            "tags" => "required",
            "description" => "required"
        ]);

        if($request->hasFile("logo")){
            $formFields["logo"] = $request->file("logo")->store("logos", "public");
        }

        $listing->update($formFields);

        return back()->with("message", "Listing updated successfully");
    }

    // Delete Listing
    public function destroy(Listing $listing){
        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()){
            abort(403, "Unauthorized Action");
        }
        
        $listing->delete();
        return redirect("/")->with("message", "Listing deleted successfully");
    }

    // Manage Listings
    public function manage(){
        return view("listings.manage", ["listings" => auth()->user()->listings()->get()]);
    }
}
