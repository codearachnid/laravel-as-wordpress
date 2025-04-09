<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tablePosts = config('wordpress.migrate.table.posts', 'wp_posts');
        $tablePostmeta = config('wordpress.migrate.table.postmeta', 'wp_postmeta');

        if (!Schema::hasTable($tablePosts)) {
            Schema::create($tablePosts, function (Blueprint $table) {
                $table->bigIncrements('ID');
                $table->unsignedBigInteger('post_author')->default(0);
                $table->dateTime('post_date')->default('0000-00-00 00:00:00');
                $table->dateTime('post_date_gmt')->default('0000-00-00 00:00:00');
                $table->longText('post_content');
                $table->text('post_title');
                $table->text('post_excerpt')->nullable();
                $table->string('post_status', 20)->default('publish');
                $table->string('comment_status', 20)->default('open');
                $table->string('ping_status', 20)->default('open');
                $table->string('post_password', 255)->default('');
                $table->string('post_name', 200)->default('');
                $table->text('to_ping')->nullable();
                $table->text('pinged')->nullable();
                $table->dateTime('post_modified')->default('0000-00-00 00:00:00');
                $table->dateTime('post_modified_gmt')->default('0000-00-00 00:00:00');
                $table->longText('post_content_filtered')->nullable();
                $table->unsignedBigInteger('post_parent')->default(0);
                $table->string('guid', 255)->nullable()->default('');
                $table->integer('menu_order')->default(0);
                $table->string('post_type', 20)->default('post');
                $table->string('post_mime_type', 100)->default('');
                $table->bigInteger('comment_count')->default(0);
                
                $table->index('post_name');
                $table->index(['post_type', 'post_status']);
                $table->index('post_date');
                $table->index('post_parent');
                $table->index('post_author');
                
                $table->foreign('post_author')
                    ->references('ID')
                    ->on(config('wordpress.migrate.table.users', 'wp_users'))
                    ->onDelete('set null');
            });
        }

        if (!Schema::hasTable($tablePostmeta)) {
            Schema::create($tablePostmeta, function (Blueprint $table) use ($tablePosts) {
                $table->bigIncrements('meta_id');
                $table->unsignedBigInteger('post_id')->default(0);
                $table->string('meta_key', 255)->nullable();
                $table->longText('meta_value')->nullable();
                
                $table->index('post_id');
                $table->index('meta_key');
                
                $table->foreign('post_id')
                    ->references('ID')
                    ->on('wp_posts')
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
            Schema::dropIfExists( config('wordpress.migrate.table.posts', 'wp_posts') );
            Schema::dropIfExists( config('wordpress.migrate.table.postmeta', 'wp_postmeta') );
        }
    }
};
