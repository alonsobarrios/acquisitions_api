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
        Schema::create('acquisitions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("budget");
            $table->string("unit");
            $table->string("type");
            $table->unsignedInteger("quantity");
            $table->unsignedBigInteger("unit_value");
            $table->date("date");
            $table->string("supplier");
            $table->text("documentation")->nullable();
            $table->boolean("status")->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acquisitions');
    }
};
