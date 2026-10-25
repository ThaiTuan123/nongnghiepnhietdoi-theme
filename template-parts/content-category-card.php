<?php
/**
 * Thẻ bài trên archive chuyên mục — ảnh phủ, cùng ngôn ngữ với Dự án tiêu biểu.
 *
 * @package NongNghiepNhietDoi
 *
 * @param array $args {
 *     @type bool $lead  Thẻ lớn, trải hai cột.
 *     @type int  $index Thứ tự trong lưới, dùng ảnh dự phòng.
 * }
 */

$is_lead = ! empty( $args['lead'] );
$index   = isset( $args['index'] ) ? (int) $args['index'] : 0;

$image = get_the_post_thumbnail_url( get_the_ID(), $is_lead ? 'nongnghiepnhietdoi-wide' : 'medium_large' );
if ( ! $image ) {
	$image = NONGNGHIEPNHIETDOI_URI . ( 1 === $index % 3 ? '/assets/images/about-field.jpg' : '/assets/images/hero-field.jpg' );
}

$excerpt = wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), $is_lead ? 32 : 18, '…' );
$classes = 'vc-media-card vc-media-card--featured vc-media-card--link group';
if ( $is_lead ) {
	$classes .= ' cat-card--lead';
}
?>
<a href="<?php the_permalink(); ?>" class="<?php echo esc_attr( $classes ); ?>">
	<img
		class="vc-media-card__bg"
		src="<?php echo esc_url( $image ); ?>"
		alt=""
		loading="<?php echo $is_lead ? 'eager' : 'lazy'; ?>"
		decoding="async"
	>
	<span class="vc-media-card__scrim" aria-hidden="true"></span>
	<div class="vc-media-card__body">
		<p class="vc-media-card__index"><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></p>
		<h2 class="vc-media-card__title"><?php the_title(); ?></h2>
		<?php if ( $excerpt ) : ?>
			<p class="vc-media-card__text"><?php echo esc_html( $excerpt ); ?></p>
		<?php endif; ?>
	</div>
</a>
