<?php
/**
 * Card bài viết cho trang Tin tức (nhãn chuyên mục + tiêu đề + ngày).
 *
 * @package NongNghiepNhietDoi
 */

$lx_cats = get_the_category();
$lx_cat  = ! empty( $lx_cats ) ? $lx_cats[0] : null;
?>
<article <?php post_class( 'group flex h-full flex-col overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-neutral-100 transition duration-300 hover:-translate-y-1 hover:shadow-xl' ); ?> data-reveal>
	<a href="<?php the_permalink(); ?>" class="block overflow-hidden bg-neutral-100">
		<div class="aspect-[16/10] w-full">
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
				<div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-neutral-100 to-brand/10 text-brand/30">
					<svg class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="m3 15 5-5 4 4 3-3 6 6"/></svg>
				</div>
			<?php endif; ?>
		</div>
	</a>

	<div class="flex flex-1 flex-col p-3 sm:p-4 md:p-5">
		<?php if ( $lx_cat ) : ?>
			<a href="<?php echo esc_url( get_category_link( $lx_cat->term_id ) ); ?>" class="mb-1.5 inline-block text-[10px] font-semibold uppercase tracking-[0.14em] text-brand sm:mb-2 sm:text-[11px]">
				<?php echo esc_html( $lx_cat->name ); ?>
			</a>
		<?php endif; ?>

		<h3 class="line-clamp-2 text-sm font-bold leading-snug text-neutral-900 transition group-hover:text-brand sm:text-[15px] md:text-base">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>

		<div class="mt-auto pt-2 text-[11px] text-neutral-400 sm:pt-3 sm:text-xs">
			<?php echo esc_html( get_the_date() ); ?>
		</div>
	</div>
</article>
