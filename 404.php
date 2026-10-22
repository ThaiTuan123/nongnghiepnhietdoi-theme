<?php
/**
 * 404 — không tìm thấy trang.
 *
 * @package NongNghiepNhietDoi
 */

get_header();

$library_url     = function_exists( 'nongnghiepnhietdoi_library_url' ) ? nongnghiepnhietdoi_library_url() : home_url( '/thu-vien-tin-tuc/' );
$about_url       = home_url( '/ve-chung-toi/' );
$services_url    = home_url( '/linh-vuc-dich-vu/' );
$projects_url    = home_url( '/du-an-tac-dong/' );
$partnership_url = home_url( '/hop-tac-du-an/' );
$contact_url     = home_url( '/lien-he/' );

$quick_links = array(
	array(
		'label' => __( 'Trang chủ', 'nongnghiepnhietdoi' ),
		'url'   => home_url( '/' ),
		'desc'  => __( 'Quay về trang chính', 'nongnghiepnhietdoi' ),
	),
	array(
		'label' => __( 'Thư viện & Tin tức', 'nongnghiepnhietdoi' ),
		'url'   => $library_url,
		'desc'  => __( 'Bài viết, cẩm nang, tài liệu', 'nongnghiepnhietdoi' ),
	),
	array(
		'label' => __( 'Về chúng tôi', 'nongnghiepnhietdoi' ),
		'url'   => $about_url,
		'desc'  => __( 'Giới thiệu trung tâm VARC', 'nongnghiepnhietdoi' ),
	),
	array(
		'label' => __( 'Lĩnh vực & Dịch vụ', 'nongnghiepnhietdoi' ),
		'url'   => $services_url,
		'desc'  => __( 'Nghiên cứu và tư vấn', 'nongnghiepnhietdoi' ),
	),
	array(
		'label' => __( 'Dự án & Tác động', 'nongnghiepnhietdoi' ),
		'url'   => $projects_url,
		'desc'  => __( 'Mô hình đã triển khai', 'nongnghiepnhietdoi' ),
	),
	array(
		'label' => __( 'Liên hệ', 'nongnghiepnhietdoi' ),
		'url'   => $contact_url,
		'desc'  => __( 'Gửi phản hồi hoặc hợp tác', 'nongnghiepnhietdoi' ),
	),
);
?>

<main id="main" class="site-main">

	<section class="relative overflow-hidden border-b border-slate-200/80 bg-white pt-28 pb-12 md:pt-36 md:pb-16">
		<div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top,rgba(0,156,72,0.08),transparent_55%)]" aria-hidden="true"></div>
		<div class="relative mx-auto max-w-[720px] px-4 text-center" data-reveal>
			<p class="font-sans text-6xl font-bold tracking-tight text-brand/20 md:text-7xl" aria-hidden="true">404</p>
			<p class="mt-2 text-xs font-semibold uppercase tracking-[0.16em] text-brand"><?php esc_html_e( 'Không tìm thấy', 'nongnghiepnhietdoi' ); ?></p>
			<h1 class="mt-3 font-sans text-3xl font-bold tracking-tight text-ink md:text-4xl">
				<?php esc_html_e( 'Trang bạn tìm không tồn tại', 'nongnghiepnhietdoi' ); ?>
			</h1>
			<p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-slate-500 md:text-base">
				<?php esc_html_e( 'Đường dẫn có thể đã đổi hoặc bị gõ sai. Hãy tìm lại bằng từ khóa, hoặc chọn một trang bên dưới.', 'nongnghiepnhietdoi' ); ?>
			</p>

			<form class="mx-auto mt-8 max-w-md" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<label class="sr-only" for="lx-404-search"><?php esc_html_e( 'Tìm kiếm trên website', 'nongnghiepnhietdoi' ); ?></label>
				<div class="flex h-12 overflow-hidden rounded-full bg-bone ring-1 ring-slate-200 focus-within:bg-white focus-within:ring-2 focus-within:ring-brand">
					<input
						id="lx-404-search"
						class="min-w-0 flex-1 bg-transparent px-5 text-sm text-ink outline-none placeholder:text-slate-400"
						type="search"
						name="s"
						placeholder="<?php esc_attr_e( 'Tìm bài viết, dự án…', 'nongnghiepnhietdoi' ); ?>"
						autocomplete="off"
					>
					<button type="submit" class="m-1.5 rounded-full bg-brand px-5 text-sm font-semibold text-white transition hover:bg-brand-700">
						<?php esc_html_e( 'Tìm', 'nongnghiepnhietdoi' ); ?>
					</button>
				</div>
			</form>

			<div class="mt-6 flex flex-wrap items-center justify-center gap-3">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-flex h-11 items-center rounded-full bg-brand px-5 text-sm font-semibold text-white transition hover:bg-brand-700">
					<?php esc_html_e( 'Về trang chủ', 'nongnghiepnhietdoi' ); ?>
				</a>
				<a href="<?php echo esc_url( $partnership_url ); ?>" class="inline-flex h-11 items-center rounded-full bg-white px-5 text-sm font-semibold text-ink ring-1 ring-slate-200 transition hover:text-brand hover:ring-brand/40">
					<?php esc_html_e( 'Hợp tác & dự án', 'nongnghiepnhietdoi' ); ?>
				</a>
			</div>
		</div>
	</section>

	<section class="bg-bone py-12 md:py-16">
		<div class="mx-auto max-w-[960px] px-4">
			<p class="text-center text-xs font-semibold uppercase tracking-[0.16em] text-brand" data-reveal>
				<?php esc_html_e( 'Gợi ý nhanh', 'nongnghiepnhietdoi' ); ?>
			</p>
			<ul class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-3" data-reveal-stagger>
				<?php foreach ( $quick_links as $link ) : ?>
					<li>
						<a href="<?php echo esc_url( $link['url'] ); ?>" class="group flex h-full flex-col rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-100 transition hover:-translate-y-0.5 hover:shadow-md hover:ring-brand/30">
							<span class="font-sans text-base font-bold text-ink transition group-hover:text-brand"><?php echo esc_html( $link['label'] ); ?></span>
							<span class="mt-1 text-sm text-slate-500"><?php echo esc_html( $link['desc'] ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

</main>

<?php
get_footer();
