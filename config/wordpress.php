<?php

// Mimic wp-config.php constants and settings

return [

    /*
    |--------------------------------------------------------------------------
    | Table Prefix
    |--------------------------------------------------------------------------
    |
    | Define your WordPress table prefix (e.g., 'wp_'). Matches WP’s $table_prefix.
    |
    */
    'table_prefix' => env('WP_TABLE_PREFIX', 'wp_'),

    /*
    |--------------------------------------------------------------------------
    | WordPress Constants
    |--------------------------------------------------------------------------
    |
    | Mimics WP’s define() constants like WP_DEBUG, ABSPATH, etc. Add as needed.
    |
    */
    'constants' => [
        'wp_debug' => env('WP_DEBUG', false), // Debug mode
        'wp_home' => env('WP_HOME', env('APP_URL', 'http://localhost')), // Site URL
        'wp_siteurl' => env('WP_SITEURL', env('APP_URL', 'http://localhost')), // WordPress URL
        'wp_content_dir' => env('WP_CONTENT_DIR', public_path('wp-content')), // Content directory
        'wp_plugin_dir' => env('WP_PLUGIN_DIR', public_path('wp-content/plugins')), // Plugins directory
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Unique Keys and Salts
    |--------------------------------------------------------------------------
    |
    | WordPress uses these for cookie and security hashing. We’ll keep them for
    | potential compatibility, though Laravel uses its own session system.
    |
    */
    'salts' => [
        'auth_key' => env('WP_AUTH_KEY', ''),
        'secure_auth_key' => env('WP_SECURE_AUTH_KEY', ''),
        'logged_in_key' => env('WP_LOGGED_IN_KEY', ''),
        'nonce_key' => env('WP_NONCE_KEY', ''),
        'auth_salt' => env('WP_AUTH_SALT', ''),
        'secure_auth_salt' => env('WP_SECURE_AUTH_SALT', ''),
        'logged_in_salt' => env('WP_LOGGED_IN_SALT', ''),
        'nonce_salt' => env('WP_NONCE_SALT', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Settings
    |--------------------------------------------------------------------------
    |
    | Add your own WordPress-like settings here, just like WP’s custom constants.
    |
    */
    'disable_updates' => env('WP_DISABLE_UPDATES', false),
    'max_revisions' => env('WP_MAX_REVISIONS', 5),

    'migate' => [
        'table' => [
            'posts' => 'wp_posts',
            'postmeta' => 'wp_postmeta',
            'users' => 'wp_users',
            'usermeta' => 'wp_usermeta',
            'terms' => 'wp_terms',
            'term_taxonomy' => 'wp_term_taxonomy',
            'term_relationships' => 'wp_term_relationships',
            'comments' => 'wp_comments',
            'commentmeta' => 'wp_commentmeta',
            'options' => 'wp_options',
            'links' => 'wp_links',
        ],
        'allow_drop' => env('WP_ALLOW_DROP', false),
    ]
];