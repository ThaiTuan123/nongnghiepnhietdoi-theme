<?php
/**
 * Front page: render ACF flexible sections.
 *
 * @package NongNghiepNhietDoi
 */

get_header();
?>

<main id="main" class="site-main">
	<?php
	if ( function_exists( 'have_rows' ) && have_rows( 'page_sections' ) ) {
		nongnghiepnhietdoi_render_sections();
	} else {
		get_template_part( 'template-parts/sections/placeholder' );
	}
	?>
</main>

<?php
get_footer();
