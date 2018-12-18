<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtrafieldsToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            //
            //owner_id
            //is_available
            //dibs_id
            //on_street
            //instructions
            $table->unsignedInteger('owner_id')->nullable();
            $table->foreign('owner_id')->references('id')->on('users');
            $table->unsignedInteger('dibs_caller_id')->nullable();
            $table->foreign('dibs_caller_id')->references('id')->on('users');
            $table->boolean('is_available')->default(true);
            $table->boolean('on_street')->default(true);
            $table->string('pickup_instructions')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            //
            $table->dropColumn('owner_id');
            $table->dropColumn('dibs_caller_id');
            $table->dropColumn('is_available');
            $table->dropColumn('on_street');
            $table->dropColumn('pickup_instructions');
        });
    }
}
