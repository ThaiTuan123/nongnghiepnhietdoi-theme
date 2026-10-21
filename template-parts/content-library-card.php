<?php
/**
 * Card tài liệu / tin tức trên trang Thư viện.
 *
 * @package NongNghiepNhietDoi
 */

$library_terms = isset( $args['terms'] ) && is_array( $args['terms'] ) ? $args['terms'] : array();
$cats          = get_the_category();
$cat           = null;

foreach ( $cats as $candidate ) {
	foreach ( $library_terms as $library_term ) {
		if ( (int) $candidate->term_id === (int) $library_term->term_id ) {
			$cat = $candidate;
			break 2;
		}
	}
}
if ( ! $cat && ! empty( $cats ) ) {
	$cat = $cats[0];
}
?>
<article <?php post_class( 'group grid overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-100 transition duration-300 hover:-translate-y-0.5 hover:shadow-lg sm:grid-cols-[220px_minmax(0,1fr)]' ); ?>>
	<a href="<?php the_permalink(); ?>" class="block overflow-hidden bg-neutral-100">
		<div class="aspect-[16/10] w-full sm:aspect-auto sm:h-full sm:min-h-[168px]">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php
				the_post_thumbnail(
					'nongnghiepnhietdoi-card',
					array(
						'class'   => 'h-full w-full object-cover transition duration-700 group-hover:scale-105',
						'loading' => 'lazy',
					)
				);
				?>
			<?php else : ?>
				<div class="h-full min-h-[168px] w-full bg-gradient-to-br from-brand-700 to-brand"></div>
			<?php endif; ?>
		</div>
	</a>
	<div class="flex flex-col justify-center p-5 md:p-6">
		<?php if ( $cat ) : ?>
			<a href="<?php echo esc_url( nongnghiepnhietdoi_library_url( $cat->slug ) ); ?>" class="text-xs font-semibold text-brand">
				<?php echo esc_html( $cat->name ); ?>
			</a>
		<?php endif; ?>
		<h2 class="mt-1.5 line-clamp-2 font-sans text-lg font-bold leading-snug text-ink transition group-hover:text-brand">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>
		<p class="mt-2 line-clamp-2 text-sm leading-relaxed text-slate-600"><?php echo esc_html( get_the_excerpt() ); ?></p>
		<p class="mt-3 text-xs text-slate-400"><?php echo esc_html( get_the_date() ); ?></p>
	</div>
</article>
