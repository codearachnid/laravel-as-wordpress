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
        $tableTermMeta = config('wordpress.migrate.table.termmeta', 'wp_termmeta');
        $tableTerms = config('wordpress.migrate.table.terms', 'wp_terms');
        $tableTermTaxonomy = config('wordpress.migrate.table.term_taxonomy', 'wp_term_taxonomy');
        $tableTermRelationships = config('wordpress.migrate.table.term_relationships', 'wp_term_relationships');

        if (!Schema::hasTable($tableTerms)) {
            Schema::create($tableTerms, function (Blueprint $table) {
                $table->bigIncrements('term_id');
                $table->string('name', 200)->default('');
                $table->string('slug', 200)->default('');
                $table->bigInteger('term_group')->default(0);

                $table->index('slug');
                $table->index('name');
            });
        }

        if (!Schema::hasTable($tableTermMeta)) {
            Schema::create($tableTermMeta, function (Blueprint $table) use ($tableTerms) {
                $table->bigIncrements('meta_id');
                $table->unsignedBigInteger('term_id')->default(0);
                $table->string('meta_key', 255)->nullable();
                $table->longText('meta_value')->nullable();

                $table->index('term_id');
                $table->index('meta_key');

                $table->foreign('term_id')
                        ->references('term_id')
                        ->on($tableTerms)
                        ->onDelete('cascade');
            });
        }

        if (!Schema::hasTable($tableTermTaxonomy)) {
            Schema::create($tableTermTaxonomy, function (Blueprint $table) use ($tableTerms) {
                $table->bigIncrements('term_taxonomy_id');
                $table->unsignedBigInteger('term_id')->default(0);
                $table->string('taxonomy', 32)->default('');
                $table->longText('description')->nullable();
                $table->unsignedBigInteger('parent')->default(0);
                $table->bigInteger('count')->default(0);
                
                $table->index('term_id');
                $table->index('taxonomy');
                
                $table->foreign('term_id')
                        ->references('term_id')
                        ->on($tableTerms)
                        ->onDelete('cascade');
            });
        }

        if (!Schema::hasTable($tableTermRelationships)) {
            Schema::create($tableTermRelationships, function (Blueprint $table) use ($tableTermTaxonomy) {
                $table->unsignedBigInteger('object_id')->default(0);
                $table->unsignedBigInteger('term_taxonomy_id')->default(0);
                $table->integer('term_order')->default(0);
                
                $table->primary(['object_id', 'term_taxonomy_id']);
                $table->index('term_taxonomy_id');
                
                $table->foreign('object_id')
                    ->references('ID')
                    ->on(config('wordpress.migrate.table.posts', 'wp_posts'))
                    ->onDelete('cascade');
                    
                $table->foreign('term_taxonomy_id')
                    ->references('term_taxonomy_id')
                    ->on($tableTermTaxonomy)
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if( config('wordpress.migrate.allow_drop', false ) ) {
            Schema::dropIfExists( config('wordpress.migrate.table.termmeta', 'wp_termmeta') );
            Schema::dropIfExists( config('wordpress.migrate.table.terms', 'wp_terms') );
            Schema::dropIfExists( config('wordpress.migrate.table.term_taxonomy', 'wp_term_taxonomy') );
            Schema::dropIfExists( config('wordpress.migrate.table.term_relationships', 'wp_term_relationships') );
        }
    }
};
