<?php
/**
 * Footer VARC.
 *
 * @package NongNghiepNhietDoi
 */

$varc_logo_id   = function_exists( 'nongnghiepnhietdoi_option' ) ? (int) nongnghiepnhietdoi_option( 'site_logo' ) : 0;
$varc_logo      = NONGNGHIEPNHIETDOI_URI . '/assets/images/logo-varc.png';
$varc_company   = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'site_company_name' ) : '';
$varc_about     = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'site_about' ) : '';
$varc_address   = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'contact_address' ) : '';
$varc_email     = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'contact_email' ) : '';
$varc_phone     = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'contact_phone' ) : '';
$varc_hours     = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'contact_hours' ) : '';
$varc_socials   = function_exists( 'nongnghiepnhietdoi_socials' ) ? nongnghiepnhietdoi_socials() : array();
$varc_phone_tel = $varc_phone ? preg_replace( '/[^0-9+]/', '', $varc_phone ) : '';
?>

<footer id="site-footer" class="site-footer bg-ink">
	<div class="mx-auto grid max-w-[1200px] gap-10 px-4 py-12 sm:grid-cols-2 sm:py-14 lg:grid-cols-4">
		<div>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-flex items-center gap-3" rel="home">
				<?php if ( $varc_logo_id ) : ?>
					<?php
					echo wp_get_attachment_image(
						$varc_logo_id,
						'full',
						false,
						array(
							'class' => 'lx-logo h-auto max-h-16 w-auto max-w-[220px] object-contain',
							'alt'   => get_bloginfo( 'name' ),
						)
					);
					?>
				<?php else : ?>
					<span class="inline-flex h-14 w-14 items-center justify-center bg-white">
						<img src="<?php echo esc_url( $varc_logo ); ?>" alt="" class="h-12 w-12 object-contain" width="48" height="48">
					</span>
				<?php endif; ?>
			</a>
			<?php if ( $varc_company ) : ?>
				<p class="mt-4 text-sm font-semibold text-white"><?php echo esc_html( $varc_company ); ?></p>
			<?php endif; ?>
			<?php if ( $varc_about ) : ?>
				<p class="mt-3 text-sm leading-relaxed text-white/70"><?php echo esc_html( $varc_about ); ?></p>
			<?php endif; ?>
		</div>

		<div>
			<h2 class="text-sm font-semibold text-white">Liên kết nhanh</h2>
			<ul class="mt-4 space-y-2 text-sm text-white/70">
				<li><a class="hover:text-white" href="<?php echo esc_url( home_url( '/ve-chung-toi/' ) ); ?>">Về Chúng tôi</a></li>
				<li><a class="hover:text-white" href="<?php echo esc_url( home_url( '/linh-vuc-dich-vu/' ) ); ?>">Lĩnh vực &amp; Dịch Vụ</a></li>
				<li><a class="hover:text-white" href="<?php echo esc_url( home_url( '/du-an-tac-dong/' ) ); ?>">Dự Án &amp; Tác Động</a></li>
				<li><a class="hover:text-white" href="<?php echo esc_url( home_url( '/thu-vien-tin-tuc/' ) ); ?>">Thư Viện &amp; Tin Tức</a></li>
				<li><a class="hover:text-white" href="<?php echo esc_url( home_url( '/hop-tac-du-an/' ) ); ?>">Hợp Tác Dự Án</a></li>
			</ul>
		</div>

		<div>
			<h2 class="text-sm font-semibold text-white">Lĩnh vực &amp; Dịch vụ</h2>
			<ul class="mt-4 space-y-2 text-sm text-white/70">
				<li><a class="hover:text-white" href="<?php echo esc_url( home_url( '/linh-vuc-dich-vu/#nghien-cuu' ) ); ?>">Nghiên cứu, Triển khai &amp; Chuyển giao Công nghệ</a></li>
				<li><a class="hover:text-white" href="<?php echo esc_url( home_url( '/linh-vuc-dich-vu/#tu-van' ) ); ?>">Dịch vụ Tư vấn &amp; Đánh giá Dự án Độc lập</a></li>
				<li><a class="hover:text-white" href="<?php echo esc_url( home_url( '/linh-vuc-dich-vu/#de-tai' ) ); ?>">Đề tài KH&amp;CN &amp; Chương trình Quốc gia</a></li>
			</ul>
		</div>

		<div id="lien-he">
			<h2 class="text-sm font-semibold text-white">Liên hệ &amp; Hợp tác</h2>
			<ul class="mt-4 space-y-3 text-sm text-white/75">
				<?php if ( $varc_address ) : ?>
					<li><?php echo nl2br( esc_html( $varc_address ) ); ?></li>
				<?php endif; ?>
				<?php if ( $varc_email ) : ?>
					<li><a class="hover:text-white" href="mailto:<?php echo esc_attr( $varc_email ); ?>"><?php echo esc_html( $varc_email ); ?></a></li>
				<?php endif; ?>
				<?php if ( $varc_phone ) : ?>
					<li><a class="hover:text-white" href="tel:<?php echo esc_attr( $varc_phone_tel ); ?>"><?php echo esc_html( $varc_phone ); ?></a></li>
				<?php endif; ?>
				<?php if ( $varc_hours ) : ?>
					<li><?php echo esc_html( $varc_hours ); ?></li>
				<?php endif; ?>
			</ul>
			<?php if ( $varc_socials ) : ?>
				<ul class="mt-4 flex items-center gap-3">
					<?php foreach ( $varc_socials as $key => $social ) : ?>
						<li>
							<a class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-white hover:bg-brand" href="<?php echo esc_url( $social['url'] ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $social['label'] ); ?>">
								<span class="inline-flex h-4 w-4 [&>svg]:h-full [&>svg]:w-full"><?php nongnghiepnhietdoi_social_icon( $key ); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<form class="mt-4 flex overflow-hidden rounded-lg bg-white/10 ring-1 ring-white/15" action="<?php echo esc_url( home_url( '/#lien-he' ) ); ?>" method="post">
				<label class="sr-only" for="footer-email"><?php esc_html_e( 'Email', 'nongnghiepnhietdoi' ); ?></label>
				<input id="footer-email" name="email" type="email" required placeholder="Email" class="w-full bg-transparent px-3 py-2.5 text-sm text-white placeholder:text-white/50 focus:outline-none">
				<button type="submit" class="bg-brand px-3 text-white hover:bg-brand-700" aria-label="<?php esc_attr_e( 'Đăng ký', 'nongnghiepnhietdoi' ); ?>">→</button>
			</form>
			<p class="mt-2 text-xs text-white/50">Đăng ký nhận bản tin</p>
		</div>
	</div>
	<div class="border-t border-white/10">
		<div class="mx-auto flex max-w-[1200px] flex-col gap-2 px-4 py-4 text-xs text-white/50 sm:flex-row sm:justify-between">
			<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( $varc_company ? $varc_company : get_bloginfo( 'name' ) ); ?>. <?php esc_html_e( 'Bảo lưu mọi quyền.', 'nongnghiepnhietdoi' ); ?></p>
			<a class="hover:text-white" href="<?php echo esc_url( home_url( '/chinh-sach-bao-mat/' ) ); ?>">Chính sách bảo mật</a>
		</div>
	</div>
</footer>

<?php get_template_part( 'template-parts/floating-buttons' ); ?>
<button type="button" class="lx-to-top" data-back-to-top aria-label="<?php esc_attr_e( 'Lên đầu trang', 'nongnghiepnhietdoi' ); ?>" aria-hidden="true" tabindex="-1">
	<span class="lx-to-top__icon" aria-hidden="true">
		<svg viewBox="0 0 24 24" fill="none"><path d="M6 14.5 12 8.5l6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
		<svg viewBox="0 0 24 24" fill="none"><path d="M6 14.5 12 8.5l6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
	</span>
	<span class="lx-to-top__label"><?php esc_html_e( 'Lên đầu trang', 'nongnghiepnhietdoi' ); ?></span>
</button>
<?php wp_footer(); ?>
</body>
</html>
