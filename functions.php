<?php
/**
 * Business Pro Theme
 *
 * @package   BusinessProTheme
 * @link      https://seothemes.com/themes/business-pro
 * @author    SEO Themes
 * @copyright Copyright © 2017 SEO Themes
 * @license   GPL-2.0+
 */

// If this file is called directly, abort..
if (!defined('WPINC')) {

	die;

}

// Child theme (do not remove).
include_once (get_template_directory().'/lib/init.php');

// Define theme constants.
define('CHILD_THEME_NAME', 'Business Pro Theme');
define('CHILD_THEME_URL', 'https://seothemes.com/themes/business-pro');
define('CHILD_THEME_VERSION', '1.0.5.2018-08-08-a07');

// Set Localization (do not remove).
load_child_theme_textdomain('business-pro-theme', apply_filters('child_theme_textdomain', get_stylesheet_directory().'/languages', 'business-pro-theme'));

// Remove unused sidebars and layouts.
unregister_sidebar('sidebar-alt');
genesis_unregister_layout('content-sidebar-sidebar');
genesis_unregister_layout('sidebar-content-sidebar');
genesis_unregister_layout('sidebar-sidebar-content');

// Enable shortcodes in HTML widgets.
add_filter('widget_text', 'do_shortcode');

// Set hero image size.
add_image_size('hero', 1920, 720, true);

// Set portfolio image size to override plugin.
add_image_size('portfolio', 620, 380, true);

// Enable support for page excerpts.
add_post_type_support('page', 'excerpt');

// Add support for structural wraps.
add_theme_support('genesis-structural-wraps', array(
		'header',
		'menu-primary',
		'menu-secondary',
		'footer-widgets',
		'footer',
	));

// Enable Accessibility support.
add_theme_support('genesis-accessibility', array(
		'404-page',
		'drop-down-menu',
		'headings',
		'rems',
		'search-form',
		'skip-links',
	));

// Reinstate Genesis Featured Products widget after 1.0 update
add_theme_support('gencwooc-featured-products-widget');

// Enable custom navigation menus.
add_theme_support('genesis-menus', array(
		'primary' => __('Header Menu', 'business-pro-theme'),
	));

// Enable support for footer widgets.
add_theme_support('genesis-footer-widgets', 4);

// Enable viewport meta tag for mobile browsers.
add_theme_support('genesis-responsive-viewport');

// Enable HTML5 markup structure.
add_theme_support('html5', array(
		'caption',
		'comment-form',
		'comment-list',
		'gallery',
		'search-form',
	));

// Enable support for post formats.
add_theme_support('post-formats', array(
		'aside',
		'audio',
		'chat',
		'gallery',
		'image',
		'link',
		'quote',
		'status',
		'video',
	));

// Enable support for WooCommerce.
add_theme_support('woocommerce');

// Enable selective refresh and Customizer edit icons.
add_theme_support('fixed-header');

// Enable selective refresh and Customizer edit icons.
add_theme_support('customize-selective-refresh-widgets');

// Enable theme support for custom background image.
add_theme_support('custom-background', array(
		'default-color' => 'f4f5f6',
	));

// Enable logo option in Customizer > Site Identity.
add_theme_support('custom-logo', array(
		'height'      => 100,
		'width'       => 300,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array('.site-title', '.site-description'),
	));

// Display custom logo.
add_action('genesis_site_title', 'the_custom_logo', 1);

// Enable support for custom header image or video.
add_theme_support('custom-header', array(
		'header-selector'    => 'false',
		'default_image'      => get_stylesheet_directory_uri().'/assets/images/hero.jpg',
		'header-text'        => true,
		'default-text-color' => 'ffffff',
		'width'              => 1920,
		'height'             => 1080,
		'flex-height'        => true,
		'flex-width'         => true,
		'uploads'            => true,
		'video'              => true,
		'wp-head-callback'   => 'business_custom_header',
	));

// Register default header (just in case).
register_default_headers(array(
		'child'          => array(
			'url'           => '%2$s/assets/images/hero.jpg',
			'thumbnail_url' => '%2$s/assets/images/hero.jpg',
			'description'   => __('Hero Image', 'business-pro-theme'),
		),
	));

// Register custom layout.
genesis_register_layout('centered-content', array(
		'label' => __('Centered Content', 'business-pro-theme'),
		'img'   => get_stylesheet_directory_uri().'/assets/images/layout.gif',
	));

// Reposition the primary navigation menu.
remove_action('genesis_after_header', 'genesis_do_nav');
add_action('genesis_after_title_area', 'genesis_do_nav');

// Reposition featured image on archives.
remove_action('genesis_entry_content', 'genesis_do_post_image', 8);
add_action('genesis_entry_header', 'genesis_do_post_image', 1);

// Reposition footer widgets.
remove_action('genesis_before_footer', 'genesis_footer_widget_areas');
add_action('genesis_footer', 'genesis_footer_widget_areas', 6);

// Genesis style trump.
remove_action('genesis_meta', 'genesis_load_stylesheet');
add_action('wp_enqueue_scripts', 'genesis_enqueue_main_stylesheet', 99);

// Remove Genesis Portfolio Pro default styles.
add_filter('genesis_portfolio_load_default_styles', '__return_false');

// Remove one click demo branding.
add_filter('pt-ocdi/disable_pt_branding', '__return_true');

add_action('wp_enqueue_scripts', 'business_scripts_styles', 20);
/**
 * Enqueue theme scripts and styles.
 *
 * @since  1.0.0
 *
 * @return void
 */
function business_scripts_styles() {

	// Remove Simple Social Icons CSS (included with theme).
	wp_dequeue_style('simple-social-icons-font');
	wp_dequeue_style('woocommerce-layout');

	// Enqueue Google fonts.
	wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700,900|EB+Garamond:400,600,700', array(), CHILD_THEME_VERSION);

	// Get Icon Widget plugin settings.
	$icon_settings = get_option('icon_widget_settings');

	// Enqueue Line Awesome icon font.
	if ('line-awesome' !== $icon_settings['font']) {

		wp_enqueue_style('business-pro-icons', get_stylesheet_directory_uri().'/assets/styles/min/line-awesome.min.css', array(), CHILD_THEME_VERSION);

	}

	// Enqueue WooCommerce styles conditionally.
	if (class_exists('WooCommerce') && (is_woocommerce() || is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() || is_account_page())) {

		wp_enqueue_style('business-woocommerce', get_stylesheet_directory_uri().'/assets/styles/min/woocommerce.min.css', array(), CHILD_THEME_VERSION);

	} else {
		wp_enqueue_style('business-woocommerce', get_stylesheet_directory_uri().'/assets/styles/min/woocommerce.min.css', array(), CHILD_THEME_VERSION);
	}

	// Enqueue theme scripts.
	wp_enqueue_script('business-pro-theme', get_stylesheet_directory_uri().'/assets/scripts/min/business-pro.min.js', array('jquery'), CHILD_THEME_VERSION, true);

	// Enqueue page-header margin-top js fix
	if (!is_front_page()) {
		wp_enqueue_script('header-height', get_bloginfo('stylesheet_directory').'/assets/scripts/min/header-height.min.js', array('jquery'), CHILD_THEME_VERSION, true);
	}

	// Enqueue responsive menu script.
	wp_enqueue_script('business-menu', get_stylesheet_directory_uri().'/assets/scripts/min/menus.min.js', array('jquery'), CHILD_THEME_VERSION, true);

	// Localize responsive menus script.
	wp_localize_script('business-menu', 'genesis_responsive_menu', array(
			'mainMenu'         => __('Menu', 'business-pro-theme'),
			'subMenu'          => __('Menu', 'business-pro-theme'),
			'menuIconClass'    => null,
			'subMenuIconClass' => null,
			'menuClasses'      => array(
				'combine'         => array(
					'.nav-primary',
				),
			),
		));
}

// Load theme helper functions.
include_once (get_stylesheet_directory().'/includes/helpers.php');

// Load theme specific functions.
include_once (get_stylesheet_directory().'/includes/extras.php');

// Load page header functions.
include_once (get_stylesheet_directory().'/includes/header.php');

// Load widget area functions.
include_once (get_stylesheet_directory().'/includes/widgets.php');

// Load Customizer settings and output.
include_once (get_stylesheet_directory().'/includes/customize.php');

// Load default settings for the theme.
include_once (get_stylesheet_directory().'/includes/defaults.php');

// Load theme's recommended plugins.
include_once (get_stylesheet_directory().'/includes/plugins.php');

// Load shipping rates by weight
include_once (get_stylesheet_directory().'/includes/shipping.php');

// Hide admin bar for non admins
add_action('after_setup_theme', 'ap_hide_admin_bar');
function ap_hide_admin_bar() {
	if (!current_user_can('edit_posts')) {
  		add_filter( 'show_admin_bar', '__return_false', PHP_INT_MAX );
	}
}

// Modify woocommerce smallscreen breakpoint
function ap_filter_woocommerce_style_smallscreen_breakpoint($breakpoint) {
	$breakpoint = '48em';
	return $breakpoint;
};
add_filter('woocommerce_style_smallscreen_breakpoint', 'ap_filter_woocommerce_style_smallscreen_breakpoint', 10, 1);

/* Gallery Thumbnails Sizes */

add_filter('woocommerce_get_image_size_gallery_thumbnail', function ($size) {
	return array(
		'width'  => 206,
		'height' => 206,
		'crop'   => 1,
	);
});

// Cart and Search in main menu
add_filter('wp_nav_menu_items', 'ap_add_search_and_cart_to_menu', 10, 2);
function ap_add_search_and_cart_to_menu($items, $args) {

	global $woocommerce;

	$cart_item = array(
		'cart_url'            => wc_get_cart_url(),
		'cart_contents_count' => $woocommerce->cart->get_cart_contents_count(),
		'cart_total'          => WC()->cart->get_cart_total(),
		'cart_name'           => __('', 'business-pro'),
	);

	if ($args->theme_location == 'primary' && !is_cart()) {

		$items .= "<li class='menu-item header-cart-menu'><a class='cart-contents' href='".$cart_item['cart_url']."'><i class='fa fa-shopping-cart'></i><span class='cart-count'>".$cart_item['cart_contents_count']."</span>".$cart_item['cart_name']."</a></li>";

	} else if ($args->theme_location == 'primary' && is_cart()) {

		return $items;

	}

	return $items;
}

add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();

	?>
	<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><i class="fa fa-shopping-cart"></i><span class="cart-count"><?php echo $woocommerce->cart->cart_contents_count; ?></span></a>
	<?php

	$fragments['a.cart-contents'] = ob_get_clean();
	return $fragments;
}

// Custom breadcrumbs
add_filter( 'genesis_breadcrumb_args', 'ap_custom_breadcrumb_args' );
function ap_custom_breadcrumb_args( $args ) {
	$args['home'] = '<i class="fa fa-home"></i>';   // Home Page
	$args['sep'] = '&nbsp;  &#10146; &nbsp;';  // My favorite arrow
	$args['list_sep'] = ', '; 
	$args['prefix'] = '<div class="breadcrumb">';
	$args['suffix'] = '</div>';
	$args['heirarchial_attachments'] = true; 
	$args['heirarchial_categories'] = true; 
	$args['display'] = true;
	$args['labels']['prefix'] = '';
	return $args;
}
// Customize Footer Text

remove_action('genesis_footer', 'genesis_do_footer');
add_action('genesis_footer', 'ap_custom_footer');
function ap_custom_footer() {
	?>
	<p>Copyright &copy; <?php echo date('Y'); ?> <a href="<?php site_url();?>">Agricola La Svolta</a> - via Gavignano 7 Lastra a Signa (FI) - P.Iva:</p>
	<?php
}