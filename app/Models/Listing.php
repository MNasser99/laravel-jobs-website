<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ["title", "company", "location", "website", "email", "description", "tags", "logo", "user_id"]; // This governs what you're assigning data to when you use mass assignment, aka Listing::create();

    public function scopeFilter($query, array $filters){ // this will help us filter tags and search.
        if($filters["tag"] ?? false){ // if tag is not null
            $query->where("tags", "like", "%" . request("tag") . "%"); // look through the database for any "tags" element that contains the value of request("tag").
        }

        if($filters["search"] ?? false){ // if search is not null
            $query->where("title", "like", "%" . request("search") . "%")
                ->orWhere("description", "like", "%" . request("search") . "%")
                ->orWhere("tags", "like", "%" . request("search") . "%");
        }
    }

    // Relationship to User
    public function user(){
        return $this->belongsTo(User::class, "user_id"); // This is saying that the listing belongs to the user with the id uder_id.
    }
}
