<?php
/**
 * Include the plugin files for initialization.
 *
 * @package breview
 * @since 1.0.0
 */

global $msbr_dir;

// including options panel.
require_once $msbr_dir . 'inc/admin/options-panel/options-panel.php';

// include plugin files.
require_once $msbr_dir . 'inc/functions/review-product-page.php';
require_once $msbr_dir . 'inc/functions/review-form.php';
require_once $msbr_dir . 'inc/functions/hooks-actions.php';

// including emails.
require_once $msbr_dir . 'inc/emails/completed.php';

// including template loader.
require_once $msbr_dir . 'inc/classes/class-msbr-template-loader.php';
