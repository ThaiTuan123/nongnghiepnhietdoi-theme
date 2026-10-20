<?php
/**
 * Enqueue Vite-built assets. Supports HMR dev server and production manifest.
 *
 * @package NongNghiepNhietDoi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the Vite dev server origin when running `npm run dev`.
 *
 * @return string|false
 */
function nongnghiepnhietdoi_vite_dev_server() {
	if ( file_exists( NONGNGHIEPNHIETDOI_DIR . '/src/.hot' ) ) {
		$url = trim( (string) file_get_contents( NONGNGHIEPNHIETDOI_DIR . '/src/.hot' ) );
		return $url ? untrailingslashit( $url ) : 'http://localhost:5173';
	}
	return false;
}

add_action(
	'wp_enqueue_scripts',
	function () {
		$dev  = nongnghiepnhietdoi_vite_dev_server();
		$main = 'src/main.js';

		if ( $dev ) {
			// Development: load modules from Vite dev server (HMR).
			add_action(
				'wp_head',
				function () use ( $dev, $main ) {
					echo '<script type="module" src="' . esc_url( $dev . '/@vite/client' ) . '"></script>' . "\n";
					echo '<script type="module" src="' . esc_url( $dev . '/' . $main ) . '"></script>' . "\n";
				},
				1
			);
			return;
		}

		// Production: read manifest and enqueue hashed assets.
		$manifest_path = NONGNGHIEPNHIETDOI_DIR . '/dist/.vite/manifest.json';
		if ( ! file_exists( $manifest_path ) ) {
			$manifest_path = NONGNGHIEPNHIETDOI_DIR . '/dist/manifest.json';
		}
		if ( ! file_exists( $manifest_path ) ) {
			return;
		}

		$manifest = json_decode( (string) file_get_contents( $manifest_path ), true );
		if ( empty( $manifest[ $main ] ) ) {
			return;
		}

		$entry    = $manifest[ $main ];
		$dist_uri = NONGNGHIEPNHIETDOI_URI . '/dist/';

		if ( ! empty( $entry['css'] ) ) {
			foreach ( $entry['css'] as $i => $css ) {
				wp_enqueue_style( 'nongnghiepnhietdoi-' . $i, $dist_uri . $css, array(), NONGNGHIEPNHIETDOI_VERSION );
			}
		}

		wp_enqueue_script( 'nongnghiepnhietdoi-main', $dist_uri . $entry['file'], array(), NONGNGHIEPNHIETDOI_VERSION, true );
	}
);

/**
 * Config AJAX form (toast) — luôn inject vì Vite HMR không đi qua wp_enqueue_script.
 */
add_action(
	'wp_footer',
	function () {
		$config = array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'nongnghiepnhietdoi_contact' ),
		);
		echo '<script>window.nongnghiepnhietdoiContact=' . wp_json_encode( $config ) . ';</script>' . "\n";
	},
	5
);

/**
 * Emit type="module" for our production bundle.
 */
add_filter(
	'script_loader_tag',
	function ( $tag, $handle ) {
		if ( 'nongnghiepnhietdoi-main' === $handle ) {
			$tag = str_replace( '<script ', '<script type="module" ', $tag );
		}
		return $tag;
	},
	10,
	2
);
