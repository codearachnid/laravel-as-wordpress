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
        $tableComment = config('wordpress.migrate.table.comments', 'wp_comments');
        $tableCommentMeta = config('wordpress.migrate.table.commentmeta', 'wp_commentmeta');

        if (!Schema::hasTable($tableComment)) {
            Schema::create($tableComment, function (Blueprint $table) {
                $table->bigIncrements('comment_ID');
                $table->unsignedBigInteger('comment_post_ID')->default(0);
                $table->string('comment_author')->nullable();
                $table->string('comment_author_email', 100)->nullable()->default('');
                $table->string('comment_author_url', 200)->nullable()->default('');
                $table->string('comment_author_IP', 100)->nullable()->default('');
                $table->dateTime('comment_date')->default('0000-00-00 00:00:00');
                $table->dateTime('comment_date_gmt')->default('0000-00-00 00:00:00');
                $table->text('comment_content');
                $table->integer('comment_karma')->default(0);
                $table->string('comment_approved', 20)->default('1');
                $table->string('comment_agent', 255)->nullable()->default('');
                $table->string('comment_type', 20)->default('comment');
                $table->unsignedBigInteger('comment_parent')->default(0);
                $table->unsignedBigInteger('user_id')->nullable()->default(0);
            
                $table->index('comment_post_ID');
                $table->index('comment_date_gmt');
                $table->index('comment_parent');
                $table->index('comment_author_email', 'comment_author_email', 10);

                $table->foreign('comment_post_ID')
                    ->references('ID')
                    ->on(config('wordpress.migrate.table.posts', 'wp_posts'))
                    ->onDelete('cascade');
                $table->foreign('user_id')
                    ->references('ID')
                    ->on(config('wordpress.migrate.table.users', 'wp_users'))
                    ->onDelete('set null');

            });
        }

        if (!Schema::hasTable($tableCommentMeta)) {
            Schema::create($tableCommentMeta, function (Blueprint $table) use ($tableComment) {
                $table->bigIncrements('meta_id');
                $table->unsignedBigInteger('comment_id');
                $table->string('meta_key', 255);
                $table->longText('meta_value')->nullable();
                $table->foreign('comment_id')->references('comment_ID')->on( $tableComment )->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if( config('wordpress.migrate.allow_drop', false ) ) {
            Schema::dropIfExists( config('wordpress.migrate.table.comments', 'wp_comments') );
            Schema::dropIfExists( config('wordpress.migrate.table.commentmeta', 'wp_commentmeta') );
        }
    }
};
