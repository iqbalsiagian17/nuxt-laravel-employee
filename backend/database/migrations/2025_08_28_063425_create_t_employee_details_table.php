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
        Schema::create('t_employee_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('work_unit_id')->nullable();
            $table->string('echelon', 20)->nullable();
            $table->string('rank', 20)->nullable();
            $table->string('workplace', 150)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('tax_number', 50)->nullable(); 
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('t_employees')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('t_positions')->onDelete('cascade');
            $table->foreign('work_unit_id')->references('id')->on('t_work_units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_employee_details');
    }
};
