<?php
/**
 * Generic page: render ACF flexible sections, fallback to the editor content.
 *
 * @package NongNghiepNhietDoi
 */

get_header();
?>

<main id="main" class="site-main">
	<?php
	while ( have_posts() ) :
		the_post();

		if ( function_exists( 'have_rows' ) && have_rows( 'page_sections' ) ) {
			nongnghiepnhietdoi_render_sections();
		} else {
			?>
			<section class="pt-28 md:pt-36" data-reveal>
				<div class="container-lx">
					<h1 class="text-3xl font-bold text-neutral-900 md:text-4xl lg:text-5xl"><?php the_title(); ?></h1>
				</div>
			</section>
			<section class="py-12 md:py-16">
				<div class="container-lx prose prose-neutral max-w-3xl">
					<?php the_content(); ?>
				</div>
			</section>
			<?php
		}
	endwhile;
	?>
</main>

<?php
get_footer();
