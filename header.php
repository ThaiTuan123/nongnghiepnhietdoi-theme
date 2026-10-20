<?php
/**
 * Header — thanh tiện ích + điều hướng VARC.
 *
 * @package NongNghiepNhietDoi
 */

$varc_logo = NONGNGHIEPNHIETDOI_URI . '/assets/images/logo-varc.png';

$varc_menu_args = array(
	'theme_location' => 'primary',
	'container'      => false,
	'fallback_cb'    => false,
	'depth'          => 2,
);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'antialiased overflow-x-hidden bg-bone font-sans text-charcoal' ); ?>>
<?php wp_body_open(); ?>

<a class="skip-link sr-only focus:not-sr-only" href="#main"><?php esc_html_e( 'Bỏ qua tới nội dung', 'nongnghiepnhietdoi' ); ?></a>

<div class="varc-header fixed inset-x-0 top-0 z-50 transition-colors duration-300" data-header>
	<div class="mx-auto flex h-[76px] max-w-[1360px] items-center gap-3 px-4 sm:h-[88px] sm:px-6 lg:px-8">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex shrink-0 items-center gap-2.5" rel="home">
			<img src="<?php echo esc_url( $varc_logo ); ?>" alt="" class="h-10 w-10 rounded-full bg-white object-cover sm:h-11 sm:w-11" width="44" height="44">
			<span class="varc-logo-name text-base font-bold tracking-[0.14em] sm:text-lg">VARC</span>
		</a>

		<nav class="varc-nav hidden min-w-0 flex-1 items-center justify-center gap-0.5 rounded-full bg-brand-900/95 p-1.5 shadow-lg xl:flex" aria-label="<?php esc_attr_e( 'Menu chính', 'nongnghiepnhietdoi' ); ?>">
			<?php
			wp_nav_menu(
				array_merge(
					$varc_menu_args,
					array(
						'menu_class' => 'varc-menu m-0 flex list-none items-center gap-0.5 p-0',
					)
				)
			);
			?>
		</nav>

		<div class="ml-auto flex items-center gap-2">
			<a href="<?php echo esc_url( home_url( '/#lien-he' ) ); ?>" class="varc-cta hidden items-center gap-2 rounded-full bg-brand py-1.5 pl-5 pr-1.5 text-sm font-semibold text-white hover:bg-brand-700 xl:inline-flex">
				<?php esc_html_e( 'Liên hệ', 'nongnghiepnhietdoi' ); ?>
				<span class="varc-cta-icon inline-flex h-9 w-9 items-center justify-center rounded-full bg-sun text-white" aria-hidden="true">
					<svg class="h-4 w-4" viewBox="0 0 16 16" fill="none"><path d="M4 12 12 4M6 4h6v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</span>
			</a>
			<button type="button" class="varc-menu-btn inline-flex items-center justify-center rounded-full p-2 text-white xl:hidden" data-menu-toggle aria-expanded="false" aria-controls="mobile-menu" aria-label="<?php esc_attr_e( 'Mở menu', 'nongnghiepnhietdoi' ); ?>">
				<span class="hamburger" aria-hidden="true"><span></span><span></span><span></span></span>
			</button>
		</div>
	</div>

	<div id="mobile-menu" class="mobile-menu xl:hidden" data-mobile-menu hidden>
		<nav class="px-4 py-4" aria-label="<?php esc_attr_e( 'Menu di động', 'nongnghiepnhietdoi' ); ?>">
			<?php
			wp_nav_menu(
				array_merge(
					$varc_menu_args,
					array(
						'menu_class' => 'lx-mobile-menu m-0 flex list-none flex-col gap-1 p-0',
					)
				)
			);
			?>
		</nav>
	</div>
</div>
