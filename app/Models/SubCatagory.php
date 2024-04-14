<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCatagory extends Model
{
    use HasFactory;
  

    protected $fillable = [
        'name',
        'slug',
        'status',
        'catagorie_id'
    ];

   
    public function catagory()
    {
        return $this->belongsTo(Catagory::class);
    }

    
}
