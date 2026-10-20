<?php
/**
 * Template trang Dịch vụ (/dich-vu/).
 *
 * Hiển thị 3 lĩnh vực: Phong thủy · Thiết kế · Dự án theo bố cục xen kẽ
 * (ảnh / nội dung), mỗi phần có nút "Xem thêm" dẫn sang trang tương ứng.
 *
 * Ảnh mỗi phần: mặc định tự lấy ảnh đại diện của trang đích; có thể ghi đè
 * bằng cách dán URL vào 'image' trong phần cấu hình bên dưới.
 *
 * @package NongNghiepNhietDoi
 */

get_header();

/**
 * Lấy URL ảnh đại diện của một trang theo slug (rỗng nếu không có).
 *
 * @param string $slug Slug trang.
 * @return string
 */
$lx_dv_thumb = static function ( $slug ) {
	$page = get_page_by_path( $slug );
	if ( $page && has_post_thumbnail( $page->ID ) ) {
		return (string) get_the_post_thumbnail_url( $page->ID, 'nongnghiepnhietdoi-wide' );
	}
	return '';
};

/**
 * Lấy URL ảnh đại diện của dự án mới nhất (dùng cho phần "Dự án").
 *
 * @return string
 */
$lx_dv_project_thumb = static function () {
	$q = new WP_Query(
		array(
			'post_type'      => 'du_an',
			'posts_per_page' => 1,
			'meta_key'       => '_thumbnail_id',
			'fields'         => 'ids',
			'no_found_rows'  => true,
		)
	);
	if ( ! empty( $q->posts ) ) {
		return (string) get_the_post_thumbnail_url( $q->posts[0], 'nongnghiepnhietdoi-wide' );
	}
	return '';
};

$lx_du_an_link = get_post_type_archive_link( 'du_an' );
if ( ! $lx_du_an_link ) {
	$lx_du_an_link = home_url( '/bat-dong-san/' );
}

/*
============================================================
 * CẤU HÌNH NỘI DUNG — SỬA TRỰC TIẾP TẠI ĐÂY
 * ============================================================ */

$lx_services = array(
	array(
		'label' => 'Phong thủy',
		'title' => 'Phong thủy huyền học',
		'desc'  => 'Tư vấn phong thủy chuyên sâu cho không gian sống và làm việc — cân bằng năng lượng, chiêu tài đón lộc, mang lại sự hài hòa và thịnh vượng cho gia chủ.',
		'link'  => home_url( '/phong-thuy/' ),
		'image' => '', // Ghi đè URL ảnh tại đây nếu muốn.
	),
	array(
		'label' => 'Thiết kế',
		'title' => 'Thiết kế kiến tạo không gian',
		'desc'  => 'Kiến tạo không gian nội thất tinh tế, được cá nhân hóa theo phong cách sống và dấu ấn riêng của từng khách hàng, kết hợp thẩm mỹ hiện đại với giá trị bền vững.',
		'link'  => home_url( '/thiet-ke/' ),
		'image' => '',
	),
	array(
		'label' => 'Bất động sản',
		'title' => 'Dự án tiêu biểu',
		'desc'  => 'Những dự án bất động sản cao cấp do Nông nghiệp nhiệt đới phát triển và đồng hành — biểu tượng cho phong cách sống thượng lưu và trải nghiệm không gian đẳng cấp.',
		'link'  => $lx_du_an_link,
		'image' => '',
	),
);

// Bổ sung ảnh mặc định (từ trang đích) khi chưa cấu hình ảnh riêng.
$lx_services[0]['image'] = $lx_services[0]['image'] ?: $lx_dv_thumb( 'phong-thuy' );
$lx_services[1]['image'] = $lx_services[1]['image'] ?: $lx_dv_thumb( 'thiet-ke' );
$lx_services[2]['image'] = $lx_services[2]['image'] ?: $lx_dv_project_thumb();

while ( have_posts() ) :
	the_post();
	$lx_page_title = get_the_title();
	$lx_page_desc  = has_excerpt() ? get_the_excerpt() : 'Nông nghiệp nhiệt đới mang đến hệ sinh thái dịch vụ toàn diện: phong thủy, thiết kế và phát triển dự án — kiến tạo không gian sống trường tồn.';
	?>

<main id="main" class="site-main">

	<!-- ============ Hero banner ============ -->
	<section class="relative flex min-h-[42vh] items-end overflow-hidden pt-24 md:min-h-[52vh]" data-dark-hero>
		<div class="absolute inset-0">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'nongnghiepnhietdoi-wide', array( 'class' => 'h-full w-full object-cover' ) ); ?>
			<?php else : ?>
				<div class="h-full w-full bg-gradient-to-br from-brand-900 via-brand-700 to-brand-500"></div>
			<?php endif; ?>
			<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/45 to-black/45"></div>
		</div>
		<div class="container-lx relative z-10 pb-10 text-white md:pb-14">
			<p class="mb-3 text-sm font-medium uppercase tracking-[0.25em] text-brand-50/90" data-reveal><?php esc_html_e( 'Dịch vụ', 'nongnghiepnhietdoi' ); ?></p>
			<h1 class="text-3xl font-bold leading-tight md:text-4xl lg:text-5xl" data-reveal data-reveal-delay="0.08"><?php echo esc_html( $lx_page_title ); ?></h1>
			<p class="mt-4 max-w-2xl text-base text-white/80 md:text-lg" data-reveal data-reveal-delay="0.16"><?php echo esc_html( $lx_page_desc ); ?></p>
		</div>
	</section>

	<!-- ============ 3 lĩnh vực (xen kẽ ảnh / nội dung) ============ -->
	<?php
	foreach ( $lx_services as $lx_i => $lx_service ) :
		$lx_reverse   = ( 0 !== $lx_i % 2 ); // Phần thứ 2 đảo chiều.
		$lx_alt_bg    = ( 0 !== $lx_i % 2 ) ? ' bg-neutral-50' : '';
		$lx_text_from = $lx_reverse ? 'left' : 'right';
		?>
		<section class="py-16 md:py-24<?php echo esc_attr( $lx_alt_bg ); ?>" data-section="dich-vu-<?php echo esc_attr( $lx_i ); ?>">
			<div class="container-lx">
				<div class="grid items-center gap-8 lg:grid-cols-2 lg:gap-14">
					<!-- Ảnh -->
					<div class="<?php echo $lx_reverse ? 'lg:order-2' : ''; ?>" data-reveal="image">
						<div class="group relative aspect-[4/3] overflow-hidden rounded-3xl shadow-lg ring-1 ring-black/5" data-reveal-frame>
							<?php if ( $lx_service['image'] ) : ?>
								<img
									src="<?php echo esc_url( $lx_service['image'] ); ?>"
									alt="<?php echo esc_attr( $lx_service['title'] ); ?>"
									class="h-full w-full object-cover transition duration-700 group-hover:scale-105"
									loading="lazy"
								>
							<?php else : ?>
								<div class="h-full w-full bg-gradient-to-br from-brand-800 via-brand-600 to-brand-400"></div>
							<?php endif; ?>
							<div class="absolute left-5 top-5 rounded-full bg-white/90 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.14em] text-brand shadow-sm">
								<?php printf( '0%d', (int) $lx_i + 1 ); ?>
							</div>
						</div>
					</div>

					<!-- Nội dung -->
					<div class="<?php echo $lx_reverse ? 'lg:order-1' : ''; ?>">
						<p class="mb-3 text-sm font-medium uppercase tracking-[0.25em] text-brand" data-reveal="<?php echo esc_attr( $lx_text_from ); ?>"><?php echo esc_html( $lx_service['label'] ); ?></p>
						<h2 class="text-3xl font-bold leading-tight text-neutral-900 md:text-4xl" data-reveal="<?php echo esc_attr( $lx_text_from ); ?>" data-reveal-delay="0.08"><?php echo esc_html( $lx_service['title'] ); ?></h2>
						<p class="mt-5 max-w-xl text-base leading-relaxed text-neutral-600" data-reveal="<?php echo esc_attr( $lx_text_from ); ?>" data-reveal-delay="0.16"><?php echo esc_html( $lx_service['desc'] ); ?></p>
						<a href="<?php echo esc_url( $lx_service['link'] ); ?>" class="btn btn-primary mt-8 gap-2" data-reveal="<?php echo esc_attr( $lx_text_from ); ?>" data-reveal-delay="0.24">
							<?php esc_html_e( 'Xem thêm', 'nongnghiepnhietdoi' ); ?>
							<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
						</a>
					</div>
				</div>
			</div>
		</section>
	<?php endforeach; ?>

</main>

	<?php
endwhile;

get_footer();
