<?php
/**
 * Section: Hero.
 *
 * Banner đầu trang với nhiều slide (ảnh + video). Slide video tự phát trước,
 * hết video sẽ chuyển sang các ảnh (tự chuyển sau 5s) và lặp lại liên tục.
 * Người dùng có thể bấm thumbnail phía dưới để chuyển slide.
 *
 * @package NongNghiepNhietDoi
 */

$subtitle = get_sub_field( 'subtitle' );
$title    = get_sub_field( 'title' );
$desc     = get_sub_field( 'description' );
$slides   = get_sub_field( 'slides' );
$bg       = get_sub_field( 'background_image' );
$buttons  = get_sub_field( 'buttons' );

// Chuẩn hoá danh sách slide cho Vue island.
$slide_data = array();
if ( $slides ) {
	foreach ( $slides as $slide ) {
		$type = $slide['media_type'] ?? 'image';

		if ( 'video' === $type ) {
			$video  = $slide['video'] ?? null;
			$poster = $slide['poster'] ?? null;
			if ( $video && ! empty( $video['url'] ) ) {
				$poster_url   = ( $poster && ! empty( $poster['url'] ) ) ? $poster['url'] : '';
				$poster_thumb = $poster['sizes']['medium'] ?? $poster_url;
				$slide_data[] = array(
					'type'   => 'video',
					'src'    => $video['url'],
					'poster' => $poster_url,
					'thumb'  => $poster_thumb,
					'alt'    => $poster['alt'] ?? ( $video['title'] ?? '' ),
				);
			}
		} else {
			$image = $slide['image'] ?? null;
			if ( $image && ! empty( $image['url'] ) ) {
				$slide_data[] = array(
					'type'  => 'image',
					'src'   => $image['url'],
					'thumb' => $image['sizes']['medium'] ?? $image['url'],
					'alt'   => $image['alt'] ?? '',
				);
			}
		}
	}
}

// Fallback: nếu chưa có slide nào nhưng có ảnh nền dự phòng.
if ( empty( $slide_data ) && $bg && ! empty( $bg['url'] ) ) {
	$slide_data[] = array(
		'type'  => 'image',
		'src'   => $bg['url'],
		'thumb' => $bg['sizes']['medium'] ?? $bg['url'],
		'alt'   => $bg['alt'] ?? '',
	);
}

$first_slide     = $slide_data[0] ?? null;
$first_is_video  = $first_slide && ( $first_slide['type'] ?? '' ) === 'video';
$slider_props    = wp_json_encode(
	array(
		'slides'   => $slide_data,
		'interval' => 5000,
	)
);
?>
<section class="relative flex min-h-[70svh] items-center justify-center overflow-hidden md:min-h-screen" data-section="hero" data-dark-hero>
	<?php if ( ! empty( $slide_data ) ) : ?>
		<div class="absolute inset-0 z-0" data-vue="HeroSlider" data-props="<?php echo esc_attr( $slider_props ); ?>">
			<?php // Nội dung dự phòng trước khi Vue mount (tránh chớp trắng). ?>
			<?php if ( $first_slide ) : ?>
				<img src="<?php echo esc_url( $first_slide['src'] ); ?>" alt="<?php echo esc_attr( $first_slide['alt'] ); ?>" class="h-full w-full object-cover" fetchpriority="high">
			<?php endif; ?>
			<div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-black/45 via-black/25 to-black/60"></div>
		</div>
	<?php else : ?>
		<div class="absolute inset-0 z-0 bg-neutral-900"></div>
	<?php endif; ?>

	<div class="container-lx relative z-10 pb-28 pt-24 text-center text-white md:py-32">
		<?php // Ẩn chữ khi slide video để không che media; HeroSlider sẽ bật lại khi sang ảnh. ?>
		<div class="mx-auto max-w-3xl<?php echo $first_is_video ? ' hidden' : ''; ?>" data-hero-copy>
			<?php if ( $subtitle ) : ?>
				<p class="mb-2 text-xs font-medium uppercase tracking-[0.3em] text-brand-50/90 sm:mb-4 sm:text-sm" data-reveal><?php echo esc_html( $subtitle ); ?></p>
			<?php endif; ?>
			<?php if ( $title ) : ?>
				<h1 class="text-3xl font-bold leading-tight sm:text-5xl md:text-6xl lg:text-7xl" data-reveal><?php echo esc_html( $title ); ?></h1>
			<?php endif; ?>
			<?php if ( $desc ) : ?>
				<p class="mx-auto mt-3 max-w-xl text-sm leading-relaxed text-neutral-200 sm:mt-6 sm:text-base md:text-lg" data-reveal><?php echo esc_html( $desc ); ?></p>
			<?php endif; ?>
			<?php if ( $buttons ) : ?>
				<div class="mt-5 flex flex-row flex-wrap items-center justify-center gap-3 sm:mt-8 sm:gap-4" data-reveal>
					<?php
					foreach ( $buttons as $btn ) :
						$link  = $btn['url'] ?? null;
						$label = $btn['label'] ?? ( $link['title'] ?? '' );
						if ( ! $link || empty( $link['url'] ) ) {
							continue;
						}
						$style = ( 'outline' === ( $btn['style'] ?? '' ) ) ? 'btn-outline' : 'btn-primary';
						?>
						<a href="<?php echo esc_url( $link['url'] ); ?>" target="<?php echo esc_attr( $link['target'] ?: '_self' ); ?>" class="btn px-5 py-2.5 text-xs sm:px-7 sm:py-3 sm:text-sm <?php echo esc_attr( $style ); ?>"><?php echo esc_html( $label ); ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<button
		type="button"
		class="absolute bottom-8 left-1/2 z-10 hidden -translate-x-1/2 text-white/70 transition-colors duration-300 hover:text-white focus-visible:text-white md:block"
		data-scroll-indicator
		aria-label="<?php esc_attr_e( 'Cuộn xuống phần tiếp theo', 'nongnghiepnhietdoi' ); ?>"
	>
		<span class="scroll-indicator" aria-hidden="true"></span>
	</button>
</section>
