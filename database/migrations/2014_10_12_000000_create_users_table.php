<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('user_name')->unique();
            $table->string('user_phone')->unique();
            $table->string('user_password');
            $table->string('user_image')->default(false);
            $table->string('user_first_name')->nullable();
            $table->string('user_last_name')->nullable();
            $table->string('user_father_name')->nullable();
            $table->string('user_address')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->timestamps();
        });

        \App\Models\User::query()
            ->create([
                "user_name"         => "admin",
                "user_phone"        => "+998972113355",
                "user_password"     => Crypt::encrypt("admin"),
                "is_admin"          => true
            ]);
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
