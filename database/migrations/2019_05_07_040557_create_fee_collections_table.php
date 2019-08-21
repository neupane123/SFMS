<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeeCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_collections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('asess_id');
            $table->unsignedInteger('grade_id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('fee_type');
            $table->string('months')->nullable();
            $table->unsignedDecimal('tamount', 8, 2);
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
        Schema::dropIfExists('fee_collections');
    }
}
