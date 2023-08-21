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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('numberRating')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('feedback_id')->nullable();

            $table->index('user_id','rating_user_idx');
            $table->index('product_id','rating_product_idx');
            $table->index('feedback_id','rating_feedback_idx');

            $table->foreign('user_id','rating_user_fk')->on('users')->references('id');
            $table->foreign('product_id','rating_product_fk')->on('products')->references('id');
            $table->foreign('feedback_id','rating_feedback_fk')->on('feedback')->references('id')->onDelete('cascade');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
};
