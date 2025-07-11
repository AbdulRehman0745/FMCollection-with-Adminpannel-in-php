<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    public function up()
{
    Schema::create('admin', function (Blueprint $table) {
        $table->id(); // Primary key
        $table->string('name'); // Admin's name
        $table->string('email')->unique(); // Unique email
        $table->string('password'); // Password


        $table->string('cnic')->unique(); // CNIC (must be unique)
        $table->text('address')->nullable(); // Admin's address (optional)

        $table->timestamps(); // created_at and updated_at
    });
}

public function down()
{
    Schema::dropIfExists('admin');
}
}
