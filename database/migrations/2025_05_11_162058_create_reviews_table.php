<?php
// database/migrations/[...]_create_reviews_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->integer('rating')->between(1, 5);
            $table->text('comment')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'book_id']); // Un utilisateur ne peut commenter qu'une fois
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};