<?php
/**
 * Fallback template.
 *
 * @package NongNghiepNhietDoi
 */

get_header();
?>

<main id="main" class="site-main">
	<div class="container-lx py-16 md:py-24">
		<?php if ( have_posts() ) : ?>
			<div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', 'card' );
				endwhile;
				?>
			</div>
			<div class="mt-12"><?php the_posts_pagination(); ?></div>
		<?php else : ?>
			<p class="text-center text-lg text-neutral-500"><?php esc_html_e( 'Chưa có nội dung.', 'nongnghiepnhietdoi' ); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
