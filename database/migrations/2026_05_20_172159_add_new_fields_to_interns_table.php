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
        Schema::table('interns', function (Blueprint $table) {
            $table->string('university')->nullable();
            $table->integer('request_number')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['Hombre', 'Mujer'])->nullable();
            $table->string('assigned_unit')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('schedule')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interns', function (Blueprint $table) {
            $table->dropColumn([
                'university',
                'request_number',
                'email',
                'phone',
                'birth_date',
                'gender',
                'assigned_unit',
                'start_date',
                'end_date',
                'schedule'
            ]);
        });
    }
};
