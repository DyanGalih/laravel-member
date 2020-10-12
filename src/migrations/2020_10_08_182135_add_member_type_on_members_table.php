<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMemberTypeOnMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table){
            $table->unsignedSmallInteger('type_id')
                ->after('id')
                ->nullable(true)
                ->comment('relation to member types table');

            /**
             * relation
             */

            $table->index(['name']);
            $table->index(['phone']);
            $table->index(['sex']);
            $table->index(['owner_id', 'type_id']);
            $table->index(['creator_id','type_id']);

            $table->foreign('type_id')->references('id')->on('member_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $driver = Schema::connection($this->getConnection())->getConnection()->getDriverName();

        if ($driver != 'sqlite') {
            Schema::table('members', function (Blueprint $table) {
                $table->dropForeign(['type_id']);
                $table->dropColumn(['type_id']);
                $table->dropIndex(['name']);
                $table->dropIndex(['phone']);
                $table->dropIndex(['sex']);
                $table->dropIndex(['owner_id', 'type_id']);
                $table->dropIndex(['creator_id','type_id']);
            });
        }
    }
}
