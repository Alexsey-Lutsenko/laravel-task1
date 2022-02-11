<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFertilizersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fertilizers', function (Blueprint $table) {
            $table->id();
            $table->string('fertilizers');
            $table->float('normN',8,2);
            $table->float('normP',8,2);
            $table->float('normK',8,2);
            $table->unsignedBigInteger('culture_id');
            $table->string('region');
            $table->float('price',8,2);
            $table->text('description')->nullable();
            $table->string('purpose');
            $table->timestamps();

            $table->index('culture_id', 'fertilizer_culture_idx');
            $table->foreign('culture_id', 'fertilizer_culture_fk')->on('cultures')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fertilizers');
    }
}
