<?php
/**
 * Nông nghiệp nhiệt đới Theme bootstrap.
 *
 * @package NongNghiepNhietDoi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NONGNGHIEPNHIETDOI_VERSION', '1.0.0' );
define( 'NONGNGHIEPNHIETDOI_DIR', get_template_directory() );
define( 'NONGNGHIEPNHIETDOI_URI', get_template_directory_uri() );

require_once NONGNGHIEPNHIETDOI_DIR . '/inc/theme-setup.php';
require_once NONGNGHIEPNHIETDOI_DIR . '/inc/svg-icons.php';
require_once NONGNGHIEPNHIETDOI_DIR . '/inc/menus.php';
require_once NONGNGHIEPNHIETDOI_DIR . '/inc/enqueue.php';
require_once NONGNGHIEPNHIETDOI_DIR . '/inc/acf.php';
require_once NONGNGHIEPNHIETDOI_DIR . '/inc/about.php';
require_once NONGNGHIEPNHIETDOI_DIR . '/inc/board.php';
require_once NONGNGHIEPNHIETDOI_DIR . '/inc/partners.php';
require_once NONGNGHIEPNHIETDOI_DIR . '/inc/services.php';
require_once NONGNGHIEPNHIETDOI_DIR . '/inc/projects.php';
require_once NONGNGHIEPNHIETDOI_DIR . '/inc/partnership.php';
require_once NONGNGHIEPNHIETDOI_DIR . '/inc/contact-form.php';
require_once NONGNGHIEPNHIETDOI_DIR . '/inc/cf7.php';
require_once NONGNGHIEPNHIETDOI_DIR . '/inc/seo.php';
require_once NONGNGHIEPNHIETDOI_DIR . '/inc/library.php';
