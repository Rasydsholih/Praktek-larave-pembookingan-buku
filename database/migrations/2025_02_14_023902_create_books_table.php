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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('penerbit');
            $table->string('penulis');
            $table->string('peminjam')->nullable();
            $table->string('judul', 225);
            $table->enum('status', ['dibooking','dipinjam', 'dikembalikan', ])->nullable(); 
            $table->date('tgl_pinjam')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
