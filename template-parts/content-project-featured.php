<?php
/**
 * Card dự án gọn — dùng trong cột phụ "Bất động sản nổi bật".
 *
 * @package NongNghiepNhietDoi
 */

$gia       = get_field( 'gia' );
$dia_chi   = get_field( 'dia_chi' );
$phong_ngu = get_field( 'phong_ngu' );
$dien_tich = get_field( 'dien_tich' );
$terms     = get_the_terms( get_the_ID(), 'loai_du_an' );
$term      = ( ! is_wp_error( $terms ) && ! empty( $terms ) ) ? $terms[0] : null;
?>
<article <?php post_class( 'group flex min-h-0 flex-1 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-neutral-100 transition duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:ring-brand/20' ); ?> data-reveal>
	<a href="<?php the_permalink(); ?>" class="flex h-full min-h-[11rem] w-full flex-row overflow-hidden sm:min-h-[12.5rem]">
		<div class="relative w-[42%] shrink-0 overflow-hidden bg-neutral-100">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php
				the_post_thumbnail(
					'nongnghiepnhietdoi-card',
					array(
						'class'   => 'absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105',
						'loading' => 'lazy',
						'alt'     => the_title_attribute( array( 'echo' => false ) ),
					)
				);
				?>
			<?php else : ?>
				<div class="absolute inset-0 bg-gradient-to-br from-neutral-100 to-brand/10"></div>
			<?php endif; ?>
		</div>

		<div class="flex min-w-0 flex-1 flex-col justify-center gap-1.5 p-3.5 sm:gap-2 sm:p-4">
			<?php if ( $term ) : ?>
				<span class="text-[10px] font-semibold uppercase tracking-[0.14em] text-brand sm:text-[11px]"><?php echo esc_html( $term->name ); ?></span>
			<?php endif; ?>

			<h3 class="line-clamp-2 text-sm font-bold leading-snug text-neutral-900 transition group-hover:text-brand sm:text-base">
				<?php the_title(); ?>
			</h3>

			<?php if ( $dia_chi ) : ?>
				<p class="line-clamp-1 text-xs text-neutral-500"><?php echo esc_html( $dia_chi ); ?></p>
			<?php endif; ?>

			<div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-neutral-500">
				<?php if ( $gia ) : ?>
					<span class="rounded-full bg-emerald-50 px-2 py-0.5 font-semibold text-emerald-700 ring-1 ring-emerald-100"><?php echo esc_html( $gia ); ?></span>
				<?php endif; ?>
				<?php if ( '' !== $phong_ngu && null !== $phong_ngu ) : ?>
					<span><?php echo esc_html( $phong_ngu ); ?> PN</span>
				<?php endif; ?>
				<?php if ( '' !== $dien_tich && null !== $dien_tich ) : ?>
					<span><?php echo esc_html( $dien_tich ); ?> m²</span>
				<?php endif; ?>
			</div>
		</div>
	</a>
</article>
