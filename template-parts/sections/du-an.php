<?php
/**
 * Section: Dự án tiêu biểu.
 *
 * @package NongNghiepNhietDoi
 */

$label = get_sub_field( 'label' );
$title = get_sub_field( 'title' );
$desc  = get_sub_field( 'description' );
$count = (int) ( get_sub_field( 'count' ) ?: 6 );
$link  = get_sub_field( 'link' );

// Trang chủ tối đa 6 dự án.
$count = min( max( 1, $count ), 6 );

$query_args = array(
	'post_type'           => 'du_an',
	'posts_per_page'      => $count,
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
);

// Chỉ hiển thị dự án thuộc loại "Tiêu biểu" (nếu term này tồn tại).
$featured_term = get_term_by( 'slug', 'tieu-bieu', 'loai_du_an' );
if ( ! $featured_term ) {
	$featured_term = get_term_by( 'name', 'Tiêu biểu', 'loai_du_an' );
}
if ( $featured_term && ! is_wp_error( $featured_term ) ) {
	$query_args['tax_query'] = array(
		array(
			'taxonomy' => 'loai_du_an',
			'field'    => 'term_id',
			'terms'    => $featured_term->term_id,
		),
	);
}

$projects = new WP_Query( $query_args );
?>
<section class="py-20 md:py-28" data-section="du-an">
	<div class="container-lx">
		<div class="flex flex-col items-start justify-between gap-6 md:flex-row md:items-end">
			<div class="max-w-2xl">
				<?php if ( $label ) : ?>
					<p class="mb-3 text-sm font-medium uppercase tracking-[0.25em] text-brand" data-reveal><?php echo esc_html( $label ); ?></p>
				<?php endif; ?>
				<?php if ( $title ) : ?>
					<h2 class="text-3xl font-bold text-neutral-900 md:text-4xl lg:text-5xl" data-reveal><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( $desc ) : ?>
					<p class="mt-4 text-neutral-600" data-reveal><?php echo esc_html( $desc ); ?></p>
				<?php endif; ?>
			</div>
			<?php if ( $link && ! empty( $link['url'] ) ) : ?>
				<a href="<?php echo esc_url( $link['url'] ); ?>" class="btn btn-outline shrink-0" data-reveal><?php echo esc_html( $link['title'] ?: __( 'Xem tất cả', 'nongnghiepnhietdoi' ) ); ?></a>
			<?php endif; ?>
		</div>

		<?php if ( $projects->have_posts() ) : ?>
			<div class="mt-12 grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-3" data-reveal-stagger>
				<?php
				while ( $projects->have_posts() ) :
					$projects->the_post();
					get_template_part( 'template-parts/content-project', 'card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		<?php else : ?>
			<p class="mt-12 text-neutral-500"><?php esc_html_e( 'Chưa có dự án tiêu biểu. Vào menu "Dự án", mở dự án và tích chọn loại "Tiêu biểu" ở mục "Loại dự án" để hiển thị tại đây.', 'nongnghiepnhietdoi' ); ?></p>
		<?php endif; ?>
	</div>
</section>
