<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMemberAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_addresses', function (Blueprint $table) {
            $table->string('code', 50)
                ->comment('address code')
                ->nullable(false)
                ->after('id');

            $table->string('name', 50)
                ->after('code')
                ->comment('Member address name')
                ->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (config('database.default') != "sqlite") {
            $columns = [];
            if (Schema::hasColumn('member_addresses', 'code')) {
                array_push($columns, 'code');
            }
            if (Schema::hasColumn('member_addresses', 'name')) {
                array_push($columns, 'name');
            }

            if (count($columns) > 0) {
                Schema::table('member_addresses', function (Blueprint $table) use ($columns) {
                    $table->dropColumn($columns);
                });
            }
        }
    }
}
