<?php
/**
 * Section: Nội dung hai cột — tiêu đề trái, mô tả + điểm nổi bật phải.
 *
 * Map layout ACF: noi-dung-hai-cot
 *
 * @package NongNghiepNhietDoi
 */

$title    = get_sub_field( 'title' );
$content  = get_sub_field( 'content' );
$features = get_sub_field( 'features' );

if ( ! $title && ! $content && empty( $features ) ) {
	return;
}

$is_first = (bool) get_query_var( 'lx_section_is_first' );
$pad_top  = $is_first ? 'pt-28 md:pt-36' : 'pt-14 md:pt-20';
$heading  = $is_first ? 'h1' : 'h2';
?>
<section class="bg-white <?php echo esc_attr( $pad_top ); ?> pb-10 md:pb-14" data-section="noi-dung-hai-cot">
	<div class="container-lx">
		<div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-2 lg:gap-14 xl:gap-20">
			<div data-reveal>
				<?php if ( $title ) : ?>
					<<?php echo $heading; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="text-2xl font-bold uppercase leading-snug tracking-wide text-brand sm:text-3xl md:text-4xl lg:text-[2.5rem] lg:leading-tight">
						<?php echo wp_kses_post( nl2br( esc_html( wp_strip_all_tags( (string) $title ) ), false ) ); ?>
					</<?php echo $heading; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php endif; ?>
			</div>

			<div data-reveal>
				<?php if ( $content ) : ?>
					<div class="text-base leading-relaxed text-neutral-700 [&_p]:mb-4 [&_p:last-child]:mb-0">
						<?php echo wp_kses_post( $content ); ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $features ) ) : ?>
					<ul class="mt-8 space-y-5 border-t border-neutral-200 pt-8" data-reveal-stagger>
						<?php foreach ( $features as $feature ) : ?>
							<?php
							$feat_title = trim( (string) ( $feature['title'] ?? '' ) );
							$feat_desc  = trim( (string) ( $feature['description'] ?? '' ) );
							if ( '' === $feat_title && '' === $feat_desc ) {
								continue;
							}
							?>
							<li class="flex gap-3">
								<span class="mt-2.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand" aria-hidden="true"></span>
								<div class="min-w-0">
									<?php if ( $feat_title ) : ?>
										<p class="text-base leading-relaxed text-neutral-700">
											<strong class="font-semibold text-neutral-900"><?php echo esc_html( $feat_title ); ?></strong>
											<?php if ( $feat_desc ) : ?>
												<span>: <?php echo esc_html( $feat_desc ); ?></span>
											<?php endif; ?>
										</p>
									<?php elseif ( $feat_desc ) : ?>
										<p class="text-base leading-relaxed text-neutral-700"><?php echo esc_html( $feat_desc ); ?></p>
									<?php endif; ?>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
