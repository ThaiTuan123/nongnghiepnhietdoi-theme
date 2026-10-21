<?php
/**
 * Section CTA: Đăng ký nhận tư vấn (ảnh nền + form).
 *
 * Tái sử dụng trên các trang Tin tức / Phong thủy / Dự án / Thiết kế.
 * Form gửi AJAX (toast) qua nongnghiepnhietdoi_ajax_contact; fallback POST nếu không có JS.
 *
 * Có thể ghi đè cấu hình bằng set_query_var trước khi gọi template:
 *   set_query_var( 'lx_cta', array( 'title' => '...', 'image' => '...' ) );
 *
 * @package NongNghiepNhietDoi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$lx_cta_cfg = get_query_var( 'lx_cta', array() );
if ( ! is_array( $lx_cta_cfg ) ) {
	$lx_cta_cfg = array();
}

$lx_cta_default_image = NONGNGHIEPNHIETDOI_URI . '/assets/images/dang_ky_tu_van.webp';

$lx_cta_title = $lx_cta_cfg['title'] ?? __( 'Đăng ký nhận tư vấn', 'nongnghiepnhietdoi' );
$lx_cta_image = array_key_exists( 'image', $lx_cta_cfg ) ? (string) $lx_cta_cfg['image'] : $lx_cta_default_image;
if ( '' === $lx_cta_image ) {
	$lx_cta_image = $lx_cta_default_image;
}
$lx_cta_needs = $lx_cta_cfg['needs'] ?? array(
	'Báo giá thiết kế',
	'Báo giá thi công',
);
$lx_cta_types = $lx_cta_cfg['types'] ?? array(
	'Biệt thự - Penthouse - Duplex',
	'Nhà phố - Chung cư - Căn hộ',
	'Nhà hàng - Khách sạn - Văn phòng',
);
?>
<section id="dang-ky-tu-van" class="relative overflow-hidden py-20 md:py-28" data-section="consult-cta">
	<div class="absolute inset-0 z-0">
		<img
			src="<?php echo esc_url( $lx_cta_image ); ?>"
			alt=""
			class="h-full w-full scale-105 object-cover"
			loading="lazy"
			decoding="async"
		>
		<?php // Overlay đậm hơn phía dưới/cạnh để form dễ đọc, vẫn lộ ảnh nền. ?>
		<div class="absolute inset-0 bg-gradient-to-b from-black/55 via-black/50 to-black/70"></div>
	</div>

	<div class="container-lx relative z-10">
		<div class="mx-auto max-w-3xl rounded-2xl border border-white/15 bg-neutral-950/80 p-6 shadow-2xl backdrop-blur-md md:p-10" data-reveal>
			<h2 class="text-center text-2xl font-bold uppercase tracking-wide text-white md:text-3xl"><?php echo esc_html( $lx_cta_title ); ?></h2>
			<div class="mx-auto mt-3 h-1 w-16 rounded-full bg-brand"></div>
			<p class="mx-auto mt-4 max-w-xl text-center text-sm leading-relaxed text-white/75 md:text-base">
				<?php esc_html_e( 'Để lại thông tin, đội ngũ Nông nghiệp nhiệt đới sẽ liên hệ tư vấn phù hợp với nhu cầu của bạn.', 'nongnghiepnhietdoi' ); ?>
			</p>

			<form method="post" action="" novalidate class="lx-consult-form mt-8" data-lx-form="consult">
				<?php wp_nonce_field( 'nongnghiepnhietdoi_contact', 'nongnghiepnhietdoi_contact_nonce' ); ?>
				<input type="hidden" name="lx_form_source" value="consult">
				<div class="hidden" aria-hidden="true">
					<label>Website<input type="text" name="nongnghiepnhietdoi_website" tabindex="-1" autocomplete="off"></label>
				</div>

				<div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
					<div>
						<label for="lx-cta-name" class="mb-1.5 block text-xs font-medium uppercase tracking-wider text-white/70"><?php esc_html_e( 'Họ và tên', 'nongnghiepnhietdoi' ); ?> <span class="text-brand-200">*</span></label>
						<input type="text" id="lx-cta-name" name="lx_name" required value="" placeholder="<?php esc_attr_e( 'Nhập họ và tên', 'nongnghiepnhietdoi' ); ?>" autocomplete="name">
					</div>
					<div>
						<label for="lx-cta-email" class="mb-1.5 block text-xs font-medium uppercase tracking-wider text-white/70"><?php esc_html_e( 'Email', 'nongnghiepnhietdoi' ); ?> <span class="text-brand-200">*</span></label>
						<input type="email" id="lx-cta-email" name="email" required value="" placeholder="<?php esc_attr_e( 'Nhập email', 'nongnghiepnhietdoi' ); ?>" autocomplete="email">
					</div>
					<div class="sm:col-span-2">
						<label for="lx-cta-phone" class="mb-1.5 block text-xs font-medium uppercase tracking-wider text-white/70"><?php esc_html_e( 'Số điện thoại', 'nongnghiepnhietdoi' ); ?></label>
						<input type="tel" id="lx-cta-phone" name="phone" value="" placeholder="<?php esc_attr_e( 'Nhập số điện thoại', 'nongnghiepnhietdoi' ); ?>" autocomplete="tel">
					</div>
				</div>

				<fieldset class="mt-7">
					<legend class="mb-3 text-sm font-semibold uppercase tracking-wide text-brand-100"><?php esc_html_e( 'Nhu cầu tư vấn', 'nongnghiepnhietdoi' ); ?></legend>
					<div class="grid grid-cols-1 gap-2 sm:grid-cols-2 sm:gap-3">
						<?php foreach ( $lx_cta_needs as $need ) : ?>
							<label class="flex cursor-pointer items-center gap-3 rounded-lg border border-white/10 bg-white/5 px-3 py-2.5 text-sm text-white/95 transition hover:border-brand/40 hover:bg-white/10 has-[:checked]:border-brand/60 has-[:checked]:bg-brand/15">
								<input type="checkbox" name="needs[]" value="<?php echo esc_attr( $need ); ?>" class="h-4 w-4 shrink-0 rounded border-white/40 bg-transparent text-brand focus:ring-brand">
								<span><?php echo esc_html( $need ); ?></span>
							</label>
						<?php endforeach; ?>
					</div>
				</fieldset>

				<fieldset class="mt-6">
					<legend class="mb-3 text-sm font-semibold uppercase tracking-wide text-brand-100"><?php esc_html_e( 'Loại hình công trình', 'nongnghiepnhietdoi' ); ?></legend>
					<div class="grid grid-cols-1 gap-2 sm:gap-3">
						<?php foreach ( $lx_cta_types as $type ) : ?>
							<label class="flex cursor-pointer items-center gap-3 rounded-lg border border-white/10 bg-white/5 px-3 py-2.5 text-sm text-white/95 transition hover:border-brand/40 hover:bg-white/10 has-[:checked]:border-brand/60 has-[:checked]:bg-brand/15">
								<input type="radio" name="project_type" value="<?php echo esc_attr( $type ); ?>" class="h-4 w-4 shrink-0 border-white/40 bg-transparent text-brand focus:ring-brand">
								<span><?php echo esc_html( $type ); ?></span>
							</label>
						<?php endforeach; ?>
					</div>
				</fieldset>

				<div class="mt-8 flex justify-center">
					<button type="submit" name="nongnghiepnhietdoi_contact_submit" value="1" class="btn btn-primary min-w-[220px]" data-lx-submit>
						<span class="lx-submit-label"><?php esc_html_e( 'Tư vấn ngay', 'nongnghiepnhietdoi' ); ?></span>
						<span class="lx-submit-loading hidden"><?php esc_html_e( 'Đang gửi…', 'nongnghiepnhietdoi' ); ?></span>
					</button>
				</div>
			</form>
		</div>
	</div>
</section>
