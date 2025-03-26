# WordPress Reborn: The Laravel Redemption

Welcome to *WordPress Reborn*, where we take the creaky, duct-taped chaos of WordPress and resurrect it as a Laravel masterpiece—because who doesn’t love a redemption story with better architecture? Powered by FilamentPHP and Laravel’s pristine best practices, this project overlays an existing WordPress database, preserving its quirky schema while giving you a modern CMS that doesn’t make you question your life choices. Say goodbye to plugin roulette and hello to sanity, one Eloquent query at a time.

## What’s This All About?
This isn’t a rebuild—it’s a hostile takeover of WordPress’s soul, keeping its wp_ prefixed tables intact while Laravel flexes its superiority. We’re talking wp_posts, wp_postmeta, wp_users, wp_comments, wp_options—the whole dysfunctional family—wrapped in Eloquent models and services that mimic WordPress’s WP_Query, WP_User_Query, and friends. Built to coexist with an active WordPress install, this is your escape hatch from PHP’s past without burning the bridge behind you.

## Features (aka Why This Beats WordPress at Its Own Game)
- Full Schema Compatibility: wp_ prefixes? Check. Serialized wp_options madness? Check. We’re not here to fix WordPress’s mistakes—just to live with them better.
- Posts & CPTs: Query posts, pages, and custom post types like product with a PostQueryService that laughs at WP_Query’s global state.
Meta & Taxonomies: Filter by wp_postmeta and wp_term_relationships like a pro—no more meta_query migraines.
- Users & Roles: Authenticate with wp_users, transition MD5 passwords to bcrypt gracefully, and filter by wp_capabilities roles without losing your mind.
- Comments: Threaded wp_comments queries via a CommentQueryService—because even trolls deserve a modern ORM.
- Options: Get, set, and autoload wp_options with a OptionService that handles transients and caching, minus the WordPress bloat.
- FilamentPHP Ready: Plug into a sleek admin panel that makes WordPress’s dashboard look like a GeoCities relic.
- Laravel Best Practices: Dependency injection, services, and Eloquent—because we’re not savages.

## Getting Started
1. Clone the Repo: `git clone https://github.com/codearachnid/codearachnid/laravel-as-wordpress` your hero’s journey here.
2. Install Dependencies: Run `composer install` and hope your PHP version isn’t stuck in 2010.
3. Set Up Your .env: Copy `.env.example` to `.env`, point `DB_DATABASE` to your WordPress database, and set `WP_TABLE_PREFIX=wp_` (or whatever your install uses).
4. Run Migrations: `php artisan migrate` to tweak `wp_users` with a `password` column and `remember_token` — don’t worry, we’re gentle with your legacy data.
5. Launch It: `php artisan serve`, navigate to `/posts`, `/users`, `/comments`, or `/options`, and watch Laravel tame the WordPress beast.

## Key Components
`PostQueryService`: Replaces `WP_Query` with filters for `post_type`, `meta_query`, `tax_query`, and more. (add a PR with your improvements)
`UserQueryService`: Queries `wp_users` with role support from `wp_usermeta`, plus a dual-password system for MD5-to-bcrypt harmony.
`CommentQueryService`: Handles `wp_comments` with threading and post/user relationships.
`OptionService`: Manages `wp_options` with caching, transients, and autoload—just don’t ask about `option_53`.
*Models*: Eloquent wrappers for `wp_posts`, `wp_postmeta`, `wp_terms`, `wp_users`, `wp_comments`, and `wp_options`, all prefix-aware.

## Contributing
Got a wild idea? Found a bug in our WordPress exorcism? Want to rant about `the_option()`? Open an issue or PR. We welcome all brave souls willing to wrestle this hybrid beast. Just don’t suggest adding a Gutenberg clone—we’ve suffered enough.

## Why Did I Do This? (contribute so we can change this to we!)
Because WordPress has been coasting on “it works” for too long, and we’re tired of pretending its `wp_` tables are fine. Laravel and FilamentPHP are here to save us from the PHP dark ages, one hasMany at a time. Plus, it’s a great way to flex at the next meetup while sipping artisanal coffee.

## Caveats
- WordPress Still Runs: This overlays an existing database, so WordPress can still chug along. Sync issues? That’s your problem.
- MD5 Passwords: Users transition to `bcrypt` on login—don’t lose sleep over the stragglers.
- Performance: Eloquent joins on `wp_postmeta` aren’t magic. Optimize if your database groans.

## License
MIT, because we’re generous gods of code. Go forth and overlay the WordPress world—or at least make something less soul-crushing than wp-admin.

Happy coding, and may your `wp_options` never contain a 10MB serialized blob! Let me know if you want to tweak this further!