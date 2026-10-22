<?php
/**
 * Search result card — horizontal layout for scanning.
 *
 * @package NongNghiepNhietDoi
 */

$cats = get_the_category();
$cat  = ! empty( $cats ) ? $cats[0] : null;
?>
<article <?php post_class( 'search-card group relative grid overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-100 sm:grid-cols-[200px_minmax(0,1fr)]' ); ?>>
	<div class="aspect-[16/10] overflow-hidden bg-neutral-100 sm:aspect-auto sm:h-full sm:min-h-[148px]" aria-hidden="true">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php
			the_post_thumbnail(
				'nongnghiepnhietdoi-card',
				array(
					'class'   => 'search-card__img h-full w-full object-cover',
					'loading' => 'lazy',
					'alt'     => '',
				)
			);
			?>
		<?php else : ?>
			<div class="h-full min-h-[148px] w-full bg-gradient-to-br from-brand-700 to-brand"></div>
		<?php endif; ?>
	</div>

	<div class="flex flex-col justify-center p-5 md:p-6">
		<div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs">
			<?php if ( $cat ) : ?>
				<span class="font-semibold text-brand"><?php echo esc_html( $cat->name ); ?></span>
				<span class="text-slate-300" aria-hidden="true">·</span>
			<?php endif; ?>
			<time class="text-slate-400" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
				<?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?>
			</time>
		</div>

		<h2 class="mt-1.5 font-sans text-lg font-bold leading-snug text-ink">
			<a href="<?php the_permalink(); ?>" class="search-card__link"><?php the_title(); ?></a>
		</h2>

		<p class="mt-2 line-clamp-2 text-sm leading-relaxed text-slate-600">
			<?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?>
		</p>

		<span class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-brand opacity-0 transition group-hover:opacity-100 group-focus-within:opacity-100 max-sm:opacity-100" aria-hidden="true">
			<?php esc_html_e( 'Đọc bài', 'nongnghiepnhietdoi' ); ?>
			<span aria-hidden="true">→</span>
		</span>
	</div>
</article>
