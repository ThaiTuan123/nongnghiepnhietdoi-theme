<?php
/**
 * Floating contact buttons (Messenger, Zalo, Điện thoại).
 *
 * Nút nổi bên trái màn hình, có animation. Thông tin lấy từ trang
 * "Cài đặt Nông nghiệp nhiệt đới". Nút chỉ hiện khi đã nhập link hoặc số điện thoại.
 *
 * @package NongNghiepNhietDoi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fb_messenger = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'contact_messenger' ) : '';
$fb_zalo      = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'contact_zalo' ) : '';
$fb_phone     = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'contact_phone' ) : '';

$fb_phone_digits = $fb_phone ? preg_replace( '/[^0-9+]/', '', $fb_phone ) : '';
$fb_phone_href   = 'tel:' . $fb_phone_digits;

// Zalo: nếu chưa nhập link riêng thì suy ra từ số điện thoại (zalo.me/{số}).
if ( ! $fb_zalo && $fb_phone_digits ) {
	$fb_zalo = 'https://zalo.me/' . ltrim( $fb_phone_digits, '+' );
}

$fb_items = array();

if ( $fb_messenger ) {
	$fb_items[] = array(
		'key'      => 'messenger',
		'label'    => __( 'Nhắn tin Messenger', 'nongnghiepnhietdoi' ),
		'url'      => $fb_messenger,
		'external' => true,
		'icon'     => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C6.5 2 2 6.15 2 11.5c0 2.9 1.3 5.49 3.35 7.25V22l3.06-1.68c.82.23 1.68.35 2.59.35 5.5 0 10-4.15 10-9.5S17.5 2 12 2Zm1.01 12.49-2.55-2.72-4.98 2.72 5.47-5.81 2.61 2.72 4.94-2.72-5.49 5.81Z"/></svg>',
	);
}

if ( $fb_zalo ) {
	$fb_items[] = array(
		'key'      => 'zalo',
		'label'    => __( 'Chat Zalo', 'nongnghiepnhietdoi' ),
		'url'      => $fb_zalo,
		'external' => true,
		'icon'     => '<svg viewBox="0 0 48 48" aria-hidden="true"><path fill="currentColor" d="M13 9h22a6 6 0 0 1 6 6v13a6 6 0 0 1-6 6H25l-9 6.5V34h-3a6 6 0 0 1-6-6V15a6 6 0 0 1 6-6Z"/><text x="24.5" y="26.5" text-anchor="middle" font-family="Arial, Helvetica, sans-serif" font-weight="700" font-size="13" fill="#0068FF" font-style="italic">Zalo</text></svg>',
	);
}

if ( $fb_phone_href && 'tel:' !== $fb_phone_href ) {
	$fb_items[] = array(
		'key'      => 'phone',
		'label'    => __( 'Gọi điện', 'nongnghiepnhietdoi' ),
		'url'      => $fb_phone_href,
		'external' => false,
		'icon'     => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.6 10.8c1.4 2.8 3.8 5.2 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.3 1.1.4 2.4.6 3.6.6.6 0 1 .5 1 1V20c0 .6-.4 1-1 1C10.3 21 3 13.7 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.4 0 .8-.3 1L6.6 10.8Z"/></svg>',
	);
}

if ( empty( $fb_items ) ) {
	return;
}
?>
<div class="lx-float" aria-label="<?php esc_attr_e( 'Liên hệ nhanh', 'nongnghiepnhietdoi' ); ?>">
	<?php foreach ( $fb_items as $item ) : ?>
		<a
			href="<?php echo esc_url( $item['url'] ); ?>"
			class="lx-float__btn lx-float__btn--<?php echo esc_attr( $item['key'] ); ?>"
			aria-label="<?php echo esc_attr( $item['label'] ); ?>"
			<?php
			if ( $item['external'] ) :
				?>
				target="_blank" rel="noopener"<?php endif; ?>
		>
			<span class="lx-float__ring" aria-hidden="true"></span>
			<span class="lx-float__icon" aria-hidden="true">
				<?php
				echo wp_kses(
					$item['icon'],
					array(
						'svg'  => array(
							'viewbox'     => true,
							'fill'        => true,
							'aria-hidden' => true,
						),
						'path' => array(
							'd'    => true,
							'fill' => true,
						),
						'text' => array(
							'x'           => true,
							'y'           => true,
							'text-anchor' => true,
							'font-family' => true,
							'font-weight' => true,
							'font-size'   => true,
							'font-style'  => true,
							'fill'        => true,
						),
					)
				);
				?>
			</span>
			<span class="lx-float__tooltip"><?php echo esc_html( $item['label'] ); ?></span>
		</a>
	<?php endforeach; ?>
</div>
