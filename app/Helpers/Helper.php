<?php
use App\Models\Catagory;


function getCatagories(){


    return Catagory::with(["subCats"=>function($qr){
        return $qr->select("id","catagory_id","name","status","show_home");
    }])
    ->where(["show_home" => "Yes","status"=>1])->orderBy("name",'desc')->get();

    
}

