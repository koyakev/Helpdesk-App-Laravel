<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {  
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id')->nullable()->unique();
            $table->string('fname')->nullable();
            $table->string('mname')->nullable();
            $table->string('lname')->nullable();
            $table->string('email')->nullable();
            $table->string('username');
            $table->string('password');
            $table->integer('department');
            $table->string('position')->nullable();
            $table->integer('status')->default(1);
            $table->integer('active')->default(0);
            $table->enum('role', ['L1', 'L2', 'L3', 'L4'])->default('L1');
            $table->integer('failed_login_attempts')->default(0);
            $table->timestamps();
        });

        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('department_description');
            $table->string('department_code');
            $table->string('manager_id')->nullable();
            $table->timestamps();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
