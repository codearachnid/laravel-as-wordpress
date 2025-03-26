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
        $tablename = config('wordpress.migrate.table.links', 'wp_links');

        if (!Schema::hasTable($tablename)) {
            Schema::create($tablename, function (Blueprint $table) {
                $table->bigIncrements('link_id');
                $table->string('link_url', 255)->nullable();
                $table->string('link_name', 255)->nullable();
                $table->string('link_image', 255)->nullable();
                $table->string('link_target', 25)->nullable();
                $table->string('link_description', 255)->nullable();
                $table->string('link_visible', 20)->default('Y');
                $table->unsignedBigInteger('link_owner')->default(1)->nullable();
                $table->integer('link_rating')->default(0);
                $table->dateTime('link_updated');
                $table->string('link_rel', 255)->nullable();
                $table->mediumText('link_notes')->nullable();
                $table->string('link_rss', 255)->nullable();

                $table->foreign('link_owner')
                      ->references('ID')
                      ->on(config('wordpress.migrate.table.users', 'wp_users'))
                      ->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if( config('wordpress.migrate.allow_drop', false ) ) {
            Schema::dropIfExists( config('wordpress.migrate.table.links', 'wp_links') );
        }
    }
};
