<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRatingsToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        $table->integer('positive_ratings')->default(0);
        $table->integer('negative_ratings')->default(0);
        $table->float('approval_rating')->default(0.00); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('positive_ratings');
            $table->dropColumn('negative_ratings');
            $table->dropColumn('approval_rating');
        });
    }
}
