<?php
/**
 * Section: Thư viện ảnh — lưới ảnh với hover zoom + lightbox.
 *
 * Map layout ACF: thu-vien-anh
 *
 * @package NongNghiepNhietDoi
 */

$images  = get_sub_field( 'images' );
$columns = (string) ( get_sub_field( 'columns' ) ?: '3' );
$gap     = (string) ( get_sub_field( 'gap' ) ?: 'md' );

if ( empty( $images ) || ! is_array( $images ) ) {
	return;
}

$col_map = array(
	'2' => 'sm:grid-cols-2',
	'3' => 'sm:grid-cols-2 lg:grid-cols-3',
	'4' => 'sm:grid-cols-2 lg:grid-cols-4',
);
$gap_map = array(
	'sm' => 'gap-2 md:gap-3',
	'md' => 'gap-3 md:gap-5',
	'lg' => 'gap-5 md:gap-8',
);

$col_class = $col_map[ $columns ] ?? $col_map['3'];
$gap_class = $gap_map[ $gap ] ?? $gap_map['md'];
$is_first  = (bool) get_query_var( 'lx_section_is_first' );
$pad_top   = $is_first ? 'pt-28 md:pt-36' : 'pt-4 md:pt-6';
?>
<section class="bg-white <?php echo esc_attr( $pad_top ); ?> pb-14 md:pb-20" data-section="thu-vien-anh">
	<div class="container-lx">
		<ul class="grid grid-cols-1 <?php echo esc_attr( $col_class . ' ' . $gap_class ); ?>" data-lightbox-gallery data-reveal-stagger>
			<?php foreach ( $images as $image ) : ?>
				<?php
				$id       = ! empty( $image['ID'] ) ? (int) $image['ID'] : 0;
				$url      = ! empty( $image['url'] ) ? $image['url'] : '';
				$alt      = ! empty( $image['alt'] ) ? $image['alt'] : ( $image['title'] ?? '' );
				$full_url = $id ? ( wp_get_attachment_image_url( $id, 'full' ) ?: $url ) : $url;
				if ( ! $id && ! $url ) {
					continue;
				}
				?>
				<li class="group overflow-hidden rounded-sm">
					<button
						type="button"
						class="relative block aspect-square w-full cursor-zoom-in overflow-hidden bg-neutral-100 text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2"
						data-lightbox-src="<?php echo esc_url( $full_url ); ?>"
						data-lightbox-alt="<?php echo esc_attr( $alt ); ?>"
						aria-label="<?php echo esc_attr( sprintf( /* translators: %s: image alt */ __( 'Xem ảnh lớn: %s', 'nongnghiepnhietdoi' ), $alt ?: __( 'Thư viện ảnh', 'nongnghiepnhietdoi' ) ) ); ?>"
					>
						<?php if ( $id ) : ?>
							<?php
							echo wp_get_attachment_image(
								$id,
								'large',
								false,
								array(
									'class'    => 'pointer-events-none h-full w-full object-cover transition duration-700 ease-out group-hover:scale-110',
									'loading'  => 'lazy',
									'alt'      => $alt,
									'draggable'=> 'false',
								)
							);
							?>
						<?php else : ?>
							<img
								src="<?php echo esc_url( $url ); ?>"
								alt="<?php echo esc_attr( $alt ); ?>"
								class="pointer-events-none h-full w-full object-cover transition duration-700 ease-out group-hover:scale-110"
								loading="lazy"
								draggable="false"
							>
						<?php endif; ?>
					</button>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
