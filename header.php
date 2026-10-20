<?php
/**
 * Header template.
 *
 * @package NongNghiepNhietDoi
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'antialiased text-neutral-800 bg-white' ); ?>>
<?php wp_body_open(); ?>

<a class="skip-link sr-only focus:not-sr-only" href="#main"><?php esc_html_e( 'Bỏ qua tới nội dung', 'nongnghiepnhietdoi' ); ?></a>

<header
	id="site-header"
	class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
	data-header
>
	<div class="container-lx flex h-16 items-center justify-between md:h-18 lg:h-24">
		<!-- Trái: Logo -->
		<div class="flex flex-1 justify-start">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2" rel="home">
				<?php nongnghiepnhietdoi_the_logo(); ?>
			</a>
		</div>

		<!-- Giữa: Main-menu (1 hàng, menu con dạng dropdown) -->
		<nav class="hidden flex-1 justify-center lg:flex" aria-label="<?php esc_attr_e( 'Menu chính', 'nongnghiepnhietdoi' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'lx-menu flex flex-nowrap items-center gap-6 whitespace-nowrap text-[16px] font-medium uppercase tracking-wide xl:gap-8',
					'fallback_cb'    => false,
					'depth'          => 2,
				)
			);
			?>
		</nav>

		<!-- Phải: G|translate + nút menu (mobile) -->
		<div class="flex flex-1 items-center justify-end gap-3">
			<?php if ( shortcode_exists( 'gtranslate' ) ) : ?>
				<div class="gt-header flex items-center"><?php echo do_shortcode( '[gtranslate]' ); ?></div>
			<?php endif; ?>

			<button
				type="button"
				class="inline-flex items-center justify-center rounded p-2 lg:hidden"
				data-menu-toggle
				aria-expanded="false"
				aria-controls="mobile-menu"
				aria-label="<?php esc_attr_e( 'Mở menu', 'nongnghiepnhietdoi' ); ?>"
			>
				<span class="hamburger" aria-hidden="true"><span></span><span></span><span></span></span>
			</button>
		</div>
	</div>

	<div id="mobile-menu" class="mobile-menu lg:hidden" data-mobile-menu hidden>
		<nav class="container-lx py-6" aria-label="<?php esc_attr_e( 'Menu di động', 'nongnghiepnhietdoi' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'lx-mobile-menu flex flex-col gap-1 text-lg font-medium',
					'fallback_cb'    => false,
					'depth'          => 2,
				)
			);
			?>
		</nav>
	</div>
</header>
