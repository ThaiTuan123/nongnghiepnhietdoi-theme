<?php
/**
 * Single Dự án (post type: du_an).
 *
 * Bố cục minh bạch: hero ảnh -> bảng thông số tổng quan + nội dung mô tả,
 * cột phải là thẻ liên hệ dính (sticky), cuối trang là dự án liên quan.
 *
 * @package NongNghiepNhietDoi
 */

get_header();

while ( have_posts() ) :
	the_post();

	$gia        = get_field( 'gia' );
	$dien_tich  = get_field( 'dien_tich' );
	$trang_thai = get_field( 'trang_thai' );
	$hien_trang = get_field( 'hien_trang' );
	$loai_hinh  = get_field( 'loai_hinh' );
	$so_tang   = get_field( 'so_tang' );
	$huong     = get_field( 'huong' );
	$phong_ngu = get_field( 'phong_ngu' );
	$phong_tam = get_field( 'phong_tam' );
	$dia_chi   = get_field( 'dia_chi' );
	$map_link  = get_field( 'map_link' );
	$specs     = get_field( 'thong_tin_them' );

	$maps_url = '';
	if ( $map_link ) {
		$maps_url = $map_link;
	} elseif ( $dia_chi ) {
		$maps_url = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $dia_chi );
	}

	// Bảng thông số tổng quan (chỉ hiển thị dòng có dữ liệu).
	$overview = array();
	if ( $trang_thai ) {
		$overview[] = array(
			'label' => __( 'Trạng thái', 'nongnghiepnhietdoi' ),
			'value' => $trang_thai,
		);
	}
	if ( $hien_trang ) {
		$overview[] = array(
			'label' => __( 'Hiện trạng', 'nongnghiepnhietdoi' ),
			'value' => $hien_trang,
		);
	}
	if ( $loai_hinh ) {
		$overview[] = array(
			'label' => __( 'Loại hình', 'nongnghiepnhietdoi' ),
			'value' => $loai_hinh,
		);
	}
	if ( '' !== $dien_tich && null !== $dien_tich ) {
		$overview[] = array(
			'label' => __( 'Diện tích', 'nongnghiepnhietdoi' ),
			'value' => $dien_tich . ' m²',
		);
	}
	if ( $so_tang ) {
		$overview[] = array(
			'label' => __( 'Số tầng', 'nongnghiepnhietdoi' ),
			'value' => $so_tang,
		);
	}
	if ( $huong ) {
		$overview[] = array(
			'label' => __( 'Hướng', 'nongnghiepnhietdoi' ),
			'value' => $huong,
		);
	}
	if ( '' !== $phong_ngu && null !== $phong_ngu ) {
		$overview[] = array(
			'label' => __( 'Phòng ngủ', 'nongnghiepnhietdoi' ),
			'value' => $phong_ngu,
		);
	}
	if ( '' !== $phong_tam && null !== $phong_tam ) {
		$overview[] = array(
			'label' => __( 'Phòng tắm', 'nongnghiepnhietdoi' ),
			'value' => $phong_tam,
		);
	}
	if ( $gia ) {
		$overview[] = array(
			'label' => __( 'Giá bán', 'nongnghiepnhietdoi' ),
			'value' => $gia,
		);
	}
	if ( is_array( $specs ) ) {
		foreach ( $specs as $spec ) {
			if ( ! empty( $spec['label'] ) && '' !== ( $spec['value'] ?? '' ) ) {
				$overview[] = array(
					'label' => $spec['label'],
					'value' => $spec['value'],
				);
			}
		}
	}

	$phone     = nongnghiepnhietdoi_option( 'contact_phone' );
	$phone_tel = $phone ? preg_replace( '/[^0-9+]/', '', $phone ) : '';
	$email     = nongnghiepnhietdoi_option( 'contact_email' );
	$lien_he   = home_url( '/lien-he/' );
	$agent_name = get_bloginfo( 'name' ) ?: 'Nông nghiệp nhiệt đới';
	$agent_img  = NONGNGHIEPNHIETDOI_URI . '/assets/images/cskh.webp';
	?>

	<main id="main" class="site-main">
		<article <?php post_class(); ?>>

			<!-- ============ Hero ============ -->
			<header class="relative flex min-h-[46vh] items-end overflow-hidden pt-24 md:min-h-[56vh]" data-dark-hero>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="absolute inset-x-0 -inset-y-[34%]" data-parallax="0.2">
						<?php the_post_thumbnail( 'nongnghiepnhietdoi-wide', array( 'class' => 'h-full w-full object-cover' ) ); ?>
					</div>
					<div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/80 via-black/45 to-black/25"></div>
				<?php else : ?>
					<div class="absolute inset-0 bg-gradient-to-br from-brand-900 via-brand-700 to-brand-500"></div>
				<?php endif; ?>

				<div class="container-lx relative z-10 pb-10 text-white md:pb-14" data-reveal>
					<nav class="mb-4 flex flex-wrap items-center gap-2 text-xs uppercase tracking-widest text-white/70" aria-label="breadcrumb">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="transition hover:text-white"><?php esc_html_e( 'Trang chủ', 'nongnghiepnhietdoi' ); ?></a>
						<span>/</span>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'du_an' ) ); ?>" class="transition hover:text-white"><?php esc_html_e( 'Bất động sản', 'nongnghiepnhietdoi' ); ?></a>
					</nav>
					<h1 class="max-w-4xl text-3xl font-bold leading-tight md:text-4xl lg:text-5xl"><?php the_title(); ?></h1>
					<div class="mt-5 flex flex-wrap items-center gap-3">
						<?php if ( $gia ) : ?>
							<span class="inline-flex items-center rounded-full bg-brand px-4 py-1.5 text-sm font-semibold text-white shadow-sm"><?php echo esc_html( $gia ); ?></span>
						<?php endif; ?>
						<?php if ( $dia_chi ) : ?>
							<span class="inline-flex items-center gap-1.5 text-sm text-white/85">
								<svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
								<?php echo esc_html( $dia_chi ); ?>
							</span>
						<?php endif; ?>
					</div>
				</div>
			</header>

			<!-- ============ Nội dung ============ -->
			<div class="container-lx py-12 md:py-16">
				<div class="grid grid-cols-1 gap-8 lg:grid-cols-12 lg:gap-10">

					<!-- Cột trái -->
					<div class="lg:col-span-8">

						<?php if ( $overview ) : ?>
							<section class="rounded-2xl border border-neutral-200/80 bg-transparent p-6 md:p-8" data-reveal aria-label="<?php esc_attr_e( 'Thông tin tổng quan', 'nongnghiepnhietdoi' ); ?>">
								<h2 class="mb-5 text-lg font-bold uppercase tracking-wide text-brand"><?php esc_html_e( 'Thông tin tổng quan', 'nongnghiepnhietdoi' ); ?></h2>
								<dl class="grid grid-cols-1 gap-x-8 gap-y-4 sm:grid-cols-2" data-reveal-stagger>
									<?php foreach ( $overview as $row ) : ?>
										<div class="flex items-start gap-2.5 border-b border-neutral-100 pb-3">
											<svg class="mt-0.5 h-5 w-5 shrink-0 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
											<div class="min-w-0">
												<dt class="text-sm text-neutral-500"><?php echo esc_html( $row['label'] ); ?></dt>
												<dd class="font-semibold text-neutral-900"><?php echo esc_html( $row['value'] ); ?></dd>
											</div>
										</div>
									<?php endforeach; ?>
								</dl>

								<?php if ( $maps_url ) : ?>
									<a href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer" class="mt-6 inline-flex items-center gap-2 text-sm font-medium text-brand transition hover:text-brand-700">
										<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
										<?php esc_html_e( 'Xem vị trí trên Google Maps', 'nongnghiepnhietdoi' ); ?>
									</a>
								<?php endif; ?>
							</section>
						<?php endif; ?>

						<?php if ( get_the_content() ) : ?>
							<section class="mt-10" data-reveal>
								<div class="mb-5 flex items-center gap-3">
									<span class="h-6 w-1.5 rounded-full bg-brand"></span>
									<h2 class="text-xl font-bold uppercase tracking-wide text-neutral-900 md:text-2xl"><?php esc_html_e( 'Tổng quan dự án', 'nongnghiepnhietdoi' ); ?></h2>
								</div>
								<div class="prose prose-neutral max-w-none prose-headings:font-bold prose-headings:text-neutral-900 prose-a:text-brand prose-strong:text-neutral-900 prose-li:marker:text-brand">
									<?php the_content(); ?>
								</div>
							</section>
						<?php endif; ?>
					</div>

					<!-- Cột phải: thẻ tư vấn viên sticky (luxury contact card) -->
					<aside class="lg:col-span-4" aria-label="<?php esc_attr_e( 'Liên hệ tư vấn', 'nongnghiepnhietdoi' ); ?>">
						<div class="lg:sticky lg:top-[120px]" data-reveal>
							<div class="overflow-hidden rounded-[24px] border border-[#B08A4A]/40 bg-transparent px-6 py-8 text-center sm:px-8">
								<!-- Avatar -->
								<div class="mx-auto mb-6 h-24 w-24 overflow-hidden rounded-full ring-2 ring-[#B08A4A]/ring-offset-2 ring-offset-transparent">
									<img
										src="<?php echo esc_url( $agent_img ); ?>"
										alt="<?php echo esc_attr( $agent_name ); ?>"
										class="h-full w-full object-cover object-[center_18%]"
										width="96"
										height="96"
										loading="lazy"
										decoding="async"
									>
								</div>

								<!-- Identity -->
								<h2 class="text-xl font-semibold tracking-wide text-neutral-900"><?php echo esc_html( $agent_name ); ?></h2>
								<p class="mt-2 text-xs font-medium uppercase tracking-[0.2em] text-[#B08A4A]"><?php esc_html_e( 'Property Consultant', 'nongnghiepnhietdoi' ); ?></p>

								<?php if ( $phone ) : ?>
									<a href="tel:<?php echo esc_attr( $phone_tel ); ?>" class="mt-6 block text-lg font-medium tracking-wide text-neutral-800 transition hover:text-[#B08A4A]">
										<?php echo esc_html( $phone ); ?>
									</a>
								<?php endif; ?>

								<!-- CTAs -->
								<div class="mt-8 space-y-3">
									<?php if ( $phone ) : ?>
										<a
											href="tel:<?php echo esc_attr( $phone_tel ); ?>"
											class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#B08A4A] px-5 py-3.5 text-sm font-semibold uppercase tracking-wider text-white transition duration-300 hover:bg-[#9a763d] hover:shadow-[0_8px_24px_-4px_rgba(176,138,74,0.45)]"
										>
											<svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
											<?php esc_html_e( 'Call Now', 'nongnghiepnhietdoi' ); ?>
										</a>
									<?php endif; ?>

									<a
										href="<?php echo esc_url( $lien_he ); ?>"
										class="flex w-full items-center justify-center rounded-xl border border-[#B08A4A] px-5 py-3.5 text-sm font-semibold uppercase tracking-wider text-[#B08A4A] transition duration-300 hover:bg-[#B08A4A] hover:text-white"
									>
										<?php esc_html_e( 'Request Information', 'nongnghiepnhietdoi' ); ?>
									</a>
								</div>

								<?php if ( $email ) : ?>
									<a href="mailto:<?php echo esc_attr( $email ); ?>" class="mt-6 flex items-center justify-center gap-2 break-all text-sm text-neutral-500 transition hover:text-[#B08A4A]">
										<svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
										<?php echo esc_html( $email ); ?>
									</a>
								<?php endif; ?>
							</div>
						</div>
					</aside>
				</div>
			</div>

			<?php
			// ============ Dự án liên quan ============
			$terms    = get_the_terms( get_the_ID(), 'loai_du_an' );
			$term_ids = ( $terms && ! is_wp_error( $terms ) ) ? wp_list_pluck( $terms, 'term_id' ) : array();

			$related_args = array(
				'post_type'           => 'du_an',
				'posts_per_page'      => 3,
				'post__not_in'        => array( get_the_ID() ),
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
			);
			if ( $term_ids ) {
				$related_args['tax_query'] = array(
					array(
						'taxonomy' => 'loai_du_an',
						'field'    => 'term_id',
						'terms'    => $term_ids,
					),
				);
			}
			$related = new WP_Query( $related_args );

			if ( $related->have_posts() ) :
				?>
				<section class="bg-neutral-50 py-14 md:py-20" data-section="du-an-lien-quan">
					<div class="container-lx">
						<div class="mb-8 flex items-center gap-3" data-reveal>
							<span class="h-6 w-1.5 rounded-full bg-brand"></span>
							<h2 class="text-xl font-bold uppercase tracking-wide text-neutral-900 md:text-2xl"><?php esc_html_e( 'Dự án liên quan', 'nongnghiepnhietdoi' ); ?></h2>
						</div>
						<div class="grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-3" data-reveal-stagger>
							<?php
							while ( $related->have_posts() ) :
								$related->the_post();
								get_template_part( 'template-parts/content-project', 'card' );
							endwhile;
							wp_reset_postdata();
							?>
						</div>
					</div>
				</section>
			<?php endif; ?>

		</article>
	</main>

	<?php
endwhile;

get_footer();
