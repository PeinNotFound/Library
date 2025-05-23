<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->text('summary')->nullable();
            $table->integer('pages');
            $table->date('published_at');
            $table->string('cover')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['available', 'borrowed'])->default('available');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('books');
    }
};