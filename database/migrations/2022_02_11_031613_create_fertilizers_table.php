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
            $table->string('fertilizer');
            $table->double('normN',8,2);
            $table->double('normP',8,2);
            $table->double('normK',8,2);
            // $table->unsignedBigInteger('culture_id');
            $table->string('region');
            $table->double('price',8,2);
            $table->text('description')->nullable();
            $table->string('purpose');
            $table->timestamps();
            $table->softDeletes();

            // $table->index('culture_id', 'fertilizer_culture_idx');
            // $table->foreign('culture_id', 'fertilizer_culture_fk')->on('cultures')->references('id');

            $table->foreignId('culture_id')->index()->constrained('cultures');
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
