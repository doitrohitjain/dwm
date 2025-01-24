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
		Schema::create('reports', function (Blueprint $table) {
			$table->id();
			$table->date('start_date');
			$table->date('end_date');
			$table->unsignedBigInteger('generated_by'); // Admin ID
			$table->text('details');
			$table->timestamps();

			$table->foreign('generated_by')->references('id')->on('users')->onDelete('cascade');
		});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
