# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this plugin is

Breview (free/lite version) is a WooCommerce extension that lets verified buyers review products from their completed order page (marketplace-style, like Amazon), and displays those reviews on the product page. Reviews are standard WordPress comments on the product post, extended with comment meta. This repo is the **free** version distributed on wordpress.org and CodeCanyon; the Pro version lives in a separate `/breview-pro` folder (gitignored). The main class `MSBR_Lite` deactivates itself if `MSBR_Pro` is active.

## Git rules

- **Never commit or push directly.** Leave all changes in the working tree for the developer to review, stage, and commit themselves. Do not run `git add`, `git commit`, or `git push` unless explicitly asked.
- Line endings are LF, enforced by `.gitattributes` and `.editorconfig`. Do not introduce CRLF files.

## Coding standards: WordPress-Extra WPCS

All PHP must pass the **WordPress-Extra** ruleset defined in `phpcs.xml.dist` with zero errors and warnings. PHPCS + WPCS are installed **globally** (via Composer global, `%APPDATA%\Composer\vendor\bin`), by design — do not add them to this repo's `composer.json` (the repo commits `vendor/`, which holds only the Appsero client).

```
composer lint          # phpcs against phpcs.xml.dist (whole plugin)
composer format        # phpcbf auto-fix
phpcs path/to/file.php # lint a single file
phpcbf path/to/file.php
```

There is no build step and no test suite. Verification = clean PHPCS run + manual testing on the local WordPress site (WP_DEBUG on, no notices/warnings/errors).

Key conventions enforced by the ruleset and this codebase:

- **Prefix everything** globally visible with `msbr_` (functions, hooks, options, script/style handles, meta keys) or `MSBR_` (classes, constants). The `mswa_` prefix is reserved for cross-plugin MS Web Arts admin hooks shared with sibling plugins (`mswa_overview_content`, `mswa_overview_sidebar`, `mswa-global-*` asset handles). `breview` is also an allowed prefix. Never introduce unprefixed globals.
- **Text domain is `breview`** — exactly, on every `__()`, `_e()`, `esc_html__()`, `_n()`, `_x()`, etc. Never use `woocommerce`, `default`, or a variable/constant as the text domain.
- **Every user-facing string must be translatable**: wrapped in an i18n function, with the `breview` domain, and escaped (`esc_html__`, `esc_attr__`, …). No variables inside translatable strings — use `sprintf`/`wp_sprintf` placeholders with a `/* translators: */` comment. After adding or changing strings, update `languages/breview.pot` so it stays in sync.
- Tabs for indentation (PHP, JS, CSS, HTML), Yoda conditions, strict `===` comparisons, braces on all blocks — WPCS handles most of this; run `phpcbf` after editing.
- Functions are wrapped in `if ( ! function_exists( ... ) )` guards (pro/free coexistence); follow that pattern for new functions in `inc/functions/`.
- Some WooCommerce core hooks (`woocommerce_product_get_rating_html`, `woocommerce_review_gravatar_size`, `woocommerce_reviews_title`, `woocommerce_comment_pagination_args`) are fired intentionally so theme customizations keep working — they carry `phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound` annotations with a rationale. Keep the annotation and rationale when touching them; don't "fix" them by renaming.
- Template files and options-panel page files are excluded from the `NonPrefixedVariableFound` sniff (their variables are function-local via `load_template()`/`include`) — that exclusion lives in `phpcs.xml.dist`; don't remove it.

## CodeCanyon (Envato) requirements

This plugin is sold on CodeCanyon, so all code must also satisfy the Envato WordPress Plugin Requirements: https://help.author.envato.com/hc/en-us/articles/360000510603-WordPress-Plugin-Requirements. The ones that most affect day-to-day changes here:

- No deprecated WordPress/PHP functions; must work with the **latest** WordPress and WooCommerce releases regardless of the advertised "tested up to" version.
- Validate, sanitize (`sanitize_*`), and escape (`esc_*`) everything; nonces on all form handling (see `msbr_save_comment_meta_data` and the options-panel save handlers for the established pattern); `current_user_can()` on admin pages.
- No direct database access — use WordPress APIs (this plugin uses comments, comment meta, and options only; keep it that way). Any custom query must use `$wpdb->prepare`.
- Assets only via `wp_register_script`/`wp_enqueue_script` and the style equivalents — never print `<script>`/`<link>` tags or inline JS/CSS in markup (`wp_localize_script` and `wp_add_inline_style` are the sanctioned mechanisms, already in use in `breview.php`). Never deregister core jQuery or bundle duplicates of core libraries.
- Admin code separated from public code (`is_admin()` / admin hooks); no data deleted on deactivation; no PHP short tags; no `eval`; UTF-8 without BOM.
- No undisclosed data transmission (Appsero insights is the opt-in tracker already integrated); no upsell notices in WP Admin outside the plugin's own panels; any global notice must be dismissible and stay dismissed.
- The `.pot` file must be current — another reason to regenerate `languages/breview.pot` after string changes.

## Architecture

Bootstrap: `breview.php` defines `MSBR_DIR`, globals `$msbr_dir`/`$msbr_url`, and class `MSBR_Lite`. On `plugins_loaded` it bails with an admin notice if WooCommerce (`WC_VERSION`) is absent; otherwise it requires `inc/init.php` and registers assets, admin menu, and textdomain loading. `inc/init.php` is the single include manifest for everything else.

**Review flow (the core of the plugin):**
1. `inc/functions/review-form.php` hooks `woocommerce_order_item_meta_end`: on completed orders viewed at the `view-order`/`order-received` endpoints, each order item gets either an "Add Review" popup (`templates/order/add-review-popup.php`) or a "Show Review" popup if already reviewed. Uniqueness is enforced by an `order_identifier` comment-meta key (`item-{item_id}|order-{order_id}`), queried via `get_comments` before rendering.
2. Submission goes through the native `comment_form()`/`comment_post`; `msbr_save_comment_meta_data` verifies the nonce, saves `order_identifier` and `msbr_review_title` meta, and sets the comment to approve/hold based on the `msbr_auto_approve_reviews` option. Front-end validation/Ajax lives in `assets/js/main.js` (settings passed via `wp_localize_script` as `msbr_review`).
3. `inc/functions/review-product-page.php` removes WooCommerce's default `reviews` tab and adds an `msbr_reviews` tab that renders the review list through templates.
4. `inc/functions/hooks-actions.php` defines the display pipeline via custom action hooks — `msbr_review_user`, `msbr_review_rating`, `msbr_review_content` — which templates fire and functions hook into (gravatar, meta, title, description, star ratings). Extend display behavior by adding/removing callbacks on these hooks, not by editing templates inline.
5. `inc/emails/completed.php` sends a review-reminder email on `woocommerce_order_status_changed` → completed, gated by the `msbr_enable_completed_email` option.

**Templating:** `MSBR_Template_Loader` (`inc/classes/class-msbr-template-loader.php`, Gary Jones' loader with `msbr` filter prefix) resolves templates from `templates/` and lets themes override them at `yourtheme/breview/{path}.php`. Data is passed with `$templates->set_template_data( $data )->get_template_part( 'order/add-review-popup' )` and read in the template as `$data->property`. Template-override capability is an advertised feature — when changing a template's markup or expected `$data`, bump the `@version` in its header and note the change in the readme changelog.

**Settings:** stored as option arrays — `msbr_general_options`, `msbr_multi_rating_options`, `msbr_email_options` — plus the standalone `msbr_auto_approve_reviews`. Admin pages live in `inc/admin/options-panel/` (save handler + `include` of the matching page file in `pages/`). The admin menu hangs off a shared "MS Web Arts" parent menu (`mswebarts-overview`) that is only created if no sibling plugin already registered it (checked via `$GLOBALS['admin_page_hooks']`) — submenus are always registered regardless of which plugin owns the parent. Be careful with hook-order assumptions here; this exact spot has caused race-condition bugs with sibling plugins (e.g. Custom Offers).

**Compatibility concerns baked into the code:** Dokan multi-vendor (parent orders with `has_sub_order` meta get a notice instead of review forms — suborders get the forms), and free/pro mutual exclusion. Options may not exist in the database until the user saves settings once (the readme's "PHP warning" FAQ) — guard option-array reads with `isset`/`! empty` fallbacks as the existing code does.

## Releasing a version

Version appears in three places that must stay in sync: `breview.php` plugin header (`Version:`), `readme.txt` (`Stable tag:`), and the changelog entry in `readme.txt`. Asset version strings in `wp_register_style`/`wp_register_script` calls are bumped to match on release.
