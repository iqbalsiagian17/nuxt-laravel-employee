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
        Schema::create('t_employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_number', 50)->unique()->nullable(); 
            $table->string('full_name', 150)->nullable();
            $table->string('birth_place', 100)->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['M', 'F'])->nullable(); 
            $table->text('address')->nullable();
            $table->string('photo')->nullable(); 
            $table->unsignedBigInteger('religion_id')->nullable();
            
            $table->timestamps();

            $table->foreign('religion_id')->references('id')->on('t_religions')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_employees');
    }
};
