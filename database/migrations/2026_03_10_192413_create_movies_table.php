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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(true);

            $table->string('title_uk');
            $table->string('title_en');

            $table->text('description_uk')->nullable();
            $table->text('description_en')->nullable();

            $table->string('poster')->nullable();
            $table->json('screenshots')->nullable();
            $table->string('youtube_trailer_id')->nullable();
            $table->unsignedSmallInteger('release_year')->nullable();
            $table->datetime('view_start_at')->nullable();
            $table->datetime('view_end_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
