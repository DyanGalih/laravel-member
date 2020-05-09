<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id')
                ->comment('relation to members table');
            $table->text('address')
                ->comment('Member Address');
            $table->string('city')
                ->comment('address city');
            $table->string('state')
                ->comment('address state');
            $table->string('post_code')
                ->comment('Address post code');
            $table->string('country')
                ->comment('Member Country');
            $table->enum('isDefault', ['true', 'false'])
                ->comment('Address default');
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
            $table->foreign('member_id')->references('id')->on('members');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_addresses');
    }
}
