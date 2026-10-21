<?php
/**
 * Homepage sections for VARC.
 *
 * @package NongNghiepNhietDoi
 */

$img = NONGNGHIEPNHIETDOI_URI . '/assets/images';

$hero_eyebrow = 'Nghiên cứu & tư vấn';
$hero_title   = 'Tiên phong nông nghiệp thích ứng khí hậu';
$hero_desc    = 'Chuyển hóa công nghệ vi sinh, xử lý môi trường và đo lường phát thải thành sinh kế bền vững cho nông dân Việt Nam.';
$hero_cta     = array(
	'title'  => 'Hợp tác dự án',
	'url'    => '#lien-he',
	'target' => '',
);

$front_id = (int) get_option( 'page_on_front' );
if ( $front_id && function_exists( 'get_field' ) ) {
	$saved_eyebrow = get_field( 'home_hero_eyebrow', $front_id );
	$saved_title   = get_field( 'home_hero_title', $front_id );
	$saved_desc    = get_field( 'home_hero_description', $front_id );
	$saved_cta     = get_field( 'home_hero_cta', $front_id );

	if ( is_string( $saved_eyebrow ) && '' !== $saved_eyebrow ) {
		$hero_eyebrow = $saved_eyebrow;
	}
	if ( is_string( $saved_title ) && '' !== $saved_title ) {
		$hero_title = $saved_title;
	}
	if ( is_string( $saved_desc ) && '' !== $saved_desc ) {
		$hero_desc = $saved_desc;
	}
	if ( is_array( $saved_cta ) && ! empty( $saved_cta['url'] ) ) {
		$hero_cta = $saved_cta;
	}
}

$hero_slides = array();
$saved_rows  = ( $front_id && function_exists( 'get_field' ) ) ? get_field( 'home_hero_slides', $front_id ) : null;
if ( is_array( $saved_rows ) ) {
	foreach ( $saved_rows as $row ) {
		$type = $row['media_type'] ?? 'image';
		if ( 'video' === $type ) {
			$video  = $row['video'] ?? null;
			$poster = $row['poster'] ?? null;
			if ( $video && ! empty( $video['url'] ) ) {
				$poster_url     = ( $poster && ! empty( $poster['url'] ) ) ? $poster['url'] : '';
				$hero_slides[]  = array(
					'type'   => 'video',
					'src'    => $video['url'],
					'poster' => $poster_url,
					'thumb'  => $poster['sizes']['medium'] ?? $poster_url,
					'alt'    => $poster['alt'] ?? ( $video['title'] ?? '' ),
				);
			}
		} else {
			$image = $row['image'] ?? null;
			if ( $image && ! empty( $image['url'] ) ) {
				$hero_slides[] = array(
					'type'  => 'image',
					'src'   => $image['url'],
					'thumb' => $image['sizes']['medium'] ?? $image['url'],
					'alt'   => $image['alt'] ?? '',
				);
			}
		}
	}
}

if ( empty( $hero_slides ) ) {
	$theme_video = NONGNGHIEPNHIETDOI_DIR . '/assets/video/hero.mp4';
	if ( file_exists( $theme_video ) ) {
		$hero_slides[] = array(
			'type'   => 'video',
			'src'    => NONGNGHIEPNHIETDOI_URI . '/assets/video/hero.mp4',
			'poster' => $img . '/hero-field.jpg',
			'thumb'  => $img . '/hero-field.jpg',
			'alt'    => 'Cánh đồng lúa',
		);
	}
	$hero_slides[] = array(
		'type'  => 'image',
		'src'   => $img . '/hero-field.jpg',
		'thumb' => $img . '/hero-field.jpg',
		'alt'   => 'Cánh đồng lúa lúc bình minh',
	);
	$hero_slides[] = array(
		'type'  => 'image',
		'src'   => $img . '/about-field.jpg',
		'thumb' => $img . '/about-field.jpg',
		'alt'   => 'Nông sản tươi',
	);
}

$hero_first = $hero_slides[0];
$hero_props = wp_json_encode(
	array(
		'slides'          => $hero_slides,
		'interval'        => 5000,
		'hideCopyOnVideo' => false,
		'overlayClass'    => 'bg-gradient-to-r from-black/55 via-black/15 to-black/10',
	)
);
?>

<section class="relative isolate min-h-[100svh] overflow-hidden bg-ink text-white" data-section="hero">
	<div class="absolute inset-0 z-0" data-vue="HeroSlider" data-props="<?php echo esc_attr( $hero_props ); ?>">
		<?php if ( 'video' === $hero_first['type'] && ! empty( $hero_first['poster'] ) ) : ?>
			<img src="<?php echo esc_url( $hero_first['poster'] ); ?>" alt="<?php echo esc_attr( $hero_first['alt'] ); ?>" class="h-full w-full object-cover" fetchpriority="high">
		<?php elseif ( 'image' === $hero_first['type'] ) : ?>
			<img src="<?php echo esc_url( $hero_first['src'] ); ?>" alt="<?php echo esc_attr( $hero_first['alt'] ); ?>" class="h-full w-full object-cover" fetchpriority="high">
		<?php endif; ?>
		<div class="pointer-events-none absolute inset-0 bg-gradient-to-r from-black/55 via-black/15 to-black/10"></div>
	</div>
	<div class="pointer-events-none relative z-10 mx-auto flex min-h-[100svh] w-full max-w-[1360px] items-end px-4 pb-36 pt-28 sm:items-center sm:px-6 sm:pb-0 lg:justify-start lg:px-8">
		<div class="pointer-events-auto w-full max-w-[560px]">
			<?php if ( $hero_eyebrow ) : ?>
				<p class="mb-5 inline-flex w-fit items-center rounded-full border border-white/45 bg-white/10 px-4 py-1.5 text-sm text-white/95 backdrop-blur-sm" data-reveal><?php echo esc_html( $hero_eyebrow ); ?></p>
			<?php endif; ?>
			<?php if ( $hero_title ) : ?>
				<h1 class="font-sans text-[2rem] font-bold leading-[1.08] tracking-tight text-white sm:text-5xl lg:text-[56px]" data-reveal data-reveal-delay="0.12"><?php echo esc_html( $hero_title ); ?></h1>
			<?php endif; ?>
			<?php if ( $hero_desc ) : ?>
				<p class="mt-5 max-w-md text-sm leading-relaxed text-white/90 sm:text-base" data-reveal data-reveal-delay="0.24"><?php echo esc_html( $hero_desc ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $hero_cta['url'] ) ) : ?>
				<a href="<?php echo esc_url( $hero_cta['url'] ); ?>" class="varc-cta mt-8 inline-flex items-center gap-3 rounded-full bg-brand py-2 pl-6 pr-2 text-sm font-semibold text-white hover:bg-brand-700" data-reveal data-reveal-delay="0.36"<?php echo ! empty( $hero_cta['target'] ) ? ' target="' . esc_attr( $hero_cta['target'] ) . '" rel="noopener noreferrer"' : ''; ?>>
					<?php echo esc_html( $hero_cta['title'] ?: __( 'Hợp tác dự án', 'nongnghiepnhietdoi' ) ); ?>
					<span class="varc-cta-icon inline-flex h-10 w-10 items-center justify-center rounded-full bg-sun text-white" aria-hidden="true">
						<svg class="h-4 w-4" viewBox="0 0 16 16" fill="none"><path d="M4 12 12 4M6 4h6v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</span>
				</a>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php
$stat_defaults = array(
	array(
		'number'  => '25',
		'suffix'  => '+',
		'label'   => 'Chuyên gia & nhà khoa học cố vấn',
		'grouped' => false,
	),
	array(
		'number'  => '10000',
		'suffix'  => '+',
		'label'   => 'Hợp tác xã & nông dân trong mạng lưới',
		'grouped' => true,
	),
	array(
		'number'  => '40',
		'suffix'  => '+',
		'label'   => 'Mô hình vi sinh & CSA đã triển khai',
		'grouped' => false,
	),
	array(
		'number'  => '15',
		'suffix'  => '+',
		'label'   => 'Tỉnh/thành có hoạt động triển khai',
		'grouped' => false,
	),
);
$saved_stats = ( $front_id && function_exists( 'get_field' ) ) ? get_field( 'home_stats', $front_id ) : null;
$stats       = $stat_defaults;
if ( is_array( $saved_stats ) ) {
	$stats = array();
	foreach ( $saved_stats as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$number = isset( $row['number'] ) ? preg_replace( '/\D+/', '', (string) $row['number'] ) : '';
		$label  = isset( $row['label'] ) ? trim( (string) $row['label'] ) : '';
		if ( '' === $number && '' === $label ) {
			continue;
		}
		$stats[] = array(
			'number'  => $number,
			'suffix'  => isset( $row['suffix'] ) ? (string) $row['suffix'] : '',
			'label'   => $label,
			'grouped' => ! empty( $row['grouped'] ),
		);
	}
}

$about_eyebrow = 'Về VARC';
$about_title   = 'Trung tâm nghiên cứu khoa học';
$about_text    = 'VARC là đầu mối nghiên cứu và tư vấn nông nghiệp nhiệt đới: đưa công nghệ vi sinh, nông nghiệp thích ứng khí hậu và đo lường phát thải ra đồng ruộng, để nông hộ có sinh kế ổn định hơn và doanh nghiệp có chuỗi cung ứng sạch hơn.';
$about_image   = $img . '/about-field.jpg';
$about_alt     = 'Cánh đồng trong mạng lưới đồng hành của VARC';
$about_points  = array(
	'Nghiên cứu ứng dụng gắn với hiện trường, không dừng ở phòng thí nghiệm.',
	'Đồng hành hợp tác xã, doanh nghiệp và cơ quan quản lý trong cùng một mạng lưới.',
	'Đo được tác động: năng suất, sinh kế và phát thải khí nhà kính.',
);
if ( $front_id && function_exists( 'get_field' ) ) {
	$saved_eyebrow = get_field( 'home_about_eyebrow', $front_id );
	$saved_title   = get_field( 'home_about_title', $front_id );
	$saved_text    = get_field( 'home_about_text', $front_id );
	$saved_image   = get_field( 'home_about_image', $front_id );
	$saved_points  = get_field( 'home_about_points', $front_id );

	if ( is_string( $saved_eyebrow ) && '' !== $saved_eyebrow ) {
		$about_eyebrow = $saved_eyebrow;
	}
	if ( is_string( $saved_title ) && '' !== $saved_title ) {
		$about_title = $saved_title;
	}
	if ( is_string( $saved_text ) && '' !== $saved_text ) {
		$about_text = $saved_text;
	}
	if ( function_exists( 'nongnghiepnhietdoi_about_image_url' ) ) {
		$saved_image_url = nongnghiepnhietdoi_about_image_url( $saved_image );
		if ( $saved_image_url ) {
			$about_image = $saved_image_url;
			$about_alt   = nongnghiepnhietdoi_about_image_alt( $saved_image, $about_alt );
		}
	}
	if ( is_array( $saved_points ) ) {
		$about_points = array();
		foreach ( $saved_points as $point ) {
			$text = is_array( $point ) && isset( $point['text'] ) ? trim( (string) $point['text'] ) : '';
			if ( '' !== $text ) {
				$about_points[] = $text;
			}
		}
	}
}
$point_dots = array( 'bg-sun', 'bg-brand', 'bg-brand-700' );
?>

<section class="bg-brand text-white" aria-label="<?php esc_attr_e( 'Số liệu', 'nongnghiepnhietdoi' ); ?>">
	<div class="mx-auto grid max-w-[1200px] grid-cols-2 gap-6 px-4 py-8 lg:grid-cols-4" data-reveal-stagger>
		<?php foreach ( $stats as $stat ) : ?>
			<div class="text-center">
				<p class="text-2xl font-bold sm:text-3xl" data-count="<?php echo esc_attr( $stat['number'] ); ?>" data-count-suffix="<?php echo esc_attr( $stat['suffix'] ); ?>" <?php echo $stat['grouped'] ? 'data-count-group' : ''; ?>><?php echo esc_html( ( $stat['grouped'] ? number_format( (int) $stat['number'], 0, ',', '.' ) : $stat['number'] ) . $stat['suffix'] ); ?></p>
				<p class="mt-1 text-xs text-white/85 sm:text-sm"><?php echo esc_html( $stat['label'] ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<section id="ve-varc" class="scroll-mt-28 bg-white">
	<div class="mx-auto grid max-w-[1200px] items-center gap-8 px-4 py-12 md:py-16 lg:grid-cols-2">
		<div class="overflow-hidden rounded-3xl" data-reveal="image">
			<div data-reveal-frame>
				<img src="<?php echo esc_url( $about_image ); ?>" alt="<?php echo esc_attr( $about_alt ); ?>" class="h-full max-h-[280px] w-full object-cover sm:max-h-[420px]" width="1400" height="934">
			</div>
		</div>
		<div data-reveal="right">
			<p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand"><?php echo esc_html( $about_eyebrow ); ?></p>
			<h2 class="mt-3 font-sans text-3xl font-bold tracking-tight text-ink md:text-4xl"><?php echo esc_html( $about_title ); ?></h2>
			<p class="mt-4 text-[16px] leading-relaxed text-slate-600"><?php echo nl2br( esc_html( $about_text ) ); ?></p>
			<?php if ( $about_points ) : ?>
				<ul class="mt-6 space-y-3 text-sm text-slate-700">
					<?php foreach ( $about_points as $index => $point ) : ?>
						<li class="flex gap-3"><span class="mt-1 h-2 w-2 shrink-0 rounded-full <?php echo esc_attr( $point_dots[ $index % 3 ] ); ?>"></span><?php echo esc_html( $point ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php
$nl_eyebrow = 'Năng lực khác biệt';
$nl_title   = 'Khoa học ra đồng, đo được kết quả';
$nl_items   = array(
	array(
		'number' => '01',
		'title'  => 'Vi sinh bản địa',
		'text'   => 'Phân lập, nhân sinh khối và chuyển giao chế phẩm IMO phù hợp đất và cây của từng vùng.',
	),
	array(
		'number' => '02',
		'title'  => 'Hiện trường CSA',
		'text'   => 'Thiết kế mô hình nông nghiệp thông minh với khí hậu, theo mùa vụ và quy mô hợp tác xã.',
	),
	array(
		'number' => '03',
		'title'  => 'Đo phát thải',
		'text'   => 'Phương pháp đo lường phát thải khí nhà kính để đối chiếu trước và sau can thiệp.',
	),
	array(
		'number' => '04',
		'title'  => 'Chuyển giao',
		'text'   => 'Tập huấn nông hộ, sổ tay kỹ thuật và đồng hành sau khi mô hình được bàn giao.',
	),
);
$lv_eyebrow = 'Lĩnh vực hoạt động';
$lv_title   = 'Sáu nhóm việc VARC đang làm';
$lv_items   = array(
	array( 'title' => 'Công nghệ vi sinh', 'text' => 'Chế phẩm xử lý phụ phẩm, cải tạo đất và tăng sức chống chịu của cây trồng.' ),
	array( 'title' => 'Thích ứng khí hậu', 'text' => 'Mô hình CSA cho vùng nhiệt đới: nước, giống, lịch mùa và rủi ro thời tiết.' ),
	array( 'title' => 'Xử lý môi trường', 'text' => 'Ủ phân hữu cơ, giảm đốt phụ phẩm và xử lý ô nhiễm tại nông hộ.' ),
	array( 'title' => 'Phát thải khí nhà kính', 'text' => 'Đo, báo cáo và đề xuất biện pháp giảm phát thải trên đồng ruộng.' ),
	array( 'title' => 'Đào tạo chuyển giao', 'text' => 'Cẩm nang, tập huấn hiện trường và mạng lưới khuyến nông cộng đồng.' ),
	array( 'title' => 'Tư vấn độc lập', 'text' => 'Đánh giá dự án, đề tài khoa học công nghệ và chương trình quốc gia.' ),
);
if ( $front_id && function_exists( 'get_field' ) ) {
	$saved_nl_eyebrow = get_field( 'home_nl_eyebrow', $front_id );
	$saved_nl_title   = get_field( 'home_nl_title', $front_id );
	$saved_nl_items   = get_field( 'home_nl_items', $front_id );
	$saved_lv_eyebrow = get_field( 'home_lv_eyebrow', $front_id );
	$saved_lv_title   = get_field( 'home_lv_title', $front_id );
	$saved_lv_items   = get_field( 'home_lv_items', $front_id );

	if ( is_string( $saved_nl_eyebrow ) && '' !== $saved_nl_eyebrow ) {
		$nl_eyebrow = $saved_nl_eyebrow;
	}
	if ( is_string( $saved_nl_title ) && '' !== $saved_nl_title ) {
		$nl_title = $saved_nl_title;
	}
	if ( is_array( $saved_nl_items ) ) {
		$nl_items = array();
		foreach ( $saved_nl_items as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$title = isset( $row['title'] ) ? trim( (string) $row['title'] ) : '';
			$text  = isset( $row['text'] ) ? trim( (string) $row['text'] ) : '';
			if ( '' === $title && '' === $text ) {
				continue;
			}
			$nl_items[] = array(
				'number' => isset( $row['number'] ) ? trim( (string) $row['number'] ) : '',
				'title'  => $title,
				'text'   => $text,
			);
		}
	}
	if ( is_string( $saved_lv_eyebrow ) && '' !== $saved_lv_eyebrow ) {
		$lv_eyebrow = $saved_lv_eyebrow;
	}
	if ( is_string( $saved_lv_title ) && '' !== $saved_lv_title ) {
		$lv_title = $saved_lv_title;
	}
	if ( is_array( $saved_lv_items ) ) {
		$lv_items = array();
		foreach ( $saved_lv_items as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$title = isset( $row['title'] ) ? trim( (string) $row['title'] ) : '';
			$text  = isset( $row['text'] ) ? trim( (string) $row['text'] ) : '';
			if ( '' === $title && '' === $text ) {
				continue;
			}
			$lv_items[] = array(
				'title' => $title,
				'text'  => $text,
			);
		}
	}
}
?>

<section id="nang-luc" class="scroll-mt-28">
	<div class="mx-auto max-w-[1200px] px-4 py-12 md:py-16">
		<p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand"><?php echo esc_html( $nl_eyebrow ); ?></p>
		<h2 data-reveal class="mt-3 max-w-2xl font-sans text-3xl font-bold tracking-tight text-ink md:text-4xl"><?php echo esc_html( $nl_title ); ?></h2>
		<div class="mt-8 grid gap-4 sm:mt-10 md:grid-cols-12" data-reveal-stagger>
			<?php if ( ! empty( $nl_items[0] ) ) : ?>
			<article class="relative flex flex-col overflow-hidden rounded-3xl bg-ink text-white md:col-span-7 md:row-span-2">
				<div class="relative min-h-[200px] flex-1 overflow-hidden sm:min-h-[240px]" aria-hidden="true">
					<div class="absolute -left-10 top-6 h-40 w-40 rounded-full bg-brand/40 blur-2xl"></div>
					<div class="absolute right-6 top-4 h-28 w-28 rounded-full bg-sun/50 blur-2xl"></div>
					<svg class="absolute inset-0 h-full w-full" viewBox="0 0 420 280" fill="none" preserveAspectRatio="xMidYMid slice">
						<circle cx="168" cy="148" r="78" fill="#009c48"/>
						<circle cx="268" cy="112" r="52" fill="#f07818"/>
						<circle cx="246" cy="196" r="36" fill="#e8fe85"/>
						<circle cx="118" cy="196" r="22" fill="#009c48" opacity=".55"/>
						<circle cx="300" cy="176" r="14" fill="#fff"/>
						<circle cx="196" cy="78" r="8" fill="#fff" opacity=".8"/>
					</svg>
				</div>
				<div class="p-6 sm:p-8">
					<p class="text-sm font-bold text-sun"><?php echo esc_html( $nl_items[0]['number'] ); ?></p>
					<h3 class="mt-2 font-sans text-2xl font-bold"><?php echo esc_html( $nl_items[0]['title'] ); ?></h3>
					<p class="mt-2 max-w-md text-sm leading-relaxed text-white/75"><?php echo esc_html( $nl_items[0]['text'] ); ?></p>
				</div>
			</article>
			<?php endif; ?>

			<?php if ( ! empty( $nl_items[1] ) ) : ?>
			<article class="flex items-center gap-4 rounded-3xl bg-white p-4 ring-1 ring-slate-100 sm:gap-5 sm:p-5 md:col-span-5">
				<div class="grid h-24 w-24 shrink-0 place-items-center overflow-hidden rounded-2xl bg-[#e6ecd5] sm:h-28 sm:w-28" aria-hidden="true">
					<svg class="h-20 w-20" viewBox="0 0 96 96" fill="none">
						<circle cx="68" cy="26" r="10" fill="#f07818"/>
						<path d="M10 58c18-16 32-16 50 0s28 14 28 6v22H10V58z" fill="#009c48"/>
						<path d="M10 74c16-10 30-8 48 4 14 8 22 6 28 2v12H10V74z" fill="#0b1f33"/>
					</svg>
				</div>
				<div>
					<p class="text-sm font-bold text-sun"><?php echo esc_html( $nl_items[1]['number'] ); ?></p>
					<h3 class="mt-1 font-sans text-lg font-bold text-ink"><?php echo esc_html( $nl_items[1]['title'] ); ?></h3>
					<p class="mt-1 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $nl_items[1]['text'] ); ?></p>
				</div>
			</article>
			<?php endif; ?>

			<?php if ( ! empty( $nl_items[2] ) ) : ?>
			<article class="flex items-center gap-4 rounded-3xl bg-white p-4 ring-1 ring-slate-100 sm:gap-5 sm:p-5 md:col-span-5">
				<div class="grid h-24 w-24 shrink-0 place-items-center overflow-hidden rounded-2xl bg-[#fceace] sm:h-28 sm:w-28" aria-hidden="true">
					<svg class="h-20 w-20" viewBox="0 0 96 96" fill="none">
						<rect x="16" y="48" width="14" height="32" rx="4" fill="#009c48"/>
						<rect x="36" y="34" width="14" height="46" rx="4" fill="#0b1f33"/>
						<rect x="56" y="22" width="14" height="58" rx="4" fill="#f07818"/>
						<path d="M18 28c10-12 22-8 28 2" stroke="#009c48" stroke-width="4" stroke-linecap="round"/>
					</svg>
				</div>
				<div>
					<p class="text-sm font-bold text-sun"><?php echo esc_html( $nl_items[2]['number'] ); ?></p>
					<h3 class="mt-1 font-sans text-lg font-bold text-ink"><?php echo esc_html( $nl_items[2]['title'] ); ?></h3>
					<p class="mt-1 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $nl_items[2]['text'] ); ?></p>
				</div>
			</article>
			<?php endif; ?>

			<?php if ( ! empty( $nl_items[3] ) ) : ?>
			<article class="flex flex-col gap-4 rounded-3xl bg-white p-4 ring-1 ring-slate-100 sm:flex-row sm:items-center sm:gap-6 sm:p-5 md:col-span-12">
				<div class="grid h-24 w-full shrink-0 place-items-center overflow-hidden rounded-2xl bg-ink sm:h-28 sm:w-44" aria-hidden="true">
					<svg class="h-16 w-36" viewBox="0 0 140 64" fill="none">
						<circle cx="24" cy="32" r="14" fill="#009c48"/>
						<circle cx="70" cy="20" r="12" fill="#f07818"/>
						<circle cx="112" cy="36" r="14" fill="#e8fe85"/>
						<path d="M38 32h20M82 24l16 8" stroke="#fff" stroke-width="3" stroke-linecap="round"/>
					</svg>
				</div>
				<div>
					<p class="text-sm font-bold text-sun"><?php echo esc_html( $nl_items[3]['number'] ); ?></p>
					<h3 class="mt-1 font-sans text-lg font-bold text-ink"><?php echo esc_html( $nl_items[3]['title'] ); ?></h3>
					<p class="mt-1 max-w-2xl text-sm leading-relaxed text-slate-600"><?php echo esc_html( $nl_items[3]['text'] ); ?></p>
				</div>
			</article>
			<?php endif; ?>
			<?php foreach ( array_slice( $nl_items, 4 ) as $extra ) : ?>
			<article class="flex flex-col gap-4 rounded-3xl bg-white p-4 ring-1 ring-slate-100 sm:flex-row sm:items-center sm:gap-6 sm:p-5 md:col-span-12">
				<div>
					<p class="text-sm font-bold text-sun"><?php echo esc_html( $extra['number'] ); ?></p>
					<h3 class="mt-1 font-sans text-lg font-bold text-ink"><?php echo esc_html( $extra['title'] ); ?></h3>
					<p class="mt-1 max-w-2xl text-sm leading-relaxed text-slate-600"><?php echo esc_html( $extra['text'] ); ?></p>
				</div>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section id="linh-vuc" class="scroll-mt-28 bg-white">
	<div class="mx-auto max-w-[1200px] px-4 py-12 md:py-16">
		<p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand"><?php echo esc_html( $lv_eyebrow ); ?></p>
		<h2 data-reveal class="mt-3 font-sans text-3xl font-bold tracking-tight text-ink md:text-4xl"><?php echo esc_html( $lv_title ); ?></h2>
		<div class="mt-8 grid gap-4 sm:mt-10 sm:grid-cols-2 lg:grid-cols-3" data-reveal-stagger>
			<?php foreach ( $lv_items as $field ) : ?>
				<article class="rounded-2xl border border-slate-100 bg-bone p-6">
					<h3 class="font-sans text-lg font-bold text-ink"><?php echo esc_html( $field['title'] ); ?></h3>
					<p class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $field['text'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section id="du-an" class="scroll-mt-28">
	<div class="mx-auto max-w-[1200px] px-4 py-12 md:py-16">
		<div class="flex items-end justify-between gap-4">
			<div>
				<p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand">Dự án tiêu biểu</p>
				<h2 data-reveal class="mt-3 font-sans text-3xl font-bold tracking-tight text-ink md:text-4xl">Mô hình đã ra đồng</h2>
			</div>
		</div>
		<?php
		$featured_term = function_exists( 'nongnghiepnhietdoi_featured_project_term' ) ? nongnghiepnhietdoi_featured_project_term() : null;
		$featured_projects = new WP_Query(
			array(
				'post_type'           => 'post',
				'post_status'         => 'publish',
				'posts_per_page'      => -1,
				'orderby'             => 'date',
				'order'               => 'DESC',
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
				'category__in'        => ( $featured_term instanceof WP_Term ) ? array( (int) $featured_term->term_id ) : array( 0 ),
			)
		);
		?>
		<div class="mt-8 grid gap-4 sm:mt-10 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3" data-reveal-stagger>
			<?php if ( $featured_projects->have_posts() ) : ?>
				<?php
				$featured_index = 0;
				while ( $featured_projects->have_posts() ) :
					$featured_projects->the_post();
					$featured_image = get_the_post_thumbnail_url( get_the_ID(), 'medium_large' );
					if ( ! $featured_image ) {
						$featured_image = $img . ( 1 === $featured_index % 3 ? '/about-field.jpg' : '/hero-field.jpg' );
					}
					?>
					<article class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-100">
						<a href="<?php the_permalink(); ?>" class="block h-40 bg-cover bg-center" style="background-image:linear-gradient(160deg,rgba(0,156,72,.82),rgba(6,53,31,.55)),url('<?php echo esc_url( $featured_image ); ?>')"></a>
						<div class="p-6">
							<h3 class="font-sans text-lg font-bold text-ink">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>
							<p class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
						</div>
					</article>
					<?php
					++$featured_index;
				endwhile;
				wp_reset_postdata();
				?>
			<?php else : ?>
				<p class="text-sm text-slate-500 sm:col-span-2 lg:col-span-3"><?php esc_html_e( 'Chưa có dự án tiêu biểu.', 'nongnghiepnhietdoi' ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php
$people_eyebrow = 'Con người VARC';
$people_title   = 'Nhà khoa học, kỹ thuật viên và người đứng trên ruộng';
$people_text    = 'Đội ngũ VARC gồm chuyên gia cố vấn, cán bộ hiện trường và mạng lưới nông dân nòng cốt. Mỗi mô hình có người chịu trách nhiệm khoa học và người chịu trách nhiệm ngoài đồng.';
$people         = array(
	array(
		'title' => 'Nhà khoa học cố vấn',
		'text'  => 'Định hướng đề tài vi sinh, môi trường và phát thải; phản biện quy trình trước khi ra đồng.',
		'image' => $img . '/person-scientist.jpg',
		'alt'   => 'Nhà khoa học cố vấn trong phòng thí nghiệm',
	),
	array(
		'title' => 'Cán bộ hiện trường',
		'text'  => 'Lắp đặt mô hình, tập huấn nông hộ và ghi nhận số liệu theo vụ.',
		'image' => $img . '/person-field.jpg',
		'alt'   => 'Cán bộ hiện trường ghi số liệu trên ruộng lúa',
	),
	array(
		'title' => 'Nông dân nòng cốt',
		'text'  => 'Nhân chế phẩm, duy trì mô hình và lan tỏa trong hợp tác xã.',
		'image' => $img . '/person-farmer.jpg',
		'alt'   => 'Nông dân nòng cốt ủ phụ phẩm tại hợp tác xã',
	),
);
if ( $front_id && function_exists( 'get_field' ) ) {
	$saved_people_eyebrow = get_field( 'home_people_eyebrow', $front_id );
	$saved_people_title   = get_field( 'home_people_title', $front_id );
	$saved_people_text    = get_field( 'home_people_text', $front_id );
	$saved_people         = get_field( 'home_people_items', $front_id );

	if ( is_string( $saved_people_eyebrow ) && '' !== $saved_people_eyebrow ) {
		$people_eyebrow = $saved_people_eyebrow;
	}
	if ( is_string( $saved_people_title ) && '' !== $saved_people_title ) {
		$people_title = $saved_people_title;
	}
	if ( is_string( $saved_people_text ) && '' !== $saved_people_text ) {
		$people_text = $saved_people_text;
	}
	if ( is_array( $saved_people ) ) {
		$people = array();
		foreach ( $saved_people as $index => $row ) {
			$title = is_array( $row ) && isset( $row['title'] ) ? trim( (string) $row['title'] ) : '';
			$text  = is_array( $row ) && isset( $row['text'] ) ? trim( (string) $row['text'] ) : '';
			if ( '' === $title && '' === $text ) {
				continue;
			}
			$image = '';
			$alt   = $title;
			if ( function_exists( 'nongnghiepnhietdoi_about_image_url' ) ) {
				$image = nongnghiepnhietdoi_about_image_url( $row['image'] ?? null );
				$alt   = nongnghiepnhietdoi_about_image_alt( $row['image'] ?? null, $title );
			}
			$people[] = array(
				'title' => $title,
				'text'  => $text,
				'image' => $image,
				'alt'   => $alt,
			);
		}
	}
}
?>
<section id="con-nguoi" class="scroll-mt-28 bg-white">
	<div class="mx-auto max-w-[1200px] px-4 py-12 md:py-16">
		<p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand"><?php echo esc_html( $people_eyebrow ); ?></p>
		<h2 class="mt-3 max-w-2xl font-sans text-3xl font-bold tracking-tight text-ink md:text-4xl"><?php echo esc_html( $people_title ); ?></h2>
		<p class="mt-4 max-w-2xl text-slate-600"><?php echo esc_html( $people_text ); ?></p>
		<div class="mt-8 grid gap-4 sm:mt-10 md:grid-cols-3">
			<?php foreach ( $people as $person ) : ?>
				<article class="relative min-h-[300px] overflow-hidden rounded-2xl bg-ink">
					<?php if ( ! empty( $person['image'] ) ) : ?>
						<img src="<?php echo esc_url( $person['image'] ); ?>" alt="<?php echo esc_attr( $person['alt'] ); ?>" class="absolute inset-0 h-full w-full object-cover object-[center_22%]" width="1200" height="900">
					<?php endif; ?>
					<div class="absolute inset-0 bg-gradient-to-t from-ink/90 via-ink/35 to-ink/10" aria-hidden="true"></div>
					<div class="relative flex min-h-[300px] flex-col justify-end p-6">
						<h3 class="font-sans text-lg font-bold text-white"><?php echo esc_html( $person['title'] ); ?></h3>
						<p class="mt-2 text-sm leading-relaxed text-white/85"><?php echo esc_html( $person['text'] ); ?></p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section id="ban-dieu-hanh" class="scroll-mt-28">
	<div class="mx-auto max-w-[1200px] px-4 py-12 md:py-16">
		<p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand">Ban điều hành</p>
		<h2 data-reveal class="mt-3 font-sans text-3xl font-bold tracking-tight text-ink md:text-4xl">Bốn vai trò điều phối trung tâm</h2>
		<div class="mt-8 grid gap-4 sm:mt-10 sm:grid-cols-2 lg:grid-cols-4" data-reveal-stagger>
			<?php
			$board = array(
				array( 'Giám đốc', 'Điều phối chiến lược, đối tác và các chương trình quốc gia.' ),
				array( 'Phó giám đốc khoa học', 'Chịu trách nhiệm chất lượng nghiên cứu và hồ sơ đề tài.' ),
				array( 'Trưởng ban vi sinh', 'Quy trình chế phẩm, an toàn sinh học và chuyển giao kỹ thuật.' ),
				array( 'Trưởng ban hiện trường', 'Mạng lưới tỉnh, hợp tác xã và lịch triển khai theo vụ.' ),
			);
			foreach ( $board as $role ) :
				?>
				<article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
					<div class="h-1.5 w-10 rounded-full bg-sun"></div>
					<h3 class="mt-4 font-sans text-lg font-bold text-ink"><?php echo esc_html( $role[0] ); ?></h3>
					<p class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $role[1] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
$eco_eyebrow = 'Hệ sinh thái';
$eco_title   = 'VARC đứng giữa bốn nhóm đối tác';
$eco         = array(
	array(
		'title' => 'Nông hộ & HTX',
		'text'  => 'Nơi mô hình được làm, đo và nhân rộng.',
		'image' => $img . '/eco-farmers.jpg',
		'alt'   => 'Nông hộ và hợp tác xã bên những bao lúa',
	),
	array(
		'title' => 'Nhà khoa học',
		'text'  => 'Nguồn quy trình, phản biện và đào tạo.',
		'image' => $img . '/eco-scientist.jpg',
		'alt'   => 'Nhà khoa học theo dõi cây lúa trong nhà kính',
	),
	array(
		'title' => 'Doanh nghiệp',
		'text'  => 'Chuỗi tiêu thụ, chế phẩm và đồng tài trợ thử nghiệm.',
		'image' => $img . '/eco-business.jpg',
		'alt'   => 'Doanh nghiệp đóng gói lúa gạo trên dây chuyền',
	),
	array(
		'title' => 'Cơ quan quản lý',
		'text'  => 'Chương trình ngành, đề tài và khung đo phát thải.',
		'image' => $img . '/eco-agency.jpg',
		'alt'   => 'Cán bộ quản lý xem bản đồ vùng canh tác',
	),
);
if ( $front_id && function_exists( 'get_field' ) ) {
	$saved_eco_eyebrow = get_field( 'home_eco_eyebrow', $front_id );
	$saved_eco_title   = get_field( 'home_eco_title', $front_id );
	$saved_eco         = get_field( 'home_eco_items', $front_id );

	if ( is_string( $saved_eco_eyebrow ) && '' !== $saved_eco_eyebrow ) {
		$eco_eyebrow = $saved_eco_eyebrow;
	}
	if ( is_string( $saved_eco_title ) && '' !== $saved_eco_title ) {
		$eco_title = $saved_eco_title;
	}
	if ( is_array( $saved_eco ) ) {
		$eco = array();
		foreach ( $saved_eco as $row ) {
			$title = is_array( $row ) && isset( $row['title'] ) ? trim( (string) $row['title'] ) : '';
			$text  = is_array( $row ) && isset( $row['text'] ) ? trim( (string) $row['text'] ) : '';
			if ( '' === $title && '' === $text ) {
				continue;
			}
			$image = '';
			$alt   = $title;
			if ( function_exists( 'nongnghiepnhietdoi_about_image_url' ) ) {
				$image = nongnghiepnhietdoi_about_image_url( $row['image'] ?? null );
				$alt   = nongnghiepnhietdoi_about_image_alt( $row['image'] ?? null, $title );
			}
			$eco[] = array(
				'title' => $title,
				'text'  => $text,
				'image' => $image,
				'alt'   => $alt,
			);
		}
	}
}
?>
<section id="he-sinh-thai" class="scroll-mt-28 bg-ink text-white">
	<div class="mx-auto max-w-[1200px] px-4 py-12 md:py-16">
		<p class="text-xs font-semibold uppercase tracking-[0.16em] text-sun"><?php echo esc_html( $eco_eyebrow ); ?></p>
		<h2 data-reveal class="mt-3 max-w-2xl font-sans text-3xl font-bold tracking-tight md:text-4xl"><?php echo esc_html( $eco_title ); ?></h2>
		<div class="mt-8 grid gap-4 sm:mt-10 sm:grid-cols-2 lg:grid-cols-4" data-reveal-stagger>
			<?php foreach ( $eco as $node ) : ?>
				<article class="relative min-h-[320px] overflow-hidden rounded-2xl bg-white/5 ring-1 ring-white/10">
					<?php if ( ! empty( $node['image'] ) ) : ?>
						<img src="<?php echo esc_url( $node['image'] ); ?>" alt="<?php echo esc_attr( $node['alt'] ); ?>" class="absolute inset-0 h-full w-full object-cover object-[center_18%]" width="900" height="1200">
					<?php endif; ?>
					<div class="absolute inset-0 bg-gradient-to-t from-ink/90 via-ink/40 to-ink/15" aria-hidden="true"></div>
					<div class="relative flex min-h-[320px] flex-col justify-end p-5">
						<h3 class="font-sans text-lg font-bold text-white"><?php echo esc_html( $node['title'] ); ?></h3>
						<p class="mt-2 text-sm leading-relaxed text-white/85"><?php echo esc_html( $node['text'] ); ?></p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section id="tin-tuc" class="scroll-mt-28">
	<div class="mx-auto grid max-w-[1200px] gap-8 px-4 py-12 md:py-16 lg:grid-cols-[1fr_300px]">
		<div>
			<div class="flex items-end justify-between gap-4">
				<div>
					<p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand">Tin tức hoạt động</p>
					<h2 data-reveal class="mt-2 font-sans text-3xl font-bold tracking-tight text-ink">Tin tức</h2>
				</div>
				<?php
				$activity_term = function_exists( 'nongnghiepnhietdoi_activity_news_term' ) ? nongnghiepnhietdoi_activity_news_term() : null;
				$activity_url  = ( $activity_term instanceof WP_Term ) ? get_term_link( $activity_term ) : home_url( '/thu-vien-tin-tuc/' );
				if ( is_wp_error( $activity_url ) ) {
					$activity_url = home_url( '/thu-vien-tin-tuc/' );
				}
				?>
				<a href="<?php echo esc_url( $activity_url ); ?>" class="text-sm font-semibold text-brand">Xem tất cả →</a>
			</div>
			<?php
			$activity_news = new WP_Query(
				array(
					'post_type'           => 'post',
					'post_status'         => 'publish',
					'posts_per_page'      => 3,
					'orderby'             => 'date',
					'order'               => 'DESC',
					'ignore_sticky_posts' => true,
					'no_found_rows'       => true,
					'category__in'        => ( $activity_term instanceof WP_Term ) ? array( (int) $activity_term->term_id ) : array( 0 ),
				)
			);
			?>
			<div class="mt-8 grid gap-4 sm:grid-cols-2 md:grid-cols-3" data-reveal-stagger>
				<?php if ( $activity_news->have_posts() ) : ?>
					<?php
					while ( $activity_news->have_posts() ) :
						$activity_news->the_post();
						?>
						<article class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-100">
							<a href="<?php the_permalink(); ?>" class="block h-28 overflow-hidden bg-gradient-to-br from-brand-700 to-brand">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php
									the_post_thumbnail(
										'medium_large',
										array(
											'class' => 'h-full w-full object-cover',
											'alt'   => '',
										)
									);
									?>
								<?php endif; ?>
							</a>
							<div class="p-4">
								<p class="text-xs text-slate-400"><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></p>
								<h3 class="mt-2 font-sans text-[15px] font-bold leading-snug text-brand">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
								<p class="mt-2 line-clamp-3 text-sm text-slate-600"><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
							</div>
						</article>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				<?php else : ?>
					<p class="text-sm text-slate-500 sm:col-span-2 md:col-span-3"><?php esc_html_e( 'Chưa có tin tức hoạt động.', 'nongnghiepnhietdoi' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php
		$handbook_term = get_term_by( 'slug', 'cam-nang-ky-thuat-cho-nong-dan', 'category' );
		if ( ! $handbook_term || is_wp_error( $handbook_term ) ) {
			$handbook_term = get_term_by( 'name', 'Cẩm nang kỹ thuật cho nông dân', 'category' );
		}
		$handbook_docs = new WP_Query(
			array(
				'post_type'           => 'post',
				'post_status'         => 'publish',
				'posts_per_page'      => 5,
				'orderby'             => 'date',
				'order'               => 'DESC',
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
				'category__in'        => ( $handbook_term instanceof WP_Term ) ? array( (int) $handbook_term->term_id ) : array( 0 ),
			)
		);
		$handbook_url = function_exists( 'nongnghiepnhietdoi_library_url' )
			? nongnghiepnhietdoi_library_url( 'cam-nang-ky-thuat-cho-nong-dan' )
			: home_url( '/thu-vien-tin-tuc/' );
		?>
		<aside class="h-fit rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-100" data-reveal="right">
			<h3 class="font-sans text-base font-bold text-ink">Tài liệu mới</h3>
			<?php if ( $handbook_docs->have_posts() ) : ?>
				<ul class="mt-4 space-y-4 text-sm">
					<?php
					while ( $handbook_docs->have_posts() ) :
						$handbook_docs->the_post();
						?>
						<li>
							<p class="font-semibold text-ink">
								<a href="<?php the_permalink(); ?>" class="hover:text-brand"><?php the_title(); ?></a>
							</p>
							<?php if ( $handbook_term instanceof WP_Term ) : ?>
								<p class="text-xs text-slate-400"><?php echo esc_html( $handbook_term->name ); ?></p>
							<?php endif; ?>
						</li>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				</ul>
			<?php else : ?>
				<p class="mt-4 text-sm text-slate-500"><?php esc_html_e( 'Chưa có cẩm nang kỹ thuật.', 'nongnghiepnhietdoi' ); ?></p>
			<?php endif; ?>
			<a href="<?php echo esc_url( $handbook_url ); ?>" class="mt-5 flex justify-center rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-ink hover:border-brand hover:text-brand">Xem tất cả</a>
		</aside>
	</div>
</section>

<section class="bg-gradient-to-r from-[#06351f] to-brand text-white">
	<div class="mx-auto flex max-w-[1200px] flex-col items-start justify-between gap-6 px-4 py-10 md:flex-row md:items-center md:py-12" data-reveal>
		<div>
			<h2 class="font-sans text-2xl font-bold md:text-3xl">Cùng VARC kiến tạo nền nông nghiệp phát thải thấp</h2>
			<p class="mt-2 max-w-2xl text-sm text-white/80 md:text-base">Chúng tôi sẵn sàng đồng hành cùng các Quỹ quốc tế, Đại sứ quán, NGO, doanh nghiệp và cơ quan quản lý nhà nước.</p>
		</div>
		<a href="<?php echo esc_url( home_url( '/hop-tac-du-an/' ) ); ?>" class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-semibold text-ink hover:bg-bone">Hợp tác dự án <span aria-hidden="true">→</span></a>
	</div>
</section>
