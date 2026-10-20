<?php
/**
 * Template Name: Giới thiệu
 * Template trang Giới thiệu (About Nông nghiệp nhiệt đới).
 *
 * Nội dung khối "Về chúng tôi" và "Tầm nhìn / Sứ mệnh / Giá trị" lấy từ ACF
 * (field group: Giới thiệu - Nội dung trang). Các khối Hero & Tại sao chọn
 * vẫn cấu hình trong file này.
 *
 * Bố cục desktop:
 *   1. Hero banner (tiêu đề + breadcrumb)
 *   2. "Về Nông nghiệp nhiệt đới" (giới thiệu + video/ảnh) — ACF
 *   3. Tầm nhìn · Sứ mệnh · Giá trị cốt lõi — ACF
 *   4. "Tại sao nên chọn chúng tôi?" (lưới lý do)
 *
 * @package NongNghiepNhietDoi
 */

/*
============================================================
 * CẤU HÌNH NỘI DUNG — Hero & "Tại sao chọn chúng tôi"
 * (2 khối About / Pillars lấy từ ACF trên trang Giới thiệu)
 * ============================================================ */

// --- 1) Hero banner --------------------------------------------------------.
$lx_hero_title = 'Giới thiệu';
// Ảnh nền banner: ưu tiên dùng Ảnh đại diện (Featured Image) của trang.
// Nếu chưa đặt ảnh đại diện, có thể dán URL trực tiếp vào đây; để rỗng '' sẽ dùng nền gradient tối.
$lx_hero_image = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : '';

// --- 2) Khối "Về Nông nghiệp nhiệt đới" (ACF + fallback) ---------------------------.
$lx_page_id             = get_queried_object_id();
$lx_about_label_default = 'Về chúng tôi';
$lx_about_title_default = 'Về Nông nghiệp nhiệt đới';
$lx_about_paras_default = array(
	'Nông nghiệp nhiệt đới là tập đoàn đầu tư và phát triển bất động sản, hoạt động trong các lĩnh vực tư vấn đầu tư, phân phối và phát triển dự án bất động sản cao cấp. Với đội ngũ chuyên gia giàu kinh nghiệm, chúng tôi mang đến cho khách hàng những giải pháp đầu tư toàn diện, minh bạch và bền vững.',
	'Không ngừng đổi mới và hoàn thiện, Nông nghiệp nhiệt đới từng bước khẳng định vị thế thương hiệu uy tín trên thị trường bất động sản, cam kết đồng hành cùng khách hàng trên hành trình kiến tạo giá trị và thịnh vượng dài lâu.',
);

$lx_about_label    = $lx_about_label_default;
$lx_about_title    = $lx_about_title_default;
$lx_about_content  = '';
$lx_about_video    = '';
$lx_about_image    = '';
$lx_about_image_id = 0;

if ( function_exists( 'get_field' ) && $lx_page_id ) {
	$lx_about_label    = get_field( 'gt_about_label', $lx_page_id ) ?: $lx_about_label_default;
	$lx_about_title    = get_field( 'gt_about_title', $lx_page_id ) ?: $lx_about_title_default;
	$lx_about_content  = (string) get_field( 'gt_about_content', $lx_page_id );
	$lx_about_video    = (string) get_field( 'gt_about_video', $lx_page_id );
	$lx_about_image_f  = get_field( 'gt_about_image', $lx_page_id );
	$lx_about_image    = ( is_array( $lx_about_image_f ) && ! empty( $lx_about_image_f['url'] ) ) ? $lx_about_image_f['url'] : '';
	$lx_about_image_id = ( is_array( $lx_about_image_f ) && ! empty( $lx_about_image_f['ID'] ) ) ? (int) $lx_about_image_f['ID'] : 0;
}

// --- 3) Tầm nhìn / Sứ mệnh / Giá trị cốt lõi (ACF + fallback) ------------.
$lx_pillars_default = array(
	array(
		'title'    => 'Tầm nhìn',
		'text'     => 'Trở thành tập đoàn bất động sản hàng đầu, dẫn dắt thị trường bằng những sản phẩm và dịch vụ đẳng cấp, kiến tạo không gian sống bền vững và nâng tầm giá trị cộng đồng.',
		'image'    => '',
		'image_id' => 0,
	),
	array(
		'title'    => 'Sứ mệnh',
		'text'     => 'Kiến tạo những không gian sống và cơ hội đầu tư đẳng cấp, mang lại giá trị thực cùng sự an tâm cho khách hàng và đối tác; góp phần phát triển đô thị văn minh, hiện đại.',
		'image'    => '',
		'image_id' => 0,
	),
	array(
		'title'    => 'Giá trị cốt lõi',
		'text'     => 'Uy tín – Tận tâm – Minh bạch – Đổi mới. Nông nghiệp nhiệt đới luôn đặt chữ Tín lên hàng đầu, đồng hành và bảo vệ lợi ích của khách hàng, không ngừng sáng tạo để mang đến những giá trị vượt trội.',
		'image'    => '',
		'image_id' => 0,
	),
);

$lx_pillars = $lx_pillars_default;
if ( function_exists( 'have_rows' ) && $lx_page_id && have_rows( 'gt_pillars', $lx_page_id ) ) {
	$lx_pillars = array();
	while ( have_rows( 'gt_pillars', $lx_page_id ) ) {
		the_row();
		$img          = get_sub_field( 'image' );
		$lx_pillars[] = array(
			'title'    => (string) get_sub_field( 'title' ),
			'text'     => (string) get_sub_field( 'text' ),
			'image'    => ( is_array( $img ) && ! empty( $img['url'] ) ) ? $img['url'] : '',
			'image_id' => ( is_array( $img ) && ! empty( $img['ID'] ) ) ? (int) $img['ID'] : 0,
		);
	}
}

// --- 4) Tại sao nên chọn chúng tôi ----------------------------------------.
$lx_why_title = 'Tại sao nên chọn chúng tôi?';
// icon: shield | users | building | award | idea | handshake
$lx_why_items = array(
	array(
		'icon'  => 'shield',
		'title' => 'Uy tín & Minh bạch',
		'text'  => 'Nông nghiệp nhiệt đới cam kết minh bạch trong mọi giao dịch, đặt quyền lợi và sự an tâm của khách hàng lên hàng đầu.',
	),
	array(
		'icon'  => 'users',
		'title' => 'Đội ngũ chuyên nghiệp, tận tâm',
		'text'  => 'Đội ngũ chuyên gia giàu kinh nghiệm, am hiểu thị trường, tư vấn tận tâm nhằm mang đến giải pháp đầu tư tối ưu cho khách hàng.',
	),
	array(
		'icon'  => 'building',
		'title' => 'Sản phẩm chất lượng',
		'text'  => 'Tập trung vào các dự án bất động sản có vị trí đắc địa, pháp lý rõ ràng và tiềm năng tăng trưởng bền vững.',
	),
	array(
		'icon'  => 'award',
		'title' => 'Thương hiệu uy tín',
		'text'  => 'Nhiều năm kinh nghiệm trong lĩnh vực đầu tư và phát triển bất động sản, Nông nghiệp nhiệt đới là đối tác đáng tin cậy trên thị trường.',
	),
	array(
		'icon'  => 'idea',
		'title' => 'Đổi mới, sáng tạo',
		'text'  => 'Không ngừng cập nhật xu hướng, ứng dụng công nghệ và tư duy đổi mới để nâng tầm trải nghiệm của khách hàng.',
	),
);
/* ============================================================ */

/**
 * In ra icon SVG cho khối "Tại sao chọn chúng tôi".
 *
 * @param string $key Tên icon.
 * @return void
 */
function nongnghiepnhietdoi_gt_icon( $key ) {
	$common = 'viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-7 w-7"';
	$paths  = array(
		'shield'    => '<path d="M12 3l7 3v5c0 4.5-3 8-7 10-4-2-7-5.5-7-10V6l7-3z"/><path d="m9 12 2 2 4-4"/>',
		'users'     => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
		'building'  => '<path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/><path d="M9 9h.01M9 13h.01M9 17h.01M15 9h.01M15 13h.01M15 17h.01"/>',
		'award'     => '<circle cx="12" cy="8" r="5"/><path d="M8.5 12.5 7 22l5-3 5 3-1.5-9.5"/>',
		'idea'      => '<path d="M9 18h6"/><path d="M10 22h4"/><path d="M12 2a7 7 0 0 0-4 12.7c.6.5 1 1.2 1 2h6c0-.8.4-1.5 1-2A7 7 0 0 0 12 2z"/>',
		'handshake' => '<path d="m11 17 2 2a1 1 0 0 0 1.4 0l3.6-3.6"/><path d="m15 11-2-2a2 2 0 0 0-2.8 0l-3.5 3.5a2 2 0 0 0 0 2.8L8 17"/><path d="m21 3-6 6-3-3"/><path d="M3 21l3-3"/>',
	);

	$svg = '<svg ' . $common . '>' . ( $paths[ $key ] ?? $paths['shield'] ) . '</svg>';

	echo wp_kses(
		$svg,
		array(
			'svg'    => array(
				'viewbox'         => true,
				'fill'            => true,
				'stroke'          => true,
				'stroke-width'    => true,
				'stroke-linecap'  => true,
				'stroke-linejoin' => true,
				'class'           => true,
			),
			'path'   => array( 'd' => true ),
			'circle' => array(
				'cx' => true,
				'cy' => true,
				'r'  => true,
			),
		)
	);
}

get_header();
?>

<main id="main" class="site-main">

	<!-- ============ 1) HERO BANNER ============ -->
	<section class="relative flex min-h-[52vh] items-center justify-center overflow-hidden bg-neutral-900 pt-24 md:min-h-[60vh]" data-section="gt-hero" data-dark-hero>
		<div class="absolute inset-0 z-0" data-parallax="0.1">
			<?php if ( $lx_hero_image ) : ?>
				<img src="<?php echo esc_url( $lx_hero_image ); ?>" alt="<?php echo esc_attr( $lx_hero_title ); ?>" class="h-full w-full scale-110 object-cover [object-position:center_85%]" fetchpriority="high">
			<?php else : ?>
				<div class="h-full w-full bg-gradient-to-br from-neutral-800 via-neutral-900 to-black"></div>
			<?php endif; ?>
		</div>
		<?php // Lớp phủ tối tách khỏi wrapper parallax để luôn phủ kín hero (không bị đẩy xuống theo hiệu ứng parallax). ?>
		<div class="pointer-events-none absolute inset-0 z-0 bg-gradient-to-b from-black/60 via-black/40 to-black/70"></div>

		<div class="container-lx relative z-10 text-center text-white">
			<h1 class="text-4xl font-bold uppercase tracking-wide sm:text-5xl lg:text-6xl" data-reveal><?php echo esc_html( $lx_hero_title ); ?></h1>
			<nav class="mt-4 flex items-center justify-center gap-2 text-sm uppercase tracking-[0.2em] text-white/80" aria-label="breadcrumb" data-reveal data-reveal-delay="0.12">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="transition-colors hover:text-brand-200"><?php esc_html_e( 'Trang chủ', 'nongnghiepnhietdoi' ); ?></a>
				<span aria-hidden="true" class="text-brand-200">/</span>
				<span class="text-brand-200"><?php echo esc_html( $lx_hero_title ); ?></span>
			</nav>
		</div>
	</section>

	<!-- ============ 2) VỀ NONGNGHIEPNHIETDOI GROUP ============ -->
	<section class="bg-white py-16 md:py-24" data-section="gt-about">
		<div class="container-lx grid grid-cols-1 items-start gap-10 lg:grid-cols-2 lg:gap-16">
			<div>
				<p class="mb-3 text-sm font-semibold uppercase tracking-[0.25em] text-brand" data-reveal="left"><?php echo esc_html( $lx_about_label ); ?></p>
				<h2 class="text-3xl font-bold leading-tight text-neutral-900 md:text-4xl" data-reveal="left" data-reveal-delay="0.08"><?php echo esc_html( $lx_about_title ); ?></h2>
				<div class="mt-4 h-1 w-16 rounded-full bg-brand" data-reveal-line data-reveal-delay="0.18"></div>
				<div class="mt-6 space-y-4 text-base leading-relaxed text-neutral-600 [&_p]:mb-4 [&_p:last-child]:mb-0" data-reveal="left" data-reveal-delay="0.2">
					<?php if ( $lx_about_content ) : ?>
						<?php echo wp_kses_post( $lx_about_content ); ?>
					<?php else : ?>
						<?php foreach ( $lx_about_paras_default as $para ) : ?>
							<p><?php echo esc_html( $para ); ?></p>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>

			<div class="lg:pt-2" data-reveal="image" data-reveal-delay="0.1">
				<div class="overflow-hidden rounded-2xl shadow-lg ring-1 ring-black/5" data-reveal-frame>
					<?php if ( $lx_about_video ) : ?>
						<div class="relative aspect-video">
							<iframe class="absolute inset-0 h-full w-full" src="<?php echo esc_url( $lx_about_video ); ?>" title="<?php echo esc_attr( $lx_about_title ); ?>" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						</div>
					<?php elseif ( $lx_about_image_id ) : ?>
						<?php
						echo wp_get_attachment_image(
							$lx_about_image_id,
							'large',
							false,
							array(
								'class'   => 'aspect-video w-full object-cover',
								'loading' => 'lazy',
								'alt'     => $lx_about_title,
							)
						);
						?>
					<?php elseif ( $lx_about_image ) : ?>
						<img src="<?php echo esc_url( $lx_about_image ); ?>" alt="<?php echo esc_attr( $lx_about_title ); ?>" class="aspect-video w-full object-cover" loading="lazy">
					<?php else : ?>
						<div class="flex aspect-video w-full items-center justify-center bg-gradient-to-br from-neutral-100 to-brand/10 text-brand/40">
							<svg class="h-16 w-16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m10 8 6 4-6 4V8z"/></svg>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<!-- ============ 3) TẦM NHÌN · SỨ MỆNH · GIÁ TRỊ CỐT LÕI ============ -->
	<section class="bg-neutral-50 py-16 md:py-24" data-section="gt-pillars">
		<div class="container-lx space-y-14 md:space-y-24">
			<?php
			foreach ( $lx_pillars as $index => $pillar ) :
				if ( empty( $pillar['title'] ) && empty( $pillar['text'] ) ) {
					continue;
				}
				$is_reversed = ( 1 === $index % 2 );
				$pillar_img_id = ! empty( $pillar['image_id'] ) ? (int) $pillar['image_id'] : 0;
				$card_from     = $is_reversed ? 'left' : 'right';
				?>
				<div class="relative grid grid-cols-1 items-center gap-6 lg:grid-cols-12 lg:gap-0">
					<!-- Ảnh -->
					<div class="lg:col-span-6 <?php echo $is_reversed ? 'lg:order-2 lg:col-start-7' : 'lg:col-start-1'; ?>" data-reveal="image">
						<div class="overflow-hidden rounded-2xl shadow-xl" data-reveal-frame>
							<?php if ( $pillar_img_id ) : ?>
								<?php
								echo wp_get_attachment_image(
									$pillar_img_id,
									'large',
									false,
									array(
										'class'   => 'aspect-[16/10] w-full object-cover',
										'loading' => 'lazy',
										'alt'     => $pillar['title'],
									)
								);
								?>
							<?php elseif ( ! empty( $pillar['image'] ) ) : ?>
								<img src="<?php echo esc_url( $pillar['image'] ); ?>" alt="<?php echo esc_attr( $pillar['title'] ); ?>" class="aspect-[16/10] w-full object-cover" loading="lazy">
							<?php else : ?>
								<div class="flex aspect-[16/10] w-full items-center justify-center bg-gradient-to-br from-neutral-200 to-neutral-300 text-neutral-400">
									<svg class="h-14 w-14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-5-5L5 21"/></svg>
								</div>
							<?php endif; ?>
						</div>
					</div>

					<!-- Thẻ nội dung nổi (màu chủ đạo) -->
					<div class="relative z-10 -mt-8 mx-4 sm:mx-8 lg:col-span-6 lg:mx-0 lg:mt-0 <?php echo $is_reversed ? 'lg:order-1 lg:col-start-1 lg:-mr-16 lg:pr-8' : 'lg:col-start-7 lg:-ml-16 lg:pl-8'; ?>">
						<div class="rounded-2xl bg-brand p-7 text-white shadow-2xl md:p-10" data-reveal="<?php echo esc_attr( $card_from ); ?>" data-reveal-delay="0.12">
							<div class="flex items-center gap-3">
								<span class="h-8 w-1.5 rounded-full bg-white/80"></span>
								<h3 class="text-2xl font-bold uppercase tracking-wide md:text-3xl"><?php echo esc_html( $pillar['title'] ); ?></h3>
							</div>
							<p class="mt-4 text-base leading-relaxed text-white/90"><?php echo esc_html( $pillar['text'] ); ?></p>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</section>

	<!-- ============ 4) TẠI SAO NÊN CHỌN CHÚNG TÔI ============ -->
	<section class="bg-white py-16 md:py-24" data-section="gt-why">
		<div class="container-lx">
			<div class="grid grid-cols-1 gap-8 lg:grid-cols-3 lg:gap-10" data-reveal-stagger>
				<!-- Tiêu đề (chiếm 1 ô đầu trên desktop) -->
				<div class="lg:pr-6">
					<h2 class="text-3xl font-bold uppercase leading-tight text-neutral-900 md:text-4xl">
						<?php echo esc_html( $lx_why_title ); ?>
					</h2>
					<div class="mt-5 h-1 w-16 rounded-full bg-brand" data-reveal-line></div>
				</div>

				<!-- 6 lý do: lấp đầy phần còn lại của lưới -->
				<?php foreach ( $lx_why_items as $item ) : ?>
					<div class="group rounded-2xl border border-neutral-200 bg-white p-6 transition duration-300 hover:-translate-y-1 hover:border-brand/40 hover:shadow-xl md:p-8">
						<span class="inline-flex h-14 w-14 items-center justify-center rounded-xl bg-brand/10 text-brand transition duration-300 group-hover:bg-brand group-hover:text-white">
							<?php nongnghiepnhietdoi_gt_icon( $item['icon'] ); ?>
						</span>
						<h3 class="mt-5 text-lg font-bold text-neutral-900"><?php echo esc_html( $item['title'] ); ?></h3>
						<p class="mt-3 text-base leading-relaxed text-neutral-600"><?php echo esc_html( $item['text'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
