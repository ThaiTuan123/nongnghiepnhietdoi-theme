<?php
/**
 * Single post.
 *
 * Hero → nội dung + sidebar (tìm kiếm, tin mới, tài liệu, CTA hợp tác)
 * → chia sẻ → nội dung liên quan.
 *
 * @package NongNghiepNhietDoi
 */

get_header();
?>

<main id="main" class="site-main">
	<?php
	while ( have_posts() ) :
		the_post();

		$cats = get_the_category();
		?>
		<article <?php post_class( 'lx-single-post' ); ?>>
			<header class="relative flex min-h-[50vh] items-end overflow-hidden pt-24 md:min-h-[60vh]" data-dark-hero>
				<?php if ( has_post_thumbnail() ) : ?>
					<?php // Lớp ảnh nền phủ rộng hơn header để parallax không lộ khoảng trống. ?>
					<div class="absolute inset-x-0 -inset-y-[34%]" data-parallax="0.2">
						<?php the_post_thumbnail( 'nongnghiepnhietdoi-wide', array( 'class' => 'h-full w-full object-cover' ) ); ?>
					</div>
					<div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/75 via-black/35 to-black/20"></div>
				<?php else : ?>
					<div class="absolute inset-0 bg-gradient-to-br from-brand-900 via-brand to-brand-700"></div>
				<?php endif; ?>
				<div class="container-lx relative z-10 pb-12 text-white" data-reveal>
					<?php if ( $cats ) : ?>
						<div class="mb-3 flex flex-wrap gap-2">
							<?php foreach ( $cats as $cat ) : ?>
								<a
									href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"
									class="inline-flex rounded-full bg-white/15 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-white/95 backdrop-blur transition hover:bg-brand"
								>
									<?php echo esc_html( $cat->name ); ?>
								</a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<div class="mb-3 text-sm uppercase tracking-widest text-brand-50/90"><?php echo esc_html( get_the_date() ); ?></div>
					<h1 class="max-w-4xl text-3xl font-bold leading-tight md:text-4xl lg:text-5xl"><?php the_title(); ?></h1>
				</div>
			</header>

			<div class="bg-bone">
				<div class="container-lx py-12 md:py-16">
					<div class="grid items-start gap-10 lg:grid-cols-[minmax(0,1fr)_320px] lg:gap-12 xl:grid-cols-[minmax(0,1fr)_340px]">
						<div class="min-w-0">
							<div class="lx-single-body prose prose-neutral max-w-none prose-headings:font-bold prose-a:text-brand" data-reveal>
								<?php the_content(); ?>
							</div>

							<div class="mt-10 border-t border-slate-200/80 pt-8">
								<?php get_template_part( 'template-parts/single/share' ); ?>
							</div>
						</div>

						<div class="lg:pt-1">
							<div class="lg:sticky lg:top-28">
								<?php get_template_part( 'template-parts/single/sidebar' ); ?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php get_template_part( 'template-parts/single/related' ); ?>
		</article>
		<?php
	endwhile;
	?>
</main>

<?php
get_footer();
