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
                $table->string('user_login', 60)->default('');
                $table->string('user_pass', 255)->default('');
                $table->string('user_nicename', 50)->default('');
                $table->string('user_email', 100)->nullable()->default('');
                $table->string('user_url', 100)->nullable()->default('');
                $table->dateTime('user_registered')->default('0000-00-00 00:00:00');
                $table->string('user_activation_key', 255)->nullable()->default('');
                $table->integer('user_status')->default(0)->default(0);
                $table->string('display_name', 250)->default('');
                $table->string('password', 255)->nullable();
                $table->string('remember_token', 100)->nullable();

                $table->index('user_login', 'user_login_key');
                $table->index('user_nicename');
                $table->index('user_email');
            });
        }

        if (!Schema::hasTable( $tableUsermeta )) {
            Schema::create( $tableUsermeta, function (Blueprint $table) use ($tableUsers) {
                $table->bigIncrements('umeta_id');
                $table->unsignedBigInteger('user_id')->default(0);
                $table->string('meta_key', 255)->nullable();
                $table->longText('meta_value')->nullable();

                $table->index('user_id');
                $table->index('meta_key');
            
                $table->foreign('user_id')
                    ->references('ID')
                    ->on($tableUsers)
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
