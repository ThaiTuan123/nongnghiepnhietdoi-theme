<?php
/**
 * Header — thanh tiện ích + điều hướng VARC.
 *
 * @package NongNghiepNhietDoi
 */

$varc_short_name   = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'site_short_name' ) : 'VARC';
$varc_company_name = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'site_company_name' ) : '';

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
	<div class="relative mx-auto flex min-h-[96px] max-w-[1360px] items-center gap-2 px-4 py-2.5 sm:min-h-[108px] sm:gap-3 sm:px-6 sm:py-3 lg:px-8 xl:min-h-[120px]">
		<div class="hidden min-w-0 flex-1 justify-end xl:flex">
			<nav class="varc-nav varc-nav--left flex w-max max-w-full items-center rounded-full bg-[#00A050] p-1.5 shadow-lg" aria-label="<?php esc_attr_e( 'Menu trái', 'nongnghiepnhietdoi' ); ?>">
				<?php
				wp_nav_menu(
					array_merge(
						$varc_menu_args,
						array(
							'menu_class' => 'varc-menu m-0 flex list-none items-center gap-1 p-0',
							'varc_split' => 'left',
						)
					)
				);
				?>
			</nav>
		</div>

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="varc-brand flex shrink-0 flex-col items-center gap-0.5 text-center" rel="home">
			<?php nongnghiepnhietdoi_the_logo( 'h-auto w-auto max-w-[200px] object-contain' ); ?>
			<?php if ( $varc_company_name || $varc_short_name ) : ?>
				<span class="varc-logo-text flex min-w-0 flex-col items-center leading-none">
					<?php if ( $varc_company_name ) : ?>
						<span class="varc-logo-full hidden text-[8px] font-medium tracking-wide sm:block sm:text-[9px] xl:text-[10px]"><?php echo esc_html( $varc_company_name ); ?></span>
					<?php endif; ?>
					<?php if ( $varc_short_name ) : ?>
						<span class="varc-logo-name mt-0.5 text-[9px] font-bold tracking-[0.14em] sm:tracking-[0.16em]"><?php echo esc_html( $varc_short_name ); ?></span>
					<?php endif; ?>
				</span>
			<?php endif; ?>
		</a>

		<div class="hidden min-w-0 flex-1 justify-start xl:flex">
			<nav class="varc-nav varc-nav--right flex w-max max-w-full items-center rounded-full bg-[#00A050] p-1.5 shadow-lg" aria-label="<?php esc_attr_e( 'Menu phải', 'nongnghiepnhietdoi' ); ?>">
				<?php
				wp_nav_menu(
					array_merge(
						$varc_menu_args,
						array(
							'menu_class' => 'varc-menu m-0 flex list-none items-center gap-1 p-0',
							'varc_split' => 'right',
						)
					)
				);
				?>
			</nav>
		</div>

		<div class="ml-auto flex shrink-0 items-center gap-2 xl:ml-2">
			<a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="varc-cta hidden h-11 w-11 items-center justify-center rounded-full bg-[#00A050] text-white hover:bg-[#008a44] xl:inline-flex" aria-label="<?php esc_attr_e( 'Liên hệ', 'nongnghiepnhietdoi' ); ?>">
				<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 6.75A1.75 1.75 0 0 1 5.75 5h12.5A1.75 1.75 0 0 1 20 6.75v10.5A1.75 1.75 0 0 1 18.25 19H5.75A1.75 1.75 0 0 1 4 17.25V6.75Z" stroke="currentColor" stroke-width="1.7"/><path d="m5 7 7 5.5L19 7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</a>
			<div class="varc-lang" aria-label="<?php esc_attr_e( 'Chọn ngôn ngữ', 'nongnghiepnhietdoi' ); ?>">
				<?php echo do_shortcode( '[gtranslate]' ); ?>
			</div>
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
