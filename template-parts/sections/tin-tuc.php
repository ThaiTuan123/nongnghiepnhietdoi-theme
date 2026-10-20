<?php
/**
 * Section: Tin tức.
 *
 * @package NongNghiepNhietDoi
 */

$label = get_sub_field( 'label' );
$title = get_sub_field( 'title' );
$count = (int) ( get_sub_field( 'count' ) ?: 3 );
$link  = get_sub_field( 'link' );

$news = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => $count,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);
?>
<section class="bg-neutral-50 py-20 md:py-28" data-section="tin-tuc">
	<div class="container-lx">
		<div class="flex flex-col items-start justify-between gap-6 md:flex-row md:items-end">
			<div class="max-w-2xl">
				<?php if ( $label ) : ?>
					<p class="mb-3 text-sm font-medium uppercase tracking-[0.25em] text-brand" data-reveal><?php echo esc_html( $label ); ?></p>
				<?php endif; ?>
				<?php if ( $title ) : ?>
					<h2 class="text-3xl font-bold text-neutral-900 md:text-4xl lg:text-5xl" data-reveal><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
			</div>
			<?php if ( $link && ! empty( $link['url'] ) ) : ?>
				<a href="<?php echo esc_url( $link['url'] ); ?>" class="btn btn-outline shrink-0" data-reveal><?php echo esc_html( $link['title'] ?: __( 'Xem tất cả', 'nongnghiepnhietdoi' ) ); ?></a>
			<?php endif; ?>
		</div>

		<?php if ( $news->have_posts() ) : ?>
			<div class="mt-12 grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-3" data-reveal-stagger>
				<?php
				while ( $news->have_posts() ) :
					$news->the_post();
					get_template_part( 'template-parts/content', 'card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		<?php else : ?>
			<p class="mt-12 text-neutral-500"><?php esc_html_e( 'Chưa có bài viết.', 'nongnghiepnhietdoi' ); ?></p>
		<?php endif; ?>
	</div>
</section>
