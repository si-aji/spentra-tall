<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'admin_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('admin_id')->nullable()->after('is_admin');
                $table->foreign('admin_id')
                    ->references('id')
                    ->on('admins')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users', 'admin_id')) {
                Schema::table('users', function (Blueprint $table) {
                $table->dropForeign('users_admin_id_foreign');
                $table->dropColumn('admin_id');
            });
        };
    }
};
