<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $t) {
            $t->id();
            $t->string('image');
            $t->string('tag')->nullable();
            $t->string('tag_en')->nullable();
            $t->string('title');
            $t->string('title_en')->nullable();
            $t->text('text')->nullable();
            $t->text('text_en')->nullable();
            $t->string('button_text')->nullable();
            $t->string('button_text_en')->nullable();
            $t->string('button_url')->nullable();
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
