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
        $tableUsers = config('wordpress.migrate.table.users', 'wp_users');
        $tableUsermeta = config('wordpress.migrat.table.usermeta', 'wp_usermeta');

        if( Schema::hasTable( $tableUsers ) ) {
            Schema::table( $tableUsers, function (Blueprint $table) {
                $table->string('password', 255)->nullable()->after('user_pass');
                $table->string('remember_token', 100)->nullable()->after('user_activation_key');
            });
        } else {
            Schema::create( $tableUsers, function (Blueprint $table) {
                $table->bigIncrements('ID');
                $table->string('user_login', 60);
                $table->string('user_pass', 255);
                $table->string('user_nicename', 50);
                $table->string('user_email', 100)->nullable();
                $table->string('user_url', 100)->nullable();
                $table->dateTime('user_registered');
                $table->string('user_activation_key', 255)->nullable();
                $table->integer('user_status')->default(0);
                $table->string('display_name', 250);
                $table->string('password', 255)->nullable(); // Laravel bcrypt column
                $table->string('remember_token', 100)->nullable();
            });
        }

        if (!Schema::hasTable( $tableUsermeta )) {
            Schema::create( $tableUsermeta, function (Blueprint $table) use ($tableUsers) {
                $table->bigIncrements('umeta_id');
                $table->unsignedBigInteger('user_id');
                $table->string('meta_key', 255);
                $table->longText('meta_value')->nullable();
                $table->foreign('user_id')->references('ID')->on( $tableUsers )->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if( config('wordpress.migrate.allow_drop', false ) ) {
            Schema::dropIfExists( config('wordpress.migrate.table.users', 'wp_users') );
            Schema::dropIfExists( config('wordpress.migrate.table.usermeta', 'wp_usermeta') );
        } else {
            Schema::table( config('wordpress.migrate.table.users', 'wp_users'), function (Blueprint $table) {
                $table->dropColumn('password');
                $table->dropColumn('remember_token');
            });
        }
    }
};
