<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *  $table->string("short_description")->nullable()->after("description");
            $table->string("shipping_returns")->nullable()->after("short_description");
            $table->string("related_products")->nullable()->after("shipping_returns");
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text("short_description")->nullable()->after("description")->change();
            $table->text("shipping_returns")->nullable()->after("short_description")->change();
            $table->text("related_products")->nullable()->after("shipping_returns")->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->string("short_description")->nullable()->after("description")->change();
            $table->string("shipping_returns")->nullable()->after("short_description")->change();
            $table->string("related_products")->nullable()->after("shipping_returns")->change();
        });
    }
};
