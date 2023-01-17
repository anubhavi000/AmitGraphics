<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnsInModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->bigInteger('company_id')->nullable()->after('module_name');
            $table->bigInteger('sequence')->nullable()->after('module_name');
            $table->string('route_name')->nullable()->after('module_name');
            $table->string('icon')->nullable()->after('module_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn('sequence');
            $table->dropColumn('route_name');
            $table->dropColumn('icon');
        });
    }
}
