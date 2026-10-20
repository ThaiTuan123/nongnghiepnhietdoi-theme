<?php
/**
 * Reusable post/project card.
 *
 * @package NongNghiepNhietDoi
 */
?>
<article <?php post_class( 'group overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-neutral-100 transition hover:shadow-xl' ); ?> data-reveal>
	<a href="<?php the_permalink(); ?>" class="block">
		<div class="aspect-[4/3] overflow-hidden bg-neutral-100">
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
			<?php endif; ?>
		</div>
		<div class="p-3 sm:p-5 md:p-6">
			<div class="mb-1.5 text-[10px] uppercase tracking-widest text-brand sm:mb-2 sm:text-xs"><?php echo esc_html( get_the_date() ); ?></div>
			<h3 class="line-clamp-2 text-sm font-bold leading-snug text-neutral-900 transition group-hover:text-brand sm:text-lg"><?php the_title(); ?></h3>
			<p class="mt-1.5 line-clamp-2 text-xs leading-relaxed text-neutral-500 sm:mt-2 sm:line-clamp-3 sm:text-sm"><?php echo esc_html( get_the_excerpt() ); ?></p>
		</div>
	</a>
</article>
