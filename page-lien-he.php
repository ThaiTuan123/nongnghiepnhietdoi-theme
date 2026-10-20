<?php
/**
 * Template trang Liên hệ.
 *
 * Bảng "Thông tin tập đoàn" lấy trực tiếp từ trang "Cài đặt Nông nghiệp nhiệt đới"
 * (ACF options: Điện thoại, Email, Địa chỉ). Muốn sửa nội dung này thì
 * vào WP Admin → Nông nghiệp nhiệt đới → Cài đặt chung.
 *
 * Ảnh minh họa bên trái: chỉnh trong WP Admin khi sửa trang Liên hệ
 * (field ACF "Ảnh minh họa" / lh_info_image).
 *
 * @package NongNghiepNhietDoi
 */

/*
============================================================
 * NỘI DUNG TĨNH — SỬA TRỰC TIẾP TẠI ĐÂY
 * ============================================================ */
$lx_hero_title = 'Liên hệ';
// Ảnh nền banner: ưu tiên Ảnh đại diện của trang. Để rỗng '' sẽ dùng nền gradient tối.
$lx_hero_image = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : '';

$lx_title_1 = 'Liên hệ với chúng tôi';
$lx_title_2 = 'Gửi phản hồi cho chúng tôi';

// Ảnh minh hoạ bên trái khối thông tin — lấy từ ACF trên trang Liên hệ.
$lx_image    = '';
$lx_image_id = 0;
$lx_page_id  = get_queried_object_id();
if ( function_exists( 'get_field' ) && $lx_page_id ) {
	$lx_image_f  = get_field( 'lh_info_image', $lx_page_id );
	$lx_image    = ( is_array( $lx_image_f ) && ! empty( $lx_image_f['url'] ) ) ? $lx_image_f['url'] : '';
	$lx_image_id = ( is_array( $lx_image_f ) && ! empty( $lx_image_f['ID'] ) ) ? (int) $lx_image_f['ID'] : 0;
}

// Nhãn nhỏ phía trên bảng thông tin.
$lx_info_label = 'Thông tin tập đoàn';

// Google Maps: lấy từ Cài đặt chung. Bản đồ Đà Nẵng chỉ là dự phòng khi chưa dán iframe.
$lx_map_embed = nongnghiepnhietdoi_option( 'contact_map' );
if ( ! $lx_map_embed ) {
	$lx_map_embed = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3833.749172773552!2d108.1648072!3d16.0785007!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314218dd16b1fd4d%3A0x71017793b28b4ad8!2zNjkgTmd1eeG7hW4gU2luaCBT4bqvYywgSMOyYSBLaMOhbmgsIMSQw6AgTuG6tW5nIDUwNjA2LCBWaeG7h3QgTmFt!5e0!3m2!1svi!2sth!4v1784456157539!5m2!1svi!2sth" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>';
}
/* ============================================================ */

/*
============================================================
 * BẢNG THÔNG TIN — LẤY TỪ "CÀI ĐẶT NONGNGHIEPNHIETDOI" (ACF OPTIONS)
 * ============================================================ */
$lx_opt_address = nongnghiepnhietdoi_option( 'contact_address' );
$lx_opt_phone   = nongnghiepnhietdoi_option( 'contact_phone' );
$lx_opt_email   = nongnghiepnhietdoi_option( 'contact_email' );
$lx_opt_hours   = nongnghiepnhietdoi_option( 'contact_hours' );

$lx_info = array();

if ( $lx_opt_address ) {
	// Mỗi dòng trong ô Địa chỉ (textarea) thành 1 dòng riêng.
	$lx_address_lines = array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $lx_opt_address ) ) ) );
	if ( $lx_address_lines ) {
		$lx_info[] = array(
			'label' => 'Trụ sở chính:',
			'lines' => $lx_address_lines,
		);
	}
}

if ( $lx_opt_phone ) {
	$lx_info[] = array(
		'label' => 'Điện thoại:',
		'lines' => array( $lx_opt_phone ),
	);
}

if ( $lx_opt_email ) {
	$lx_info[] = array(
		'label' => 'Email:',
		'lines' => array( $lx_opt_email ),
	);
}

if ( $lx_opt_hours ) {
	$lx_info[] = array(
		'label' => 'Giờ làm việc:',
		'lines' => array( $lx_opt_hours ),
	);
}
/* ============================================================ */

get_header();
?>

<main id="main" class="site-main">

	<!-- ============ Hero banner ============ -->
	<section class="relative flex min-h-[52vh] items-center justify-center overflow-hidden bg-neutral-900 pt-24 md:min-h-[60vh]" data-section="lh-hero" data-dark-hero>
		<div class="absolute inset-0 z-0" data-parallax="0.1">
			<?php if ( $lx_hero_image ) : ?>
				<img src="<?php echo esc_url( $lx_hero_image ); ?>" alt="<?php echo esc_attr( $lx_hero_title ); ?>" class="h-full w-full scale-110 object-cover" fetchpriority="high">
			<?php else : ?>
				<div class="h-full w-full bg-gradient-to-br from-neutral-800 via-neutral-900 to-black"></div>
			<?php endif; ?>
		</div>
		<div class="pointer-events-none absolute inset-0 z-0 bg-gradient-to-b from-black/60 via-black/40 to-black/70"></div>

		<div class="container-lx relative z-10 text-center text-white">
			<h1 class="text-4xl font-bold uppercase tracking-wide sm:text-5xl lg:text-6xl" data-reveal><?php echo esc_html( $lx_hero_title ); ?></h1>
			<nav class="mt-4 flex items-center justify-center gap-2 text-sm uppercase tracking-[0.2em] text-white/80" aria-label="breadcrumb" data-reveal>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="transition-colors hover:text-brand-200"><?php esc_html_e( 'Trang chủ', 'nongnghiepnhietdoi' ); ?></a>
				<span aria-hidden="true" class="text-brand-200">/</span>
				<span class="text-brand-200"><?php echo esc_html( $lx_hero_title ); ?></span>
			</nav>
		</div>
	</section>

	<section class="bg-gradient-to-b from-white via-white to-brand/5 py-16 md:py-24" data-section="lien-he">
		<div class="container-lx">

			<!-- ============ Khối 1: Thông tin liên hệ ============ -->
			<div class="mb-6" data-reveal>
				<h2 class="text-3xl font-bold text-neutral-900 md:text-4xl lg:text-[42px]"><?php echo esc_html( $lx_title_1 ); ?></h2>
				<div class="mt-5 h-px w-full bg-neutral-200"></div>
			</div>

			<div class="grid grid-cols-1 gap-8 md:grid-cols-2 md:gap-12" data-reveal>
				<div class="overflow-hidden rounded-lg bg-neutral-100">
					<?php if ( $lx_image_id ) : ?>
						<?php
						echo wp_get_attachment_image(
							$lx_image_id,
							'large',
							false,
							array(
								'class'   => 'h-full min-h-[320px] w-full object-cover',
								'loading' => 'lazy',
								'alt'     => get_bloginfo( 'name' ),
							)
						);
						?>
					<?php elseif ( $lx_image ) : ?>
						<img src="<?php echo esc_url( $lx_image ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="h-full min-h-[320px] w-full object-cover" loading="lazy">
					<?php else : ?>
						<div class="flex h-full min-h-[320px] w-full items-center justify-center bg-gradient-to-br from-neutral-100 to-brand/10 text-brand/40">
							<svg class="h-16 w-16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/><path d="M9 9h.01M9 13h.01M9 17h.01M15 9h.01M15 13h.01M15 17h.01"/></svg>
						</div>
					<?php endif; ?>
				</div>

				<div>
					<p class="text-sm font-medium uppercase tracking-[0.2em] text-brand"><?php echo esc_html( $lx_info_label ); ?></p>
					<div class="mt-3 h-px w-full bg-brand/30"></div>

					<dl>
						<?php foreach ( $lx_info as $row ) : ?>
							<div class="flex flex-col gap-1 border-b border-neutral-200 py-5 sm:flex-row sm:gap-6">
								<dt class="w-32 shrink-0 text-neutral-500"><?php echo esc_html( $row['label'] ); ?></dt>
								<dd class="flex-1 space-y-3 font-semibold text-neutral-900">
									<?php foreach ( $row['lines'] as $line ) : ?>
										<p class="leading-snug"><?php echo esc_html( $line ); ?></p>
									<?php endforeach; ?>
								</dd>
							</div>
						<?php endforeach; ?>
					</dl>
				</div>
			</div>

			<!-- ============ Khối 2: Form phản hồi ============ -->
			<div class="mb-6 mt-20" data-reveal>
				<h2 class="text-3xl font-bold text-neutral-900 md:text-4xl lg:text-[42px]"><?php echo esc_html( $lx_title_2 ); ?></h2>
				<div class="mt-5 h-px w-full bg-neutral-200"></div>
			</div>

			<div class="lx-contact-form" data-reveal>
				<form method="post" action="" novalidate data-lx-form="contact">
					<?php wp_nonce_field( 'nongnghiepnhietdoi_contact', 'nongnghiepnhietdoi_contact_nonce' ); ?>
					<input type="hidden" name="lx_form_source" value="contact">
					<div class="hidden" aria-hidden="true">
						<label>Website<input type="text" name="nongnghiepnhietdoi_website" tabindex="-1" autocomplete="off"></label>
					</div>

					<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
						<div class="space-y-5">
							<div>
								<label for="lx-name"><?php esc_html_e( 'Tên khách hàng', 'nongnghiepnhietdoi' ); ?> <span class="text-brand">*</span></label>
								<input type="text" id="lx-name" name="lx_name" required value="" placeholder="<?php esc_attr_e( 'Nhập tên', 'nongnghiepnhietdoi' ); ?>">
							</div>
							<div>
								<label for="lx-phone"><?php esc_html_e( 'Số điện thoại', 'nongnghiepnhietdoi' ); ?></label>
								<input type="tel" id="lx-phone" name="phone" value="" placeholder="<?php esc_attr_e( 'Nhập số điện thoại', 'nongnghiepnhietdoi' ); ?>">
							</div>
							<div>
								<label for="lx-email"><?php esc_html_e( 'Email', 'nongnghiepnhietdoi' ); ?> <span class="text-brand">*</span></label>
								<input type="email" id="lx-email" name="email" required value="" placeholder="<?php esc_attr_e( 'Nhập email', 'nongnghiepnhietdoi' ); ?>">
							</div>
						</div>

						<div class="flex flex-col">
							<label for="lx-message"><?php esc_html_e( 'Nội dung', 'nongnghiepnhietdoi' ); ?> <span class="text-brand">*</span></label>
							<textarea id="lx-message" name="message" required class="flex-1 !min-h-[220px]" placeholder="<?php esc_attr_e( 'Nhập nội dung tin nhắn', 'nongnghiepnhietdoi' ); ?>"></textarea>
						</div>
					</div>

					<div class="mt-8 flex justify-end">
						<button type="submit" name="nongnghiepnhietdoi_contact_submit" value="1" class="lx-submit-btn" data-lx-submit>
							<span class="lx-submit-label"><span class="mr-2 text-base leading-none">+</span><?php esc_html_e( 'Gửi phản hồi', 'nongnghiepnhietdoi' ); ?></span>
							<span class="lx-submit-loading hidden"><?php esc_html_e( 'Đang gửi…', 'nongnghiepnhietdoi' ); ?></span>
						</button>
					</div>
				</form>
			</div>

			<!-- ============ Khối 3: Google Map ============ -->
			<?php if ( $lx_map_embed ) : ?>
				<div class="mt-12 overflow-hidden rounded-xl border border-neutral-200/70 shadow-sm md:mt-16 [&_iframe]:block [&_iframe]:h-[320px] [&_iframe]:w-full [&_iframe]:md:h-[450px]" data-reveal>
					<?php
					echo wp_kses(
						$lx_map_embed,
						array(
							'iframe' => array(
								'src'             => true,
								'width'           => true,
								'height'          => true,
								'style'           => true,
								'loading'         => true,
								'allowfullscreen' => true,
								'referrerpolicy'  => true,
								'frameborder'     => true,
							),
						)
					);
					?>
				</div>
			<?php endif; ?>

		</div>
	</section>
</main>

<?php
get_footer();
