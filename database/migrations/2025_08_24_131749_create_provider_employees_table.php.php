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
        Schema::create('provider_employees', function (Blueprint $table) {
            $table->id();
            $table->string('provider_name');
            $table->string('provider_employee_id');
            $table->string('tracktik_employee_id');
            $table->timestamps();

            $table->unique(['provider_name', 'provider_employee_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_employees');
    }
};
