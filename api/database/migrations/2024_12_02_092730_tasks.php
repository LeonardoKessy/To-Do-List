<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->charset('utf8mb4');
                $table->collation('utf8mb4_unicode_ci');
                
                $table->id();
                $table->string('username');
                $table->string('email');
                $table->string('password');
            });
        }

        if (!Schema::hasTable('tasks')) {
            Schema::create('tasks', function (Blueprint $table) {
                $table->charset('utf8mb4');
                $table->collation('utf8mb4_unicode_ci');
    
                $table->id();
                $table->string('name');
                $table->string('detail');
                $table->string('color');
                $table->unsignedBigInteger('user_id');
    
                $table->foreign('user_id')->references('id')->on('users');
            });       
        }
    }

    public function down(): void
    {
        //
    }
};
