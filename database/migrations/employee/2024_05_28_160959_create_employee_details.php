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
        Schema::create('employee_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_owner_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('designation_id');
            $table->foreign("company_owner_id")->references("id")->on("users");
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("designation_id")->references("id")->on("employee_designation");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_details');
    }
};
