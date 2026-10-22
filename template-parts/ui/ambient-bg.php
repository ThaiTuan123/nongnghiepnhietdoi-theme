<?php
/**
 * Soft ambient background for utility pages (404, search).
 *
 * @package NongNghiepNhietDoi
 *
 * @param array $args {
 *     @type string $variant Optional. default|empty. Default 'default'.
 * }
 */

$variant = isset( $args['variant'] ) ? (string) $args['variant'] : 'default';
if ( ! in_array( $variant, array( 'default', 'empty' ), true ) ) {
	$variant = 'default';
}
?>
<div class="lx-ambient lx-ambient--<?php echo esc_attr( $variant ); ?>" aria-hidden="true">
	<div class="lx-ambient__wash"></div>
	<span class="lx-ambient__blob lx-ambient__blob--a"></span>
	<span class="lx-ambient__blob lx-ambient__blob--b"></span>
	<span class="lx-ambient__blob lx-ambient__blob--c"></span>
	<svg class="lx-ambient__motif" viewBox="0 0 720 400" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
		<path d="M88 62c28 18 42 48 36 78-22-8-40-28-48-52 4-10 8-18 12-26Z" stroke="currentColor" stroke-width="1.2" opacity=".35"/>
		<path d="M620 48c-34 22-48 58-38 94 26-12 48-36 56-64-6-12-12-22-18-30Z" stroke="currentColor" stroke-width="1.2" opacity=".3"/>
		<path d="M140 300c22-30 62-44 98-28-18 24-48 40-78 42-8-4-14-8-20-14Z" stroke="currentColor" stroke-width="1.15" opacity=".28"/>
		<path d="M560 292c-18-32-54-50-90-38 16 26 44 44 74 48 6-2 12-6 16-10Z" stroke="currentColor" stroke-width="1.15" opacity=".28"/>
		<circle cx="360" cy="200" r="86" stroke="currentColor" stroke-width="1" stroke-dasharray="3 7" opacity=".18"/>
		<circle cx="360" cy="200" r="46" stroke="currentColor" stroke-width="1" opacity=".12"/>
	</svg>
</div>
