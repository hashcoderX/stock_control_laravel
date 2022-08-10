<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFreeIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('free_issues', function (Blueprint $table) {
            $table->id();
            $table->string("lable", 245);
            $table->string("purchase_product", 245);
            $table->string("freeproduct", 245);
            $table->string("purchesqty", 20);
            $table->string("freeqty", 20);
            $table->string("lowlim", 20);
            $table->string("upperlim", 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('free_issues');
    }
}
