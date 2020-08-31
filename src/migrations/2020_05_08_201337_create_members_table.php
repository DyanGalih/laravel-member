<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('identity_type_id')
                ->comment('relation to identity_types');
            $table->string('identity')
                ->comment('User ID such as Driver Licence');
            $table->string('name')
                ->comment('Member Name');
            $table->string('email', 100)
                ->comment('Member email');
            $table->string('phone', 20)
                ->comment('Member Phone Number');
            $table->string('phone_alternative')
                ->comment('Member Phone Alternative');
            $table->enum('sex', ['M', 'F', 'O'])
                ->nullable(false)
                ->default('O')
                ->comment('Member Sex');
            $table->date('dob')
                ->comment('Day Of Birth');
            $table->unsignedInteger('timezone_id')
                ->comment('relation to timezones table');
            $table->unsignedInteger('language_id')
                ->comment('relation to languages table');
            $table->unsignedBigInteger('content_id')
                ->comment('relation to contents table for detail information');
            $table->unsignedBigInteger('user_id')
                ->comment('Relation to users table as last update user');
            $table->unsignedBigInteger('creator_id')
                ->comment('Relation to users table as creator the data');
            $table->unsignedBigInteger('owner_id')
                ->comment('Relation to users table as Owner the data');
            $table->timestamps();

            /**
             * relation
             */

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('owner_id')->references('id')->on('users');
            $table->foreign('identity_type_id')->references('id')->on('identity_types');
            $table->foreign('timezone_id')->references('id')->on('time_zones');
            $table->foreign('language_id')->references('id')->on('languages');
            $table->foreign('content_id')->references('id')->on('contents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
