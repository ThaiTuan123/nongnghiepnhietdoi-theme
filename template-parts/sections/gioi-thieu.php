<?php
/**
 * Section: Giới thiệu (About).
 *
 * @package NongNghiepNhietDoi
 */

$label   = get_sub_field( 'label' );
$title   = get_sub_field( 'title' );
$content = get_sub_field( 'content' );
$image   = get_sub_field( 'image' );
$stats   = get_sub_field( 'stats' );
?>
<section class="py-20 md:py-28" data-section="gioi-thieu">
	<div class="container-lx grid grid-cols-1 items-center gap-10 lg:grid-cols-2 lg:gap-16">
		<div class="relative order-2 lg:order-1" data-reveal>
			<?php if ( $image && ! empty( $image['url'] ) ) : ?>
				<div class="group overflow-hidden rounded-2xl" data-parallax="0.12">
					<img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ?? '' ); ?>" class="w-full object-cover transition-transform duration-700 ease-out group-hover:scale-110" style="min-height:460px;" loading="lazy">
				</div>
			<?php endif; ?>
		</div>

		<div class="order-1 lg:order-2">
			<?php if ( $label ) : ?>
				<p class="mb-3 text-sm font-medium uppercase tracking-[0.25em] text-brand" data-reveal><?php echo esc_html( $label ); ?></p>
			<?php endif; ?>
			<?php if ( $title ) : ?>
				<h2 class="text-3xl font-bold leading-tight text-neutral-900 md:text-4xl lg:text-5xl" data-reveal><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>
			<?php if ( $content ) : ?>
				<div class="prose prose-neutral mt-6 max-w-none text-neutral-600" data-reveal><?php echo wp_kses_post( $content ); ?></div>
			<?php endif; ?>

			<?php if ( $stats ) : ?>
				<dl class="mt-10 grid grid-cols-2 gap-6 sm:grid-cols-3" data-reveal-stagger>
					<?php
					foreach ( $stats as $stat ) :
						$raw    = trim( (string) ( $stat['number'] ?? '' ) );
						$digits = preg_replace( '/[^0-9]/', '', $raw );
						$suffix = ltrim( $raw, '0123456789., ' );
						$props  = wp_json_encode(
							array(
								'value'  => $digits,
								'suffix' => $suffix,
							)
						);
						$icon   = $stat['icon'] ?? null;
						?>
						<div>
							<?php if ( $icon && ! empty( $icon['url'] ) ) : ?>
								<img src="<?php echo esc_url( $icon['url'] ); ?>" alt="<?php echo esc_attr( $icon['alt'] ?? '' ); ?>" class="mb-3 object-contain" style="width:40px;height:40px;" loading="lazy">
							<?php endif; ?>
							<dt class="text-3xl font-semibold text-brand md:text-4xl">
								<?php if ( '' !== $digits ) : ?>
									<span data-vue="StatCounter" data-props="<?php echo esc_attr( $props ); ?>"><?php echo esc_html( $raw ); ?></span>
								<?php else : ?>
									<?php echo esc_html( $raw ); ?>
								<?php endif; ?>
							</dt>
							<dd class="mt-1 text-sm text-neutral-500"><?php echo esc_html( $stat['label'] ?? '' ); ?></dd>
						</div>
					<?php endforeach; ?>
				</dl>
			<?php endif; ?>
		</div>
	</div>
</section>
