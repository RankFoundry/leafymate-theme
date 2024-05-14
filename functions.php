<?php
/**
 * Leafy Mate Theme
 *
 * @package   LeafyMate_Theme
 * @link      https://rankfoundry.com
 * @copyright Copyright (C) 2021-2023, Rank Foundry LLC - support@rankfoundry.com
 * @since     1.0.0
 * @license   GPL-2.0+
 *
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/*--------------------------------------------------------------*/
/*---------------------- Theme Setup ---------------------------*/
/*--------------------------------------------------------------*/
// Define theme version
if (!defined('LEAFYMATE_THEME_VERSION')) {
    define('LEAFYMATE_THEME_VERSION', '1.0.0');
}

// Define theme directory path
if (!defined('LEAFYMATE_THEME_DIR')) {
    define('LEAFYMATE_THEME_DIR', trailingslashit( get_stylesheet_directory() ));
}

// Define theme directory URI
if (!defined('LEAFYMATE_THEME_DIR_URI')) {
    define('LEAFYMATE_THEME_DIR_URI', trailingslashit( esc_url( get_stylesheet_directory_uri() )));
}

// Define current theme name
if (!defined('CURRENT_THEME_NAME')) {
    $current_theme_obj = wp_get_theme();
    define('CURRENT_THEME_NAME', $current_theme_obj->get('Name'));
}

// Load the Composer autoloader.
require_once LEAFYMATE_THEME_DIR . 'vendor/autoload.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;


/*--------------------------------------------------------------*/
/*------------------ Theme Update Checker ----------------------*/
/*--------------------------------------------------------------*/
if ( 'leafymate' === CURRENT_THEME_NAME ) {
	$leafymateUpdateChecker = PucFactory::buildUpdateChecker(
		'https://github.com/rankfoundry/leafymate-theme/',
		LEAFYMATE_THEME_DIR . '/functions.php',
		'leafymate',
		48
	);
	$leafymateUpdateChecker->setBranch('main');
}

/*--------------------------------------------------------------*/
/*--------------------- WP Auto Updates ------------------------*/
/*--------------------------------------------------------------*/

// allows WP plugins to automatically update.
add_filter('auto_update_plugin', '__return_true');

// allow themes to automatically update.
//add_filter('auto_update_theme', '__return_true');

// allow WP core updates.
add_filter('allow_minor_auto_core_updates', '__return_true');
add_filter('allow_major_auto_core_updates', '__return_true');

// force auto updates even for version controlled code enviroments.
add_filter('automatic_updates_is_vcs_checkout', '__return_false', 1);


/*---------------------------------------------------------------*/
/*---------------------- Theme Styles ---------------------------*/
/*---------------------------------------------------------------*/
function leafymate_enqueue_styles() {
	wp_enqueue_style( 'leafymate', get_stylesheet_directory_uri() . '/style.css', array(), LEAFYMATE_THEME_VERSION );
    wp_enqueue_style( 'custom', get_stylesheet_directory_uri() . '/assets/css/custom.css', array(), LEAFYMATE_THEME_VERSION );
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}


add_action( 'wp_enqueue_scripts', 'leafymate_enqueue_styles' ); 


// Remove trailing slash from pagination links
add_filter('paginate_links','untrailingslashit');
add_filter( 'get_pagenum_link', 'untrailingslashit');
