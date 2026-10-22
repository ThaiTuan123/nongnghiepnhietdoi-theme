<?php
/**
 * Nội dung liên quan (cùng chuyên mục, fallback tin mới).
 *
 * @package NongNghiepNhietDoi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$current_id = get_the_ID();
$cats       = get_the_category( $current_id );
$cat_ids    = $cats ? wp_list_pluck( $cats, 'term_id' ) : array();

$args = array(
	'post_type'           => 'post',
	'posts_per_page'      => 3,
	'post__not_in'        => array( $current_id ),
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
);

if ( $cat_ids ) {
	$args['category__in'] = $cat_ids;
}

$related = new WP_Query( $args );

if ( ! $related->have_posts() ) {
	return;
}
?>
<section class="lx-related" data-section="noi-dung-lien-quan">
	<div class="container-lx">
		<div class="lx-related__head" data-reveal>
			<span class="lx-related__accent" aria-hidden="true"></span>
			<div>
				<p class="lx-related__eyebrow"><?php esc_html_e( 'Khám phá thêm', 'nongnghiepnhietdoi' ); ?></p>
				<h2 class="lx-related__title"><?php esc_html_e( 'Nội dung liên quan', 'nongnghiepnhietdoi' ); ?></h2>
			</div>
			<span class="lx-related__line" data-reveal-line aria-hidden="true"></span>
		</div>

		<div class="lx-related__grid" data-reveal-stagger>
			<?php
			while ( $related->have_posts() ) :
				$related->the_post();
				get_template_part( 'template-parts/content', 'news-card' );
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
