<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersAddRoleId extends Migration
{
    /** @var string テーブル名 */
    private const TABLE_NAME = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')
                ->after('name')
                ->comment('ロールID');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            $table->dropForeign('users_role_id_foreign');
            $table->dropColumn('role_id');
        });
    }
}
