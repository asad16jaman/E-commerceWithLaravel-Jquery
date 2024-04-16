<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catagory extends Model
{
    use HasFactory;

    protected $table = "catagories";
    protected $fillable = ["name","slug","status","catagory_id"];
    public function subCats(){
        return $this->hasMany(SubCatagory::class);
    }


}
