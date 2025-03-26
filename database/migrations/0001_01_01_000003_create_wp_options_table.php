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

        $tableName = config( 'wordpress.migrate.table.options', 'wp_options' );

        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->bigIncrements('option_id');
                $table->string('option_name', 191)->unique();
                $table->longText('option_value');
                $table->string('autoload', 20)->default('yes');
            });
        } else {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {

                if (!Schema::hasColumn($tableName, 'option_id')) {
                    $table->bigIncrements('option_id');
                } elseif (!Schema::getColumnType($tableName, 'option_id') === 'bigint') {
                    $table->bigInteger('option_id', true)->change();
                }

                if (!Schema::hasColumn($tableName, 'option_name')) {
                    $table->string('option_name', 191)->unique();
                } else {
                    $table->string('option_name', 191)->unique()->change();
                }

                if (!Schema::hasColumn($tableName, 'option_value')) {
                    $table->longText('option_value');
                } elseif (Schema::getColumnType($tableName, 'option_value') !== 'longtext') {
                    $table->longText('option_value')->change();
                }

                if (!Schema::hasColumn($tableName, 'autoload')) {
                    $table->string('autoload', 20)->default('yes');
                } else {
                    $table->string('autoload', 20)->default('yes')->change();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableName = config('wordpress.migrate.table.options', 'wp_options');
        
        if( config('wordpress.migrate.allow_drop', false ) ) {
            Schema::dropIfExists( $tableName );
        } else {
            Schema::table( $tableName, function (Blueprint $table) {
                $table->bigInteger('option_id', true)->change();
                $table->string('option_name', 191)->unique()->change();
                $table->longText('option_value')->change();
                $table->string('autoload', 20)->default('yes')->change();
            });
        }
    }
};
