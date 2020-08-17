<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddCodeProfileIdMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table){
            $table->unsignedBigInteger('profile_id')
                ->after('id')
                ->nullable(true)
                ->comment('relation to user for profile purpose');

            $table->string('code', 100)
                ->comment('member code uuid')
                ->after('profile_id')
                ->unique();

            /**
             * relation
             */
            $table->foreign('profile_id')->references('id')->on('users');
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
                $table->dropForeign(['profile_id']);
                $table->dropColumn('profile_id');
            });
        }
    }
}
