<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignationModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designation_modules', function (Blueprint $table) {
          
            $table->bigIncrements('id');
            $table->unsignedBigInteger('designation_id');
            $table->unsignedBigInteger('module_id');
            $table->boolean('add');
            $table->boolean('edit');
            $table->boolean('delete');
            $table->boolean('download');
            $table->boolean('upload');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('designation_modules');
    }
}
