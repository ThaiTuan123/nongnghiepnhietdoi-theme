<?php
/**
 * Section: Lĩnh vực / Dịch vụ.
 *
 * @package NongNghiepNhietDoi
 */

$label     = get_sub_field( 'label' );
$title     = get_sub_field( 'title' );
$desc      = get_sub_field( 'description' );
$more_link = get_sub_field( 'more_link' );
$items     = get_sub_field( 'items' );

// Chuẩn hoá dữ liệu cho Vue island.
$cards = array();
if ( $items ) {
	foreach ( $items as $item ) {
		$img  = $item['image'] ?? null;
		$link = $item['link'] ?? null;
		$cards[] = array(
			'image'       => ( $img && ! empty( $img['url'] ) ) ? $img['url'] : '',
			'alt'         => $img['alt'] ?? '',
			'title'       => $item['title'] ?? '',
			'description' => $item['description'] ?? '',
			'url'         => ( $link && ! empty( $link['url'] ) ) ? $link['url'] : '',
		);
	}
}
$props = wp_json_encode(
	array(
		'items'    => $cards,
		'interval' => 5000,
	)
);
?>
<section class="overflow-hidden bg-neutral-50 py-20 md:py-28" data-section="linh-vuc">
	<div class="container-lx">
		<div class="grid grid-cols-1 gap-10 lg:grid-cols-12 lg:items-center lg:gap-12">
			<div class="lg:col-span-4" data-reveal>
				<?php if ( $label ) : ?>
					<p class="mb-3 text-sm font-medium uppercase tracking-[0.25em] text-brand"><?php echo esc_html( $label ); ?></p>
				<?php endif; ?>
				<?php if ( $title ) : ?>
					<h2 class="text-3xl font-bold uppercase leading-tight text-brand md:text-4xl lg:text-5xl"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( $desc ) : ?>
					<p class="mt-5 max-w-md text-neutral-600"><?php echo esc_html( $desc ); ?></p>
				<?php endif; ?>
				<?php if ( $more_link && ! empty( $more_link['url'] ) ) : ?>
					<a href="<?php echo esc_url( $more_link['url'] ); ?>" <?php echo ! empty( $more_link['target'] ) ? 'target="' . esc_attr( $more_link['target'] ) . '"' : ''; ?> class="mt-8 inline-flex items-center gap-2 rounded-full border border-neutral-300 px-6 py-2.5 text-sm font-medium text-neutral-800 transition hover:border-brand hover:bg-brand hover:text-white">
						<?php echo esc_html( ! empty( $more_link['title'] ) ? $more_link['title'] : 'Xem thêm' ); ?>
					</a>
				<?php endif; ?>
			</div>

			<?php if ( $cards ) : ?>
				<div class="lg:col-span-8" data-reveal>
					<div data-vue="LinhVucCarousel" data-props="<?php echo esc_attr( $props ); ?>">
						<div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
							<?php
							foreach ( $cards as $card ) :
								$tag = $card['url'] ? 'a' : 'div';
								?>
								<<?php echo $tag; ?> <?php echo $card['url'] ? 'href="' . esc_url( $card['url'] ) . '"' : ''; ?> class="flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-black/5">
									<?php if ( $card['image'] ) : ?>
										<img src="<?php echo esc_url( $card['image'] ); ?>" alt="<?php echo esc_attr( $card['alt'] ); ?>" class="aspect-[4/3] w-full object-cover" loading="lazy">
									<?php endif; ?>
									<div class="p-4">
										<h3 class="text-xl font-bold text-neutral-900"><?php echo esc_html( $card['title'] ); ?></h3>
										<?php if ( $card['description'] ) : ?>
											<p class="mt-2 text-sm text-neutral-500"><?php echo esc_html( $card['description'] ); ?></p>
										<?php endif; ?>
									</div>
								</<?php echo $tag; ?>>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
