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
        Schema::disableForeignKeyConstraints();

        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('title', 150)->index();
            $table->string('original_title', 150)->index();
            $table->char('original:language', 2)->index();
            $table->text('overview')->nullable();
            $table->decimal('popularity', 20, 3)->nullable();
            $table->date('release_date')->nullable();
            $table->decimal('revenue', 20, 3)->nullable();
            $table->integer('runtime')->nullable();
            $table->integer('budget')->nullable()->index();
            $table->decimal('vote_average', 20, 3)->nullable()->index();
            $table->integer('vote_count')->nullable()->index();
            $table->json('json_response');
            $table->bigInteger('external_id')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
