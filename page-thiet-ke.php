<?php
/**
 * Template Name: Thiết kế
 * Template trang Dịch vụ Thiết kế (/thiet-ke/).
 *
 * Nội dung 3 khối (Về chúng tôi · Dịch vụ · Tại sao chọn) lấy từ ACF
 * (field group: Thiết kế - Nội dung trang). Hero & form tư vấn giữ cấu hình
 * trong file / template-parts.
 *
 * Bố cục desktop (theo mockup):
 *   1. Hero banner
 *   2. Về chúng tôi — ACF
 *   3. Dịch vụ — ACF
 *   4. Tại sao nên chọn chúng tôi — ACF
 *   5. Đăng ký nhận tư vấn
 *
 * @package NongNghiepNhietDoi
 */

/*
============================================================
 * CẤU HÌNH — Hero & form tư vấn (3 khối nội dung lấy từ ACF)
 * ============================================================ */

$lx_page_id = get_queried_object_id();

// --- 1) Hero banner --------------------------------------------------------.
$lx_hero_subtitle  = 'Nông nghiệp nhiệt đới Design';
$lx_hero_title     = 'Thiết kế';
$lx_hero_desc      = 'Kiến tạo không gian sống đẳng cấp, tinh tế và bền vững theo phong cách riêng của bạn.';
$lx_hero_image     = has_post_thumbnail( $lx_page_id ) ? get_the_post_thumbnail_url( $lx_page_id, 'full' ) : '';
$lx_hero_btn_label = 'Xem thêm';
$lx_hero_btn_url   = '#gt-thiet-ke-about';

// --- 2) Về chúng tôi (ACF + fallback) --------------------------------------.
$lx_about_label_default   = 'Về chúng tôi';
$lx_about_title_default   = 'Về chúng tôi';
$lx_about_paras_default   = array(
	'Nông nghiệp nhiệt đới là tập đoàn đầu tư và phát triển bất động sản, hoạt động trong các lĩnh vực tư vấn đầu tư, thiết kế và thi công công trình cao cấp. Với đội ngũ kiến trúc sư giàu kinh nghiệm, chúng tôi mang đến những giải pháp thiết kế toàn diện, tinh tế và bền vững.',
	'Mỗi công trình chúng tôi thực hiện đều là sự kết hợp giữa thẩm mỹ hiện đại và giá trị phong thủy, giúp gia chủ tận hưởng không gian sống trọn vẹn, sang trọng và hài hòa.',
);
$lx_about_link_url_default  = home_url( '/gioi-thieu/' );
$lx_about_link_text_default = 'Xem thêm';

$lx_about_label    = $lx_about_label_default;
$lx_about_title    = $lx_about_title_default;
$lx_about_content  = '';
$lx_about_image    = '';
$lx_about_image_id = 0;
$lx_about_link_url  = $lx_about_link_url_default;
$lx_about_link_text = $lx_about_link_text_default;

if ( function_exists( 'get_field' ) && $lx_page_id ) {
	$lx_about_label   = get_field( 'tk_about_label', $lx_page_id ) ?: $lx_about_label_default;
	$lx_about_title   = get_field( 'tk_about_title', $lx_page_id ) ?: $lx_about_title_default;
	$lx_about_content = (string) get_field( 'tk_about_content', $lx_page_id );
	$img_f            = get_field( 'tk_about_image', $lx_page_id );
	$lx_about_image   = ( is_array( $img_f ) && ! empty( $img_f['url'] ) ) ? $img_f['url'] : '';
	$lx_about_image_id = ( is_array( $img_f ) && ! empty( $img_f['ID'] ) ) ? (int) $img_f['ID'] : 0;
	$link_f           = get_field( 'tk_about_link', $lx_page_id );
	if ( is_array( $link_f ) && ! empty( $link_f['url'] ) ) {
		$lx_about_link_url  = $link_f['url'];
		$lx_about_link_text = ! empty( $link_f['title'] ) ? $link_f['title'] : $lx_about_link_text_default;
	}
}

// --- 3) Dịch vụ (ACF + fallback) -------------------------------------------.
$lx_services_title_default = 'Dịch vụ';
$lx_services_intro_default = 'Nông nghiệp nhiệt đới là đơn vị tiên phong trong lĩnh vực thiết kế và thi công công trình. Với thế mạnh trong không gian sống hiện đại và giá trị phong thủy trong từng chi tiết.';
$lx_services_default       = array(
	array(
		'title'    => 'Thiết kế',
		'image'    => '',
		'image_id' => 0,
		'url'      => '',
	),
	array(
		'title'    => 'Thiết kế nội thất cổ - Phong thủy',
		'image'    => '',
		'image_id' => 0,
		'url'      => '',
	),
);

$lx_services_title = $lx_services_title_default;
$lx_services_intro = $lx_services_intro_default;
$lx_services       = $lx_services_default;

if ( function_exists( 'get_field' ) && $lx_page_id ) {
	$lx_services_title = get_field( 'tk_services_title', $lx_page_id ) ?: $lx_services_title_default;
	$intro             = get_field( 'tk_services_intro', $lx_page_id );
	if ( null !== $intro && '' !== $intro ) {
		$lx_services_intro = (string) $intro;
	}
}

if ( function_exists( 'have_rows' ) && $lx_page_id && have_rows( 'tk_services', $lx_page_id ) ) {
	$lx_services = array();
	while ( have_rows( 'tk_services', $lx_page_id ) ) {
		the_row();
		$img  = get_sub_field( 'image' );
		$link = get_sub_field( 'link' );
		// Hỗ trợ cả field link (mới) và url (cũ, nếu đã sync bản trước).
		$url = '';
		if ( is_array( $link ) && ! empty( $link['url'] ) ) {
			$url = $link['url'];
		} else {
			$legacy_url = get_sub_field( 'url' );
			if ( is_string( $legacy_url ) && '' !== $legacy_url ) {
				$url = $legacy_url;
			}
		}
		$lx_services[] = array(
			'title'    => (string) get_sub_field( 'title' ),
			'url'      => $url,
			'target'   => ( is_array( $link ) && ! empty( $link['target'] ) ) ? $link['target'] : '',
			'image'    => ( is_array( $img ) && ! empty( $img['url'] ) ) ? $img['url'] : '',
			'image_id' => ( is_array( $img ) && ! empty( $img['ID'] ) ) ? (int) $img['ID'] : 0,
		);
	}
}

// --- 4) Tại sao nên chọn chúng tôi (ACF + fallback) -----------------------.
$lx_why_title_default = 'Tại sao nên chọn chúng tôi';
$lx_why_desc_default  = 'Nông nghiệp nhiệt đới tự hào là đơn vị thiết kế uy tín, đồng hành cùng hàng trăm khách hàng kiến tạo nên những không gian sống đẳng cấp và bền vững theo thời gian.';
$lx_why_stats_default = array(
	array(
		'number' => '8+',
		'label'  => 'Dự án thiết kế và thi công',
	),
	array(
		'number' => '60+',
		'label'  => 'Khách hàng tin tưởng & lựa chọn',
	),
	array(
		'number' => '30+',
		'label'  => 'Kiến trúc sư & đội ngũ chuyên viên cao cấp',
	),
);

$lx_why_title    = $lx_why_title_default;
$lx_why_desc     = $lx_why_desc_default;
$lx_why_image    = '';
$lx_why_image_id = 0;
$lx_why_stats    = $lx_why_stats_default;

if ( function_exists( 'get_field' ) && $lx_page_id ) {
	$lx_why_title = get_field( 'tk_why_title', $lx_page_id ) ?: $lx_why_title_default;
	$why_desc     = get_field( 'tk_why_desc', $lx_page_id );
	if ( null !== $why_desc && '' !== $why_desc ) {
		$lx_why_desc = (string) $why_desc;
	}
	$why_img         = get_field( 'tk_why_image', $lx_page_id );
	$lx_why_image    = ( is_array( $why_img ) && ! empty( $why_img['url'] ) ) ? $why_img['url'] : '';
	$lx_why_image_id = ( is_array( $why_img ) && ! empty( $why_img['ID'] ) ) ? (int) $why_img['ID'] : 0;
}

if ( function_exists( 'have_rows' ) && $lx_page_id && have_rows( 'tk_why_stats', $lx_page_id ) ) {
	$lx_why_stats = array();
	while ( have_rows( 'tk_why_stats', $lx_page_id ) ) {
		the_row();
		$lx_why_stats[] = array(
			'number' => (string) get_sub_field( 'number' ),
			'label'  => (string) get_sub_field( 'label' ),
		);
	}
}

// --- 5) Đăng ký nhận tư vấn -----------------------------------------------.
set_query_var(
	'lx_cta',
	array(
		'title' => 'Đăng ký nhận tư vấn',
		'needs' => array(
			'Báo giá thiết kế',
			'Báo giá thi công',
		),
		'types' => array(
			'Biệt thự - Penthouse - Duplex',
			'Nhà phố - Chung cư - Căn hộ',
			'Nhà hàng - Khách sạn - Văn phòng',
		),
	)
);
/* ============================================================ */

get_header();
?>

<main id="main" class="site-main">

	<!-- ============ 1) HERO BANNER ============ -->
	<section class="relative flex min-h-screen items-center justify-center overflow-hidden bg-neutral-900" data-section="thiet-ke-hero" data-dark-hero>
		<div class="absolute inset-0 z-0" data-parallax="0.1">
			<?php if ( $lx_hero_image ) : ?>
				<img src="<?php echo esc_url( $lx_hero_image ); ?>" alt="<?php echo esc_attr( $lx_hero_title ); ?>" class="h-full w-full scale-110 object-cover" fetchpriority="high">
			<?php else : ?>
				<div class="h-full w-full bg-gradient-to-br from-neutral-800 via-neutral-900 to-black"></div>
			<?php endif; ?>
			<div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-black/50 via-black/30 to-black/60"></div>
		</div>

		<div class="container-lx relative z-10 py-32 text-center text-white">
			<div class="mx-auto max-w-3xl">
				<?php if ( $lx_hero_subtitle ) : ?>
					<p class="mb-4 text-sm font-medium uppercase tracking-[0.3em] text-brand-50/90" data-reveal><?php echo esc_html( $lx_hero_subtitle ); ?></p>
				<?php endif; ?>
				<h1 class="text-4xl font-bold uppercase leading-tight sm:text-5xl md:text-6xl lg:text-7xl" data-reveal><?php echo esc_html( $lx_hero_title ); ?></h1>
				<?php if ( $lx_hero_desc ) : ?>
					<p class="mx-auto mt-6 max-w-xl text-base leading-relaxed text-neutral-200 md:text-lg" data-reveal><?php echo esc_html( $lx_hero_desc ); ?></p>
				<?php endif; ?>
				<?php if ( $lx_hero_btn_label && $lx_hero_btn_url ) : ?>
					<div class="mt-8 flex justify-center" data-reveal>
						<a href="<?php echo esc_url( $lx_hero_btn_url ); ?>" class="btn btn-primary"><?php echo esc_html( $lx_hero_btn_label ); ?></a>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<button
			type="button"
			class="absolute bottom-8 left-1/2 z-10 -translate-x-1/2 text-white/70 transition-colors duration-300 hover:text-white focus-visible:text-white"
			data-scroll-indicator
			aria-label="<?php esc_attr_e( 'Cuộn xuống phần tiếp theo', 'nongnghiepnhietdoi' ); ?>"
		>
			<span class="scroll-indicator" aria-hidden="true"></span>
		</button>
	</section>

	<!-- ============ 2) VỀ CHÚNG TÔI ============ -->
	<section id="gt-thiet-ke-about" class="bg-white py-16 md:py-24" data-section="thiet-ke-about">
		<div class="container-lx">
			<div class="mb-12 text-center">
				<h2 class="text-3xl font-bold uppercase leading-tight text-brand md:text-4xl" data-reveal><?php echo esc_html( $lx_about_title ); ?></h2>
				<div class="mx-auto mt-4 h-1 w-16 rounded-full bg-brand" data-reveal-line></div>
			</div>

			<div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2 lg:gap-16">
				<div>
					<?php if ( $lx_about_label ) : ?>
						<p class="mb-3 text-sm font-semibold uppercase tracking-[0.25em] text-brand" data-reveal="left"><?php echo esc_html( $lx_about_label ); ?></p>
					<?php endif; ?>
					<div class="space-y-4 text-base leading-relaxed text-neutral-600 [&_p]:mb-4 [&_p:last-child]:mb-0" data-reveal="left" data-reveal-delay="0.12">
						<?php if ( $lx_about_content ) : ?>
							<?php echo wp_kses_post( $lx_about_content ); ?>
						<?php else : ?>
							<?php foreach ( $lx_about_paras_default as $para ) : ?>
								<p><?php echo esc_html( $para ); ?></p>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
					<?php if ( $lx_about_link_url ) : ?>
						<a href="<?php echo esc_url( $lx_about_link_url ); ?>" class="mt-8 inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-[0.2em] text-brand transition hover:gap-3" data-reveal="left" data-reveal-delay="0.24">
							<?php echo esc_html( $lx_about_link_text ); ?>
							<span aria-hidden="true">&rarr;</span>
						</a>
					<?php endif; ?>
				</div>

				<div data-reveal="image" data-reveal-delay="0.1">
					<div class="overflow-hidden rounded-2xl shadow-lg ring-1 ring-black/5" data-reveal-frame>
						<?php if ( $lx_about_image_id ) : ?>
							<?php
							echo wp_get_attachment_image(
								$lx_about_image_id,
								'large',
								false,
								array(
									'class'   => 'aspect-[16/10] w-full object-cover',
									'loading' => 'lazy',
									'alt'     => $lx_about_title,
								)
							);
							?>
						<?php elseif ( $lx_about_image ) : ?>
							<img src="<?php echo esc_url( $lx_about_image ); ?>" alt="<?php echo esc_attr( $lx_about_title ); ?>" class="aspect-[16/10] w-full object-cover" loading="lazy">
						<?php else : ?>
							<div class="flex aspect-[16/10] w-full items-center justify-center bg-gradient-to-br from-neutral-100 to-brand/10 text-brand/40">
								<svg class="h-16 w-16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-5-5L5 21"/></svg>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- ============ 3) DỊCH VỤ ============ -->
	<section class="bg-white pb-16 md:pb-24" data-section="thiet-ke-services">
		<div class="container-lx">
			<div class="mx-auto max-w-3xl text-center" data-reveal>
				<h2 class="text-3xl font-bold uppercase leading-tight text-brand md:text-4xl"><?php echo esc_html( $lx_services_title ); ?></h2>
				<div class="mx-auto mt-4 h-1 w-16 rounded-full bg-brand"></div>
				<?php if ( $lx_services_intro ) : ?>
					<p class="mt-6 text-base leading-relaxed text-neutral-600"><?php echo esc_html( $lx_services_intro ); ?></p>
				<?php endif; ?>
			</div>

			<div class="mt-12 grid grid-cols-1 gap-6 md:grid-cols-2 md:gap-8" data-reveal-stagger>
				<?php
				foreach ( $lx_services as $service ) :
					if ( empty( $service['title'] ) ) {
						continue;
					}
					$has_link  = ! empty( $service['url'] );
					$tag       = $has_link ? 'a' : 'div';
					$href_attr = $has_link ? ' href="' . esc_url( $service['url'] ) . '"' : '';
					$tgt_attr  = ( $has_link && ! empty( $service['target'] ) ) ? ' target="' . esc_attr( $service['target'] ) . '" rel="noopener noreferrer"' : '';
					$img_id    = ! empty( $service['image_id'] ) ? (int) $service['image_id'] : 0;
					$card_cls  = 'group relative block aspect-[4/3] overflow-hidden rounded-2xl shadow-lg ring-1 ring-black/5' . ( $has_link ? ' cursor-pointer' : '' );
					?>
					<<?php echo $tag; ?><?php echo $href_attr . $tgt_attr; // phpcs:ignore ?> class="<?php echo esc_attr( $card_cls ); ?>">
						<?php if ( $img_id ) : ?>
							<?php
							echo wp_get_attachment_image(
								$img_id,
								'large',
								false,
								array(
									'class'   => 'absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105',
									'loading' => 'lazy',
									'alt'     => $service['title'],
								)
							);
							?>
						<?php elseif ( ! empty( $service['image'] ) ) : ?>
							<img src="<?php echo esc_url( $service['image'] ); ?>" alt="<?php echo esc_attr( $service['title'] ); ?>" class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105" loading="lazy">
						<?php else : ?>
							<div class="absolute inset-0 flex h-full w-full items-center justify-center bg-gradient-to-br from-neutral-300 to-neutral-500 text-white/50">
								<svg class="h-16 w-16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-5-5L5 21"/></svg>
							</div>
						<?php endif; ?>
						<div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
						<h3 class="absolute inset-x-0 bottom-0 p-6 text-xl font-bold uppercase leading-snug tracking-wide text-white md:p-8 md:text-2xl">
							<?php echo esc_html( $service['title'] ); ?>
						</h3>
					</<?php echo $tag; ?>>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- ============ 4) TẠI SAO NÊN CHỌN CHÚNG TÔI ============ -->
	<section class="bg-neutral-50 py-16 md:py-24" data-section="thiet-ke-why">
		<div class="container-lx">
			<div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2 lg:gap-16">

				<!-- Ảnh minh hoạ -->
				<div class="overflow-hidden rounded-2xl shadow-sm ring-1 ring-black/5" data-reveal>
					<?php if ( $lx_why_image_id ) : ?>
						<?php
						echo wp_get_attachment_image(
							$lx_why_image_id,
							'large',
							false,
							array(
								'class'   => 'aspect-[4/3] h-full w-full object-cover',
								'loading' => 'lazy',
								'alt'     => $lx_why_title,
							)
						);
						?>
					<?php elseif ( $lx_why_image ) : ?>
						<img src="<?php echo esc_url( $lx_why_image ); ?>" alt="<?php echo esc_attr( $lx_why_title ); ?>" class="aspect-[4/3] h-full w-full object-cover" loading="lazy">
					<?php else : ?>
						<div class="flex aspect-[4/3] w-full items-center justify-center bg-gradient-to-br from-neutral-200 to-neutral-300 text-neutral-400">
							<svg class="h-16 w-16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-5-5L5 21"/></svg>
						</div>
					<?php endif; ?>
				</div>

				<!-- Nội dung + số liệu -->
				<div data-reveal>
					<h2 class="text-3xl font-bold uppercase leading-tight text-neutral-900 md:text-4xl"><?php echo esc_html( $lx_why_title ); ?></h2>
					<div class="mt-5 h-1 w-16 rounded-full bg-brand"></div>
					<?php if ( $lx_why_desc ) : ?>
						<p class="mt-6 text-base leading-relaxed text-neutral-600"><?php echo esc_html( $lx_why_desc ); ?></p>
					<?php endif; ?>

					<dl class="mt-10 grid grid-cols-2 gap-8" data-reveal-stagger>
						<?php
						foreach ( $lx_why_stats as $s_index => $stat ) :
							$raw    = trim( (string) $stat['number'] );
							$digits = preg_replace( '/[^0-9]/', '', $raw );
							$suffix = ltrim( $raw, '0123456789., ' );
							$props  = wp_json_encode(
								array(
									'value'  => $digits,
									'suffix' => $suffix,
								)
							);
							// Số liệu đầu chiếm cả hàng (căn giữa), giống mockup.
							$col_class = ( 0 === $s_index ) ? 'col-span-2 text-center' : '';
							?>
							<div class="<?php echo esc_attr( $col_class ); ?>">
								<dt class="text-4xl font-bold text-brand md:text-5xl">
									<?php if ( '' !== $digits ) : ?>
										<span data-vue="StatCounter" data-props="<?php echo esc_attr( $props ); ?>"><?php echo esc_html( $raw ); ?></span>
									<?php else : ?>
										<?php echo esc_html( $raw ); ?>
									<?php endif; ?>
								</dt>
								<dd class="mt-2 text-sm leading-snug text-neutral-500"><?php echo esc_html( $stat['label'] ); ?></dd>
							</div>
						<?php endforeach; ?>
					</dl>
				</div>
			</div>
		</div>
	</section>

	<!-- ============ 5) ĐĂNG KÝ NHẬN TƯ VẤN ============ -->
	<?php get_template_part( 'template-parts/consult', 'cta' ); ?>

</main>

<?php
get_footer();
