<?php
/**
 * Archive (blog / du_an / taxonomy).
 *
 * @package NongNghiepNhietDoi
 */

get_header();
?>

<main id="main" class="site-main">
	<section class="bg-neutral-50 pt-28 pb-10 md:pt-36 md:pb-14" data-reveal>
		<div class="container-lx">
			<h1 class="text-3xl font-bold text-neutral-900 md:text-4xl lg:text-5xl">
				<?php
				if ( is_post_type_archive( 'du_an' ) ) {
					esc_html_e( 'Dự án', 'nongnghiepnhietdoi' );
				} else {
					the_archive_title();
				}
				?>
			</h1>
			<?php the_archive_description( '<p class="mt-4 max-w-2xl text-neutral-600">', '</p>' ); ?>
		</div>
	</section>

	<section class="py-12 md:py-16">
		<div class="container-lx">
			<?php if ( have_posts() ) : ?>
				<div class="grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-3" data-reveal-stagger>
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'card' );
					endwhile;
					?>
				</div>
				<div class="mt-12"><?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?></div>
			<?php else : ?>
				<p class="text-center text-lg text-neutral-500"><?php esc_html_e( 'Chưa có nội dung.', 'nongnghiepnhietdoi' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php
get_footer();
