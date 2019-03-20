<?php

use HuhSchool\User\Domain\UserService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("user_id");
            $table->boolean("has_administration_rights")->default(false);
            $table->boolean("has_onboarding_rights")->default(false);
            $table->boolean("has_view_user_rights")->default(false);
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users");
        });

        $userService = new UserService();
        for ($i = 0; $i < 50; $i++) {
            $userService->create([
                "name" => "Test" . $i,
                "email" => "test" . $i . "@test.com",
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
