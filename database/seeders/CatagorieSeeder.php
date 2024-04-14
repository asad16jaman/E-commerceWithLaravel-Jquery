<?php

namespace Database\Seeders;

use App\Models\Catagory;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CatagorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i <30 ; $i++) { 
            $fk = Faker::create();
            $ob = new Catagory;
            $ob->name = $fk->name;
            $ob->slug = Str::of($ob->name)->slug('-');
            $ob->status = 1;
            $ob->save();
        }
    }
}
