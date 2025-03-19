<?php
/**
 * Uninstall WhoIsMailingMe
 *
 * @package WhoIsMailingMe
 */

// If uninstall not called from WordPress, exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Nothing to clean up for this plugin as it doesn't create any database entries or options
