<?php
/**
 * Card dự án tiêu biểu (bất động sản).
 *
 * Dữ liệu:
 * - Tiêu đề: tiêu đề bài viết (post title)
 * - Ảnh: ảnh đại diện (featured image)
 * - Địa chỉ / Giá / Trạng thái / Hiện trạng / Phòng ngủ / Phòng tắm / Diện tích: ACF fields
 *
 * @package NongNghiepNhietDoi
 */

$gia        = get_field( 'gia' );
$dia_chi    = get_field( 'dia_chi' );
$map_link   = get_field( 'map_link' );
$phong_ngu  = get_field( 'phong_ngu' );
$phong_tam  = get_field( 'phong_tam' );
$dien_tich  = get_field( 'dien_tich' );
$trang_thai = get_field( 'trang_thai' );
$hien_trang = get_field( 'hien_trang' );

// Link Google Maps: ưu tiên link khách nhập, nếu không thì tự dựng theo địa chỉ.
$maps_url = '';
if ( $map_link ) {
	$maps_url = $map_link;
} elseif ( $dia_chi ) {
	$maps_url = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $dia_chi );
}
?>
<article <?php post_class( 'group flex h-full flex-col overflow-hidden rounded-xl bg-white p-1.5 shadow-sm ring-1 ring-neutral-100 transition duration-500 hover:-translate-y-1 hover:shadow-xl hover:ring-brand/20 sm:rounded-2xl sm:p-2.5' ); ?> data-reveal>
	<a href="<?php the_permalink(); ?>" class="relative block overflow-hidden rounded-lg bg-neutral-100 sm:rounded-xl">
		<div class="aspect-[4/3] w-full overflow-hidden">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php
				the_post_thumbnail(
					'nongnghiepnhietdoi-card',
					array(
						'class'   => 'h-full w-full object-cover transition duration-700 ease-out group-hover:scale-[1.06]',
						'loading' => 'lazy',
						'alt'     => the_title_attribute( array( 'echo' => false ) ),
					)
				);
				?>
			<?php else : ?>
				<div class="flex h-full w-full items-center justify-center text-neutral-300">
					<svg class="h-12 w-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M2.25 6.75h19.5M6 3.75h12A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6A2.25 2.25 0 016 3.75z"/></svg>
				</div>
			<?php endif; ?>
		</div>
		<?php if ( $trang_thai || $hien_trang ) : ?>
			<div class="absolute right-2 top-2 z-10 flex max-w-[75%] flex-col items-end gap-1 sm:right-3 sm:top-3 sm:gap-1.5">
				<?php if ( $hien_trang ) : ?>
					<span class="max-w-full truncate rounded-full bg-brand px-2.5 py-1 text-[11px] font-semibold text-white shadow-sm sm:px-3 sm:py-1.5 sm:text-xs">
						<?php echo esc_html( $hien_trang ); ?>
					</span>
				<?php endif; ?>
				<?php if ( $trang_thai ) : ?>
					<span class="max-w-full truncate rounded-full bg-white/95 px-2.5 py-1 text-[11px] font-semibold text-neutral-800 shadow-sm ring-1 ring-black/5 sm:px-3 sm:py-1.5 sm:text-xs">
						<?php echo esc_html( $trang_thai ); ?>
					</span>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</a>

	<div class="flex flex-1 flex-col px-1.5 pb-2 pt-2.5 sm:px-3 sm:pb-3 sm:pt-4">
		<div class="flex items-start justify-between gap-2 sm:gap-3">
			<h3 class="min-w-0 flex-1">
				<a href="<?php the_permalink(); ?>" class="line-clamp-2 text-sm font-bold leading-snug text-neutral-900 transition-colors group-hover:text-brand sm:text-lg">
					<?php the_title(); ?>
				</a>
			</h3>
			<?php if ( $gia ) : ?>
				<span class="shrink-0 whitespace-nowrap rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-100 sm:px-3 sm:py-1 sm:text-sm">
					<?php echo esc_html( $gia ); ?>
				</span>
			<?php endif; ?>
		</div>

		<?php if ( $dia_chi ) : ?>
			<?php if ( $maps_url ) : ?>
				<a href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer" class="mt-1.5 flex items-start gap-1 text-xs text-neutral-500 transition-colors hover:text-brand sm:mt-2 sm:gap-1.5 sm:text-sm">
					<svg class="mt-0.5 h-3.5 w-3.5 shrink-0 sm:h-4 sm:w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
					<span class="line-clamp-2 leading-snug"><?php echo esc_html( $dia_chi ); ?></span>
				</a>
			<?php else : ?>
				<p class="mt-1.5 line-clamp-2 text-xs leading-snug text-neutral-500 sm:mt-2 sm:text-sm"><?php echo esc_html( $dia_chi ); ?></p>
			<?php endif; ?>
		<?php endif; ?>

		<?php
		$has_bed  = ( '' !== $phong_ngu && null !== $phong_ngu );
		$has_bath = ( '' !== $phong_tam && null !== $phong_tam );
		$has_area = ( '' !== $dien_tich && null !== $dien_tich );
		?>
		<?php if ( $has_bed || $has_bath || $has_area ) : ?>
			<div class="mt-auto grid grid-cols-3 gap-1.5 border-t border-neutral-100 pt-2.5 sm:gap-3 sm:pt-4">
				<?php if ( $has_bed ) : ?>
					<div class="flex flex-col gap-1 sm:gap-1.5">
						<svg class="h-4 w-4 text-neutral-700 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75V9.75a2.25 2.25 0 012.25-2.25h15a2.25 2.25 0 012.25 2.25v9M2.25 15h19.5M6.75 7.5v-.75A2.25 2.25 0 019 4.5h6a2.25 2.25 0 012.25 2.25v.75M2.25 18.75h19.5"/></svg>
						<span class="text-[11px] leading-tight text-neutral-600 sm:text-sm"><span class="font-medium text-neutral-800"><?php echo esc_html( $phong_ngu ); ?></span> <span class="hidden sm:inline"><?php esc_html_e( 'Phòng ngủ', 'nongnghiepnhietdoi' ); ?></span></span>
					</div>
				<?php endif; ?>
				<?php if ( $has_bath ) : ?>
					<div class="flex flex-col gap-1 sm:gap-1.5">
						<svg class="h-4 w-4 text-neutral-700 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12V6.75a2.25 2.25 0 012.25-2.25c.98 0 1.813.627 2.122 1.5M3 12h18v3a4.5 4.5 0 01-4.5 4.5h-9A4.5 4.5 0 013 15v-3zM6 19.5L5.25 21m12.75-1.5L18.75 21"/></svg>
						<span class="text-[11px] leading-tight text-neutral-600 sm:text-sm"><span class="font-medium text-neutral-800"><?php echo esc_html( $phong_tam ); ?></span> <span class="hidden sm:inline"><?php esc_html_e( 'Phòng tắm', 'nongnghiepnhietdoi' ); ?></span></span>
					</div>
				<?php endif; ?>
				<?php if ( $has_area ) : ?>
					<div class="flex flex-col gap-1 sm:gap-1.5">
						<svg class="h-4 w-4 text-neutral-700 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M20.25 20.25v-4.5m0 4.5h-4.5m4.5 0L15 15M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15m11.25-11.25v4.5m0-4.5h-4.5m4.5 0L15 9"/></svg>
						<span class="text-[11px] leading-tight text-neutral-600 sm:text-sm"><span class="font-medium text-neutral-800"><?php echo esc_html( $dien_tich ); ?></span> m&sup2;</span>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</article>
