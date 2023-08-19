<?php

use Botble\ACL\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ec_shipment_histories', function (Blueprint $table) {
            $table->string('user_type', 255)->default(addslashes(User::class));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ec_shipment_histories', function (Blueprint $table) {
            $table->dropColumn('user_type');
        });
    }
};
