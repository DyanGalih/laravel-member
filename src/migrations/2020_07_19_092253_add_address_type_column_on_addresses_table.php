<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressTypeColumnOnAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_addresses', function (Blueprint $table) {
            $table->unsignedTinyInteger('type_id')
                ->after('id')
                ->nullable(false)
                ->comment('relation to member address type');

            /**
             * relation
             */

            $table->foreign('type_id')->references('id')->on('address_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (config('database.default') != 'sqlite') {
            $columns = [];
            $foreigns = [];
            if (Schema::hasColumn('member_addresses', 'type_id')) {
                array_push($columns, 'type_id');
                array_push($foreigns, 'type_id');
            }

            if (count($columns)) {
                Schema::table('member_addresses', function (Blueprint $table) use ($foreigns) {
                    $table->dropForeign($foreigns);
                });

                Schema::table('member_addresses', function (Blueprint $table) use ($columns) {
                    $table->dropColumn($columns);
                });
            }
        }
    }
}
