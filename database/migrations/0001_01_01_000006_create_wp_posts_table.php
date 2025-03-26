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
                $table->unsignedBigInteger('post_author');
                $table->dateTime('post_date');
                $table->dateTime('post_date_gmt');
                $table->longText('post_content');
                $table->text('post_title');
                $table->text('post_excerpt');
                $table->string('post_status', 20)->default('publish');
                $table->string('comment_status', 20)->default('open');
                $table->string('ping_status', 20)->default('open');
                $table->string('post_password', 255)->nullable();
                $table->string('post_name', 200);
                $table->text('to_ping')->nullable();
                $table->text('pinged')->nullable();
                $table->dateTime('post_modified');
                $table->dateTime('post_modified_gmt');
                $table->longText('post_content_filtered')->nullable();
                $table->unsignedBigInteger('post_parent')->default(0);
                $table->string('guid', 255)->nullable();
                $table->integer('menu_order')->default(0);
                $table->string('post_type', 20)->default('post');
                $table->string('post_mime_type', 100)->nullable();
                $table->bigInteger('comment_count')->default(0);
                $table->foreign('post_author')->references('ID')->on(config('wordpress.migrate.table.users', 'wp_users'))->onDelete('set null');
            });
        }

        if (!Schema::hasTable($tablePostmeta)) {
            Schema::create($tablePostmeta, function (Blueprint $table) use ($tablePosts) {
                $table->bigIncrements('meta_id');
                $table->unsignedBigInteger('post_id');
                $table->string('meta_key', 255);
                $table->longText('meta_value')->nullable();
                $table->foreign('post_id')->references('ID')->on( $tablePosts )->onDelete('cascade');
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
