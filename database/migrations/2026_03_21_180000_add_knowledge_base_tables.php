<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('knowledge_categories', function (Blueprint $table): void {
            $table->string('id', 36)->primary();
            $table->string('slug', 190)->unique();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('accent_color', 20)->nullable();
            $table->integer('sort_order')->default(0);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('knowledge_articles', function (Blueprint $table): void {
            $table->string('id', 36)->primary();
            $table->string('category_id', 36);
            $table->string('slug', 190)->unique();
            $table->string('title', 255);
            $table->enum('article_type', ['DOCUMENT', 'INSTRUCTION', 'RULE', 'FAQ'])->default('DOCUMENT');
            $table->enum('visibility_scope', ['ALL', 'STUDENT', 'LEADER', 'ADMIN'])->default('ALL');
            $table->enum('status', ['DRAFT', 'PUBLISHED'])->default('DRAFT');
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->integer('estimated_minutes')->nullable();
            $table->string('author_id', 36)->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('body');
            $table->text('search_keywords')->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('category_id', 'fk_knowledge_articles_category')->references('id')->on('knowledge_categories')->cascadeOnDelete();
            $table->foreign('author_id', 'fk_knowledge_articles_author')->references('id')->on('users')->nullOnDelete();
            $table->index(['category_id', 'status'], 'idx_knowledge_articles_category_status');
            $table->index(['article_type', 'status'], 'idx_knowledge_articles_type_status');
            $table->index(['visibility_scope', 'status'], 'idx_knowledge_articles_visibility_status');
            $table->index(['is_featured', 'status'], 'idx_knowledge_articles_featured_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('knowledge_articles');
        Schema::dropIfExists('knowledge_categories');
    }
};
