<?php
/**
 * Single post / du_an.
 *
 * @package NongNghiepNhietDoi
 */

get_header();
?>

<main id="main" class="site-main">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class(); ?>>
			<header class="relative flex min-h-[50vh] items-end overflow-hidden pt-24 md:min-h-[60vh]" data-dark-hero>
				<?php if ( has_post_thumbnail() ) : ?>
					<?php // Lớp ảnh nền phủ rộng hơn header (âm 34% trên/dưới) để hiệu ứng parallax không lộ khoảng trống (vệt xám) khi ảnh bị đẩy lên/xuống. ?>
					<div class="absolute inset-x-0 -inset-y-[34%]" data-parallax="0.2">
						<?php the_post_thumbnail( 'nongnghiepnhietdoi-wide', array( 'class' => 'h-full w-full object-cover' ) ); ?>
					</div>
					<?php // Lớp phủ tối tách khỏi parallax để luôn phủ kín hero, giúp tiêu đề dễ đọc. ?>
					<div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/75 via-black/35 to-black/20"></div>
				<?php endif; ?>
				<div class="container-lx relative z-10 pb-12 text-white" data-reveal>
					<div class="mb-3 text-sm uppercase tracking-widest text-brand-50/90"><?php echo esc_html( get_the_date() ); ?></div>
					<h1 class="max-w-4xl text-3xl font-bold leading-tight md:text-4xl lg:text-5xl"><?php the_title(); ?></h1>
				</div>
			</header>

			<div class="container-lx py-12 md:py-16">
				<div class="prose prose-neutral mx-auto max-w-3xl prose-headings:font-bold prose-a:text-brand">
					<?php the_content(); ?>
				</div>
			</div>
		</article>
		<?php
	endwhile;

	// Form đăng ký tư vấn — giống trang Phong thủy / Thiết kế / Tin tức.
	get_template_part( 'template-parts/consult', 'cta' );
	?>
</main>

<?php
get_footer();
