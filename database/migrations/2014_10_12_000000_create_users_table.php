<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
//            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
//            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();

            // $table->index('role_id', 'user_role_idx');
            // $table->foreign('role_id', 'user_role_fk')->on('roles')->references('id');

            $table->foreignId('role_id')->index()->constrained('roles');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
