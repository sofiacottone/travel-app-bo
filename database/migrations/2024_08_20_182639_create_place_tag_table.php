<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place_tag', function (Blueprint $table) {
            // first column
            $table->unsignedBigInteger('place_id')->nullable();

            $table->foreign('place_id')
                ->references('id')
                ->on('places')
                ->onDelete('cascade');

            // second column
            $table->unsignedBigInteger('tag_id')->nullable();

            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->onDelete('cascade');

            // set primary keys
            $table->primary(['place_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('place_tag');
    }
};
