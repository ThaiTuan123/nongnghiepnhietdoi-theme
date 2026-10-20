<?php
/**
 * Inline SVG icons (social, ...).
 *
 * @package NongNghiepNhietDoi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * In ra icon SVG mạng xã hội theo key.
 *
 * @param string $key facebook|instagram|twitter|email|tiktok|youtube.
 * @return void
 */
function nongnghiepnhietdoi_social_icon( $key ) {
	$icons = array(
		'facebook'  => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M13.5 21v-8h2.7l.4-3.1h-3.1V7.9c0-.9.25-1.5 1.55-1.5H17V3.6c-.29-.04-1.28-.12-2.43-.12-2.4 0-4.07 1.47-4.07 4.17v2.24H7.8V13h2.7v8h3z"/></svg>',
		'instagram' => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M12 8.6a3.4 3.4 0 1 0 0 6.8 3.4 3.4 0 0 0 0-6.8Zm0 5.6a2.2 2.2 0 1 1 0-4.4 2.2 2.2 0 0 1 0 4.4Zm3.5-5.75a.8.8 0 1 1-1.6 0 .8.8 0 0 1 1.6 0ZM17.7 8c-.05-1.05-.29-1.98-1.06-2.74C15.88 4.5 14.95 4.26 13.9 4.2 12.82 4.14 9.58 4.14 8.5 4.2c-1.05.06-1.98.3-2.74 1.06C4.99 6.02 4.75 6.95 4.7 8c-.06 1.08-.06 4.32 0 5.4.05 1.05.29 1.98 1.06 2.74.76.77 1.69 1.01 2.74 1.06 1.08.06 4.32.06 5.4 0 1.05-.05 1.98-.29 2.74-1.06.77-.76 1.01-1.69 1.06-2.74.06-1.08.06-4.32 0-5.4Zm-1.43 6.56c-.23.58-.68 1.03-1.26 1.26-.87.35-2.95.27-3.91.27-.96 0-3.05.08-3.91-.27a2.26 2.26 0 0 1-1.26-1.26c-.35-.87-.27-2.95-.27-3.91 0-.96-.08-3.05.27-3.91.23-.58.68-1.03 1.26-1.26.87-.35 2.95-.27 3.91-.27.96 0 3.05-.08 3.91.27.58.23 1.03.68 1.26 1.26.35.87.27 2.95.27 3.91 0 .96.08 3.05-.27 3.91Z"/></svg>',
		'twitter'   => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M19.6 7.2c.01.16.01.32.01.48 0 4.9-3.73 10.55-10.55 10.55-2.1 0-4.05-.61-5.69-1.67.29.03.58.05.88.05 1.74 0 3.34-.59 4.61-1.59a3.71 3.71 0 0 1-3.46-2.57c.23.04.46.07.7.07.34 0 .67-.05.98-.13a3.7 3.7 0 0 1-2.97-3.63v-.05c.5.28 1.07.44 1.68.46a3.7 3.7 0 0 1-1.15-4.94 10.52 10.52 0 0 0 7.63 3.87 3.7 3.7 0 0 1 6.3-3.37 7.3 7.3 0 0 0 2.35-.9 3.71 3.71 0 0 1-1.63 2.05 7.4 7.4 0 0 0 2.13-.58 7.94 7.94 0 0 1-1.85 1.92Z"/></svg>',
		'email'     => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm8 7.01L5.2 7h13.6L12 12.01ZM5 8.24V17h14V8.24l-6.4 4.7a1 1 0 0 1-1.2 0L5 8.24Z"/></svg>',
		'tiktok'    => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M16.6 5.82A4.28 4.28 0 0 1 15.5 3h-3.02v11.75a2.44 2.44 0 0 1-2.44 2.35 2.44 2.44 0 0 1-.53-4.82v-3.1a5.46 5.46 0 0 0-4.9 5.43A5.46 5.46 0 0 0 10.07 20a5.46 5.46 0 0 0 5.46-5.46V8.66a7.27 7.27 0 0 0 4.24 1.36V7a4.28 4.28 0 0 1-3.17-1.18Z"/></svg>',
		'youtube'   => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M21.6 7.2a2.5 2.5 0 0 0-1.76-1.77C18.27 5 12 5 12 5s-6.27 0-7.84.43A2.5 2.5 0 0 0 2.4 7.2 26.1 26.1 0 0 0 2 12a26.1 26.1 0 0 0 .4 4.8 2.5 2.5 0 0 0 1.76 1.77C5.73 19 12 19 12 19s6.27 0 7.84-.43a2.5 2.5 0 0 0 1.76-1.77A26.1 26.1 0 0 0 22 12a26.1 26.1 0 0 0-.4-4.8ZM10 15V9l5.2 3-5.2 3Z"/></svg>',
	);

	if ( isset( $icons[ $key ] ) ) {
		echo wp_kses(
			$icons[ $key ],
			array(
				'svg'  => array(
					'viewbox'     => true,
					'fill'        => true,
					'aria-hidden' => true,
					'focusable'   => true,
				),
				'path' => array( 'd' => true ),
			)
		);
	}
}
