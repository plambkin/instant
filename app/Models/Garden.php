<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garden extends Model
{
    use HasFactory;

    // Define the fillable fields
    protected $fillable = [
         'user_id',
        'garden_image1', 
        'garden_image2', 
        'stored_at'
    ];

    // Optionally, if you are using custom date formats or want to specify the type of a date field
    //protected $dates = ['stored_at'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
