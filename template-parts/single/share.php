<?php
/**
 * Thanh chia sẻ bài viết.
 *
 * @package NongNghiepNhietDoi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$url   = rawurlencode( get_permalink() );
$title = rawurlencode( get_the_title() );
$text  = get_the_title();
$plain = get_permalink();

$channels = array(
	array(
		'key'   => 'facebook',
		'label' => __( 'Facebook', 'nongnghiepnhietdoi' ),
		'href'  => 'https://www.facebook.com/sharer/sharer.php?u=' . $url,
		'icon'  => '<path d="M13.5 21v-8h2.7l.4-3.1h-3.1V7.9c0-.9.25-1.5 1.55-1.5H17V3.6c-.29-.04-1.28-.12-2.43-.12-2.4 0-4.07 1.47-4.07 4.17v2.24H7.8V13h2.7v8h3z"/>',
	),
	array(
		'key'   => 'zalo',
		'label' => __( 'Zalo', 'nongnghiepnhietdoi' ),
		'href'  => 'https://zalo.me/share?u=' . $url . '&t=' . $title,
		'icon'  => '<path d="M12 2.5C6.8 2.5 2.6 6.3 2.6 11c0 2.7 1.4 5.1 3.6 6.7v3.3l3.3-1.8c.8.2 1.6.3 2.5.3 5.2 0 9.4-3.8 9.4-8.5S17.2 2.5 12 2.5Zm4.1 10.8c-.2.6-1.2 1.1-1.7 1.2-.4.1-1 .2-2.9-.6-2.3-1-3.8-3.3-3.9-3.4-.1-.2-.9-1.2-.9-2.3 0-1.1.6-1.6.8-1.8.2-.2.5-.3.7-.3h.5c.2 0 .4 0 .5.4.2.5.6 1.8.7 1.9.1.2.1.3 0 .5-.1.2-.2.3-.3.4-.1.1-.3.3-.1.5.1.2.6 1 .1.2 1.4.8 1.6.5.2-.1.4-.2.5-.1.2.1 1 .5 1.2.6.2.1.3.2.3.3 0 .1 0 .6-.2 1.2Z"/>',
	),
	array(
		'key'   => 'linkedin',
		'label' => __( 'LinkedIn', 'nongnghiepnhietdoi' ),
		'href'  => 'https://www.linkedin.com/sharing/share-offsite/?url=' . $url,
		'icon'  => '<path d="M6.3 9.2H3.6V20h2.7V9.2ZM4.9 4a1.6 1.6 0 1 0 0 3.2 1.6 1.6 0 0 0 0-3.2ZM20.4 20h-2.7v-5.8c0-1.5-.5-2.5-1.8-2.5-1 0-1.5.7-1.8 1.3-.1.2-.1.6-.1.9V20H11V9.2h2.7v1.5c.4-.7 1.3-1.8 3.2-1.8 2.3 0 4 1.5 4 4.8V20Z"/>',
	),
	array(
		'key'   => 'email',
		'label' => __( 'Email', 'nongnghiepnhietdoi' ),
		'href'  => 'mailto:?subject=' . $title . '&body=' . $url,
		'icon'  => '<path d="M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm8 7.01L5.2 7h13.6L12 12.01ZM5 8.24V17h14V8.24l-6.4 4.7a1 1 0 0 1-1.2 0L5 8.24Z"/>',
	),
);
?>
<div class="lx-share" data-lx-share data-reveal>
	<div class="lx-share__label">
		<span class="lx-share__dot" aria-hidden="true"></span>
		<span><?php esc_html_e( 'Chia sẻ', 'nongnghiepnhietdoi' ); ?></span>
	</div>
	<ul class="lx-share__list" role="list">
		<?php foreach ( $channels as $i => $channel ) : ?>
			<li style="--lx-i: <?php echo (int) $i; ?>">
				<a
					class="lx-share__btn lx-share__btn--<?php echo esc_attr( $channel['key'] ); ?>"
					href="<?php echo esc_url( $channel['href'] ); ?>"
					target="_blank"
					rel="noopener noreferrer"
					aria-label="<?php echo esc_attr( sprintf( __( 'Chia sẻ lên %s', 'nongnghiepnhietdoi' ), $channel['label'] ) ); ?>"
				>
					<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><?php echo $channel['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></svg>
				</a>
			</li>
		<?php endforeach; ?>
		<li style="--lx-i: <?php echo count( $channels ); ?>">
			<button
				type="button"
				class="lx-share__btn lx-share__btn--copy"
				data-lx-copy="<?php echo esc_attr( $plain ); ?>"
				aria-label="<?php esc_attr_e( 'Sao chép liên kết', 'nongnghiepnhietdoi' ); ?>"
			>
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
					<rect x="8" y="8" width="12" height="12" rx="2"/>
					<path d="M6 16H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
				</svg>
				<span class="lx-share__copied" aria-live="polite"><?php esc_html_e( 'Đã sao chép', 'nongnghiepnhietdoi' ); ?></span>
			</button>
		</li>
	</ul>
	<?php if ( ! empty( $text ) ) : ?>
		<button type="button" class="lx-share__native" data-lx-native-share data-title="<?php echo esc_attr( $text ); ?>" data-url="<?php echo esc_attr( $plain ); ?>" hidden>
			<?php esc_html_e( 'Chia sẻ…', 'nongnghiepnhietdoi' ); ?>
		</button>
	<?php endif; ?>
</div>
