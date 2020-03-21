<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /** @var string テーブル名 */
    private const TABLE_NAME = 'roles';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->bigIncrements('id')
                ->comment('ロールID');

            $table->string('name', 30)
                ->unique()
                ->comment('ロール名');

            $table->unsignedTinyInteger('is_viewable')
                ->default(0)
                ->comment('閲覧権限の有無 (0: なし, 1: あり');

            $table->unsignedTinyInteger('is_editable')
                ->default(0)
                ->comment('編集権限の有無 (0: なし, 1: あり');

            $table->timestamps();
        });

        \DB::statement("ALTER TABLE " . self::TABLE_NAME . " COMMENT 'ロール'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
}
