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
        Schema::create('book_borrows', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('book_id')->unsigned()->index();
            $table->foreign('book_id')->references('id')->on('books');
            $table->bigInteger('borrower_id')->unsigned()->index();
            $table->foreign('borrower_id')->references('id')->on('borrowers');
            $table->date('borrowed_at');
            $table->date('due_date');
            $table->timestamp('returned_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_borrows');
    }
};
