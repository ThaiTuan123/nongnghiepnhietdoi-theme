<?php
/**
 * Section: Liên hệ.
 *
 * Khối thông tin + form trong một card. Map (nếu có) full-width bên dưới.
 *
 * @package NongNghiepNhietDoi
 */

$label = get_sub_field( 'label' );
$title = get_sub_field( 'title' );
$desc  = get_sub_field( 'description' );
$map   = get_sub_field( 'map_embed' );

$phone   = nongnghiepnhietdoi_option( 'contact_phone' );
$email   = nongnghiepnhietdoi_option( 'contact_email' );
$address = nongnghiepnhietdoi_option( 'contact_address' );

$lx_uid   = 'lx-sec-' . ( function_exists( 'get_row_index' ) ? (int) get_row_index() : wp_unique_id() );
$has_info = $phone || $email || $address;
?>
<section class="relative overflow-hidden bg-white py-20 md:py-28" data-section="lien-he">
	<div class="pointer-events-none absolute -left-24 top-10 h-72 w-72 rounded-full bg-brand/[0.06] blur-3xl" aria-hidden="true"></div>
	<div class="pointer-events-none absolute -right-24 bottom-0 h-80 w-80 rounded-full bg-brand/[0.06] blur-3xl" aria-hidden="true"></div>

	<div class="container-lx relative">
		<div class="mx-auto max-w-2xl text-center">
			<?php if ( $label ) : ?>
				<p class="mb-3 inline-flex items-center gap-2 text-sm font-medium uppercase tracking-[0.25em] text-brand" data-reveal>
					<span class="h-px w-8 bg-brand/60"></span><?php echo esc_html( $label ); ?><span class="h-px w-8 bg-brand/60"></span>
				</p>
			<?php endif; ?>
			<?php if ( $title ) : ?>
				<h2 class="text-3xl font-bold text-neutral-900 md:text-4xl lg:text-5xl" data-reveal><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>
			<?php if ( $desc ) : ?>
				<p class="mt-4 text-neutral-600" data-reveal><?php echo esc_html( $desc ); ?></p>
			<?php endif; ?>
		</div>

		<div class="mt-12 overflow-hidden rounded-2xl border border-brand/35 bg-white shadow-md md:mt-14 lg:rounded-3xl" data-reveal>
			<div class="grid grid-cols-1 items-stretch lg:grid-cols-5">
				<?php if ( $has_info ) : ?>
					<aside class="flex flex-col border-b border-brand/20 bg-neutral-50 px-6 py-8 sm:px-8 sm:py-9 lg:col-span-2 lg:border-b-0 lg:border-r lg:px-9 lg:py-10">
						<div class="mb-6">
							<span class="mb-2 block h-0.5 w-10 bg-brand" aria-hidden="true"></span>
							<h3 class="text-xl font-semibold text-neutral-900"><?php esc_html_e( 'Thông tin liên hệ', 'nongnghiepnhietdoi' ); ?></h3>
							<p class="mt-1.5 text-sm leading-relaxed text-neutral-600">
								<?php esc_html_e( 'Đội ngũ Nông nghiệp nhiệt đới sẵn sàng hỗ trợ bạn.', 'nongnghiepnhietdoi' ); ?>
							</p>
						</div>

						<ul class="divide-y divide-brand/15 rounded-xl border border-brand/25 bg-white shadow-sm">
							<?php if ( $phone ) : ?>
								<li>
									<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" class="group flex items-center gap-2 px-5 py-3.5 transition hover:bg-brand/[0.04]">
										<span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-brand/10 text-brand transition group-hover:bg-brand group-hover:text-white">
											<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
										</span>
										<span class="min-w-0">
											<span class="block text-[11px] font-medium uppercase tracking-[0.16em] text-neutral-500"><?php esc_html_e( 'Điện thoại', 'nongnghiepnhietdoi' ); ?></span>
											<span class="mt-0.5 block break-words text-sm font-semibold text-neutral-900 transition group-hover:text-brand"><?php echo esc_html( $phone ); ?></span>
										</span>
									</a>
								</li>
							<?php endif; ?>

							<?php if ( $email ) : ?>
								<li>
									<a href="mailto:<?php echo esc_attr( $email ); ?>" class="group flex items-center gap-2 px-5 py-3.5 transition hover:bg-brand/[0.04]">
										<span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-brand/10 text-brand transition group-hover:bg-brand group-hover:text-white">
											<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
										</span>
										<span class="min-w-0">
											<span class="block text-[11px] font-medium uppercase tracking-[0.16em] text-neutral-500"><?php esc_html_e( 'Email', 'nongnghiepnhietdoi' ); ?></span>
											<span class="mt-0.5 block break-words text-sm font-semibold text-neutral-900 transition group-hover:text-brand"><?php echo esc_html( $email ); ?></span>
										</span>
									</a>
								</li>
							<?php endif; ?>

							<?php if ( $address ) : ?>
								<li class="flex items-center gap-2 px-5 py-3.5">
									<span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-brand/10 text-brand">
										<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>
									</span>
									<span class="min-w-0">
										<span class="block text-[11px] font-medium uppercase tracking-[0.16em] text-neutral-500"><?php esc_html_e( 'Địa chỉ', 'nongnghiepnhietdoi' ); ?></span>
										<span class="mt-0.5 block text-sm font-semibold leading-snug text-neutral-900"><?php echo wp_kses_post( $address ); ?></span>
									</span>
								</li>
							<?php endif; ?>
						</ul>
					</aside>
				<?php endif; ?>

				<div class="<?php echo $has_info ? 'lg:col-span-3' : 'lg:col-span-5'; ?>">
					<div class="lx-contact-form h-full bg-white px-6 py-8 sm:px-8 sm:py-9 lg:px-10 lg:py-10">
						<div class="mb-6">
							<span class="mb-2 block h-0.5 w-10 bg-brand" aria-hidden="true"></span>
							<h3 class="text-xl font-semibold text-neutral-900"><?php esc_html_e( 'Gửi phản hồi', 'nongnghiepnhietdoi' ); ?></h3>
							<p class="mt-1.5 text-sm leading-relaxed text-neutral-600">
								<?php esc_html_e( 'Điền thông tin bên dưới, chúng tôi sẽ phản hồi sớm nhất.', 'nongnghiepnhietdoi' ); ?>
							</p>
						</div>

						<form method="post" action="" novalidate data-lx-form="contact">
							<?php wp_nonce_field( 'nongnghiepnhietdoi_contact', 'nongnghiepnhietdoi_contact_nonce' ); ?>
							<input type="hidden" name="lx_form_source" value="contact">
							<div class="hidden" aria-hidden="true">
								<label>Website<input type="text" name="nongnghiepnhietdoi_website" tabindex="-1" autocomplete="off"></label>
							</div>

							<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5">
								<div>
									<label for="<?php echo esc_attr( $lx_uid ); ?>-name"><?php esc_html_e( 'Tên khách hàng', 'nongnghiepnhietdoi' ); ?> <span class="text-brand">*</span></label>
									<input type="text" id="<?php echo esc_attr( $lx_uid ); ?>-name" name="lx_name" required value="" placeholder="<?php esc_attr_e( 'Nhập tên', 'nongnghiepnhietdoi' ); ?>" autocomplete="name">
								</div>
								<div>
									<label for="<?php echo esc_attr( $lx_uid ); ?>-phone"><?php esc_html_e( 'Số điện thoại', 'nongnghiepnhietdoi' ); ?></label>
									<input type="tel" id="<?php echo esc_attr( $lx_uid ); ?>-phone" name="phone" value="" placeholder="<?php esc_attr_e( 'Nhập số điện thoại', 'nongnghiepnhietdoi' ); ?>" autocomplete="tel">
								</div>
								<div class="sm:col-span-2">
									<label for="<?php echo esc_attr( $lx_uid ); ?>-email"><?php esc_html_e( 'Email', 'nongnghiepnhietdoi' ); ?> <span class="text-brand">*</span></label>
									<input type="email" id="<?php echo esc_attr( $lx_uid ); ?>-email" name="email" required value="" placeholder="<?php esc_attr_e( 'Nhập email', 'nongnghiepnhietdoi' ); ?>" autocomplete="email">
								</div>
								<div class="sm:col-span-2">
									<label for="<?php echo esc_attr( $lx_uid ); ?>-message"><?php esc_html_e( 'Nội dung', 'nongnghiepnhietdoi' ); ?> <span class="text-brand">*</span></label>
									<textarea id="<?php echo esc_attr( $lx_uid ); ?>-message" name="message" required rows="4" class="!min-h-[120px]" placeholder="<?php esc_attr_e( 'Nhập nội dung tin nhắn', 'nongnghiepnhietdoi' ); ?>"></textarea>
								</div>
							</div>

							<div class="mt-6 flex justify-end">
								<button type="submit" name="nongnghiepnhietdoi_contact_submit" value="1" class="lx-submit-btn" data-lx-submit>
									<span class="lx-submit-label"><span class="mr-2 text-base leading-none">+</span><?php esc_html_e( 'Gửi phản hồi', 'nongnghiepnhietdoi' ); ?></span>
									<span class="lx-submit-loading hidden"><?php esc_html_e( 'Đang gửi…', 'nongnghiepnhietdoi' ); ?></span>
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<?php if ( $map ) : ?>
			<div class="mt-6 overflow-hidden rounded-2xl border border-brand/30 shadow-sm lg:rounded-3xl [&_iframe]:block [&_iframe]:h-full [&_iframe]:min-h-[300px] [&_iframe]:w-full md:[&_iframe]:min-h-[360px]" data-reveal>
				<?php
				echo wp_kses(
					$map,
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
