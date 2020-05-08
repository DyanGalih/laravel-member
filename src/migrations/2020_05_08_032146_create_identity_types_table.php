<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdentityTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('identity_types', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name', 50)
                ->unique()
                ->comment('identity type name');
            $table->unsignedBigInteger('user_id')
                ->comment('relation to users table');
            $table->timestamps();

            /**
             * relation
             */

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('identity_types');
    }
}
