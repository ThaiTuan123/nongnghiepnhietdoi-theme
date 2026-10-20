<?php
/**
 * Footer template — bố cục thương hiệu Nông nghiệp nhiệt đới.
 *
 * Thông tin liên hệ (ĐT, email, địa chỉ) lấy từ "Cài đặt Nông nghiệp nhiệt đới" (ACF options).
 * Các cột liên kết dùng nav menu location kèm fallback đúng thiết kế.
 *
 * @package NongNghiepNhietDoi
 */

// --- Thông tin liên hệ (từ Cài đặt Nông nghiệp nhiệt đới, có fallback) --------------------.
$footer_tagline = 'Giúp cho các doanh nghiệp phát triển trường tồn bằng các giải pháp toàn diện, trở thành Nông nghiệp nhiệt đới.';
$footer_phone   = function_exists( 'nongnghiepnhietdoi_option' ) ? (string) nongnghiepnhietdoi_option( 'contact_phone' ) : '';
$footer_email   = function_exists( 'nongnghiepnhietdoi_option' ) ? (string) nongnghiepnhietdoi_option( 'contact_email' ) : '';
$footer_address = function_exists( 'nongnghiepnhietdoi_option' ) ? (string) nongnghiepnhietdoi_option( 'contact_address' ) : '';

if ( '' === $footer_phone ) {
	$footer_phone = '0968227922';
}
if ( '' === $footer_email ) {
	$footer_email = 'Nông nghiệp nhiệt đớiRealEstate@gmail.com';
}
if ( '' === $footer_address ) {
	$footer_address = "69 Nguyễn Sinh Sắc, Hoà Khánh,\nThành Phố Đà Nẵng";
}

// Mạng xã hội lấy từ trang "Cài đặt Nông nghiệp nhiệt đới" (chỉ link đã nhập).
$footer_socials = function_exists( 'nongnghiepnhietdoi_socials' ) ? nongnghiepnhietdoi_socials() : array();

/**
 * Tạo fallback cho một cột liên kết footer khi chưa gán menu.
 *
 * @param array $links Mảng label => url.
 * @return Closure
 */
$footer_menu_fallback = static function ( array $links ) {
	return static function () use ( $links ) {
		echo '<ul class="lx-footer-links">';
		foreach ( $links as $label => $url ) {
			printf(
				'<li><a href="%s">%s</a></li>',
				esc_url( $url ),
				esc_html( $label )
			);
		}
		echo '</ul>';
	};
};

$footer_nav_args = array(
	'container'  => false,
	'menu_class' => 'lx-footer-links',
	'depth'      => 1,
);

$footer_bg = NONGNGHIEPNHIETDOI_URI . '/assets/images/bgFooter.webp';
?>

<footer id="site-footer" class="site-footer">
	<div class="absolute inset-0 z-0 overflow-hidden" aria-hidden="true">
		<img
			src="<?php echo esc_url( $footer_bg ); ?>"
			alt=""
			class="h-full w-full scale-105 object-cover object-[center_70%]"
			loading="lazy"
			decoding="async"
		>
		<?php // Ảnh sáng → phủ brand + tối vừa đủ để lộ skyline và chữ trắng dễ đọc. ?>
		<div class="absolute inset-0 bg-[#856a3d]/65"></div>
		<div class="absolute inset-0 bg-gradient-to-b from-black/20 via-black/30 to-black/55"></div>
	</div>

	<div class="relative z-10">
	<div class="container-lx py-14 lg:py-16">
		<div class="grid gap-10 md:grid-cols-3 md:gap-x-8 lg:grid-cols-[1.7fr_1fr_1fr_1fr] lg:gap-x-10 lg:gap-y-12">

			<!-- Thương hiệu + liên hệ -->
			<div class="md:col-span-3 lg:col-span-1 lg:row-span-2">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-flex" rel="home">
					<?php nongnghiepnhietdoi_the_logo( '', 'text-2xl font-semibold tracking-wide text-white' ); ?>
				</a>

				<p class="mt-6 max-w-md text-sm leading-relaxed text-white/85 lg:text-base">
					<?php echo esc_html( $footer_tagline ); ?>
				</p>

				<div class="mt-8 grid grid-cols-2 gap-x-6 gap-y-6">
					<div>
						<p class="lx-footer-label"><?php esc_html_e( 'Điện thoại:', 'nongnghiepnhietdoi' ); ?></p>
						<a class="lx-footer-value" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $footer_phone ) ); ?>"><?php echo esc_html( $footer_phone ); ?></a>

						<p class="lx-footer-label mt-6"><?php esc_html_e( 'Email:', 'nongnghiepnhietdoi' ); ?></p>
						<a class="lx-footer-value break-all" href="mailto:<?php echo esc_attr( $footer_email ); ?>"><?php echo esc_html( $footer_email ); ?></a>
					</div>
					<div>
						<p class="lx-footer-label"><?php esc_html_e( 'Địa chỉ', 'nongnghiepnhietdoi' ); ?></p>
						<p class="lx-footer-value"><?php echo nl2br( esc_html( $footer_address ) ); ?></p>
					</div>
				</div>
			</div>

			<!-- Cột: Về chúng tôi -->
			<div>
				<h3 class="lx-footer-heading"><?php esc_html_e( 'Về chúng tôi', 'nongnghiepnhietdoi' ); ?></h3>
				<?php
				wp_nav_menu(
					array_merge(
						$footer_nav_args,
						array(
							'theme_location' => 'footer_1',
							'fallback_cb'    => $footer_menu_fallback(
								array(
									'Trang chủ'  => home_url( '/' ),
									'Giới thiệu' => home_url( '/gioi-thieu/' ),
									'Bất động sản' => home_url( '/bat-dong-san/' ),
									'Thiết kế'   => home_url( '/thiet-ke/' ),
									'Phong Thủy' => home_url( '/phong-thuy/' ),
								)
							),
						)
					)
				);
				?>
			</div>

			<!-- Cột: Tin tức - Sự kiện -->
			<div>
				<h3 class="lx-footer-heading"><?php esc_html_e( 'Tin tức - Sự kiện', 'nongnghiepnhietdoi' ); ?></h3>
				<?php
				wp_nav_menu(
					array_merge(
						$footer_nav_args,
						array(
							'theme_location' => 'footer_2',
							'fallback_cb'    => $footer_menu_fallback(
								array(
									'Tin thị trường'    => home_url( '/tin-tuc/' ),
									'Xu hướng thiết kế' => home_url( '/tin-tuc/' ),
									'Phong thủy nhà ở'  => home_url( '/tin-tuc/' ),
									'Sự kiện nổi bật'   => home_url( '/tin-tuc/' ),
								)
							),
						)
					)
				);
				?>
			</div>

			<!-- Cột: Thông tin khác -->
			<div>
				<h3 class="lx-footer-heading"><?php esc_html_e( 'Thông tin khác', 'nongnghiepnhietdoi' ); ?></h3>
				<?php
				wp_nav_menu(
					array_merge(
						$footer_nav_args,
						array(
							'theme_location' => 'footer_3',
							'fallback_cb'    => $footer_menu_fallback(
								array(
									'Liên hệ' => home_url( '/lien-he/' ),
								)
							),
						)
					)
				);
				?>
			</div>

			<!-- Mạng xã hội -->
			<?php if ( ! empty( $footer_socials ) ) : ?>
				<div class="md:col-span-3 lg:col-span-3 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
					<p class="max-w-sm text-sm text-white/85 lg:text-base">
						<?php esc_html_e( 'Các kênh thông tin trên mạng xã hội của Nông nghiệp nhiệt đớigroup:', 'nongnghiepnhietdoi' ); ?>
					</p>
					<ul class="flex items-center gap-3">
						<?php foreach ( $footer_socials as $key => $social ) : ?>
							<li>
								<a class="lx-social" href="<?php echo esc_url( $social['url'] ); ?>" aria-label="<?php echo esc_attr( $social['label'] ); ?>" target="_blank" rel="noopener">
									<?php nongnghiepnhietdoi_social_icon( $key ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<div class="border-t border-white/20 bg-black/20">
		<div class="container-lx py-5 text-center text-xs text-white/75 sm:text-sm">
			&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php esc_html_e( 'Nông nghiệp nhiệt đới Real Estate. All rights reserved. Công ty TNHH Đầu Tư & Phát Triển Nông nghiệp nhiệt đới.', 'nongnghiepnhietdoi' ); ?>
		</div>
	</div>
	</div>
</footer>

<?php get_template_part( 'template-parts/floating-buttons' ); ?>

<?php wp_footer(); ?>
</body>
</html>
