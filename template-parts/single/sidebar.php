<?php
/**
 * Sidebar trang bài viết: tìm kiếm, tin mới, tài liệu, CTA hợp tác.
 *
 * @package NongNghiepNhietDoi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$current_id = get_the_ID();

$latest = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 5,
		'post__not_in'        => array( $current_id ),
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

$library_terms = function_exists( 'nongnghiepnhietdoi_library_terms' ) ? nongnghiepnhietdoi_library_terms() : array();
$library_ids   = $library_terms ? wp_list_pluck( $library_terms, 'term_id' ) : array();

$docs = null;
if ( $library_ids ) {
	$docs = new WP_Query(
		array(
			'post_type'           => 'post',
			'posts_per_page'      => 4,
			'post__not_in'        => array( $current_id ),
			'category__in'        => $library_ids,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);
}

$library_url     = function_exists( 'nongnghiepnhietdoi_library_url' ) ? nongnghiepnhietdoi_library_url() : home_url( '/thu-vien-tin-tuc/' );
$partnership_id  = function_exists( 'nongnghiepnhietdoi_partnership_page_id' ) ? nongnghiepnhietdoi_partnership_page_id() : 0;
$partnership_url = $partnership_id ? get_permalink( $partnership_id ) : home_url( '/hop-tac-du-an/' );
$partnership_url = trailingslashit( $partnership_url ) . '#gui-thong-tin';
$news_url        = home_url( '/thu-vien-tin-tuc/' );
?>
<aside class="lx-post-sidebar" aria-label="<?php esc_attr_e( 'Thông tin bổ sung', 'nongnghiepnhietdoi' ); ?>">

	<div class="lx-post-widget" data-reveal="right">
		<h2 class="lx-post-widget__title"><?php esc_html_e( 'Tìm kiếm', 'nongnghiepnhietdoi' ); ?></h2>
		<form role="search" method="get" class="lx-post-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label class="sr-only" for="lx-post-search"><?php esc_html_e( 'Tìm kiếm bài viết', 'nongnghiepnhietdoi' ); ?></label>
			<input
				type="search"
				id="lx-post-search"
				name="s"
				value="<?php echo esc_attr( get_search_query() ); ?>"
				placeholder="<?php esc_attr_e( 'Nhập từ khóa…', 'nongnghiepnhietdoi' ); ?>"
				autocomplete="off"
			>
			<button type="submit" aria-label="<?php esc_attr_e( 'Tìm kiếm', 'nongnghiepnhietdoi' ); ?>">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
					<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>
				</svg>
			</button>
		</form>
	</div>

	<?php if ( $latest->have_posts() ) : ?>
		<div class="lx-post-widget" data-reveal="right" data-reveal-delay="0.06">
			<div class="lx-post-widget__head">
				<h2 class="lx-post-widget__title"><?php esc_html_e( 'Tin mới nhất', 'nongnghiepnhietdoi' ); ?></h2>
				<a class="lx-post-widget__more" href="<?php echo esc_url( $news_url ); ?>"><?php esc_html_e( 'Xem tất cả', 'nongnghiepnhietdoi' ); ?></a>
			</div>
			<ul class="lx-post-list" data-reveal-stagger>
				<?php
				while ( $latest->have_posts() ) :
					$latest->the_post();
					?>
					<li>
						<a href="<?php the_permalink(); ?>" class="lx-post-list__item">
							<span class="lx-post-list__thumb">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php
									the_post_thumbnail(
										'thumbnail',
										array(
											'loading' => 'lazy',
											'alt'     => '',
										)
									);
									?>
								<?php else : ?>
									<span class="lx-post-list__placeholder" aria-hidden="true"></span>
								<?php endif; ?>
							</span>
							<span class="lx-post-list__body">
								<span class="lx-post-list__title"><?php the_title(); ?></span>
								<span class="lx-post-list__meta"><?php echo esc_html( get_the_date() ); ?></span>
							</span>
						</a>
					</li>
				<?php endwhile; ?>
			</ul>
			<?php wp_reset_postdata(); ?>
		</div>
	<?php endif; ?>

	<?php if ( $docs && $docs->have_posts() ) : ?>
		<div class="lx-post-widget" data-reveal="right" data-reveal-delay="0.1">
			<div class="lx-post-widget__head">
				<h2 class="lx-post-widget__title"><?php esc_html_e( 'Tài liệu', 'nongnghiepnhietdoi' ); ?></h2>
				<a class="lx-post-widget__more" href="<?php echo esc_url( $library_url ); ?>"><?php esc_html_e( 'Thư viện', 'nongnghiepnhietdoi' ); ?></a>
			</div>
			<ul class="lx-doc-list" data-reveal-stagger>
				<?php
				while ( $docs->have_posts() ) :
					$docs->the_post();
					$doc_cats = get_the_category();
					$doc_cat  = ! empty( $doc_cats ) ? $doc_cats[0] : null;
					?>
					<li>
						<a href="<?php the_permalink(); ?>" class="lx-doc-list__item">
							<span class="lx-doc-list__icon" aria-hidden="true">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
									<path d="M7 3.5h7l4 4V20a1.5 1.5 0 0 1-1.5 1.5h-9.5A1.5 1.5 0 0 1 5.5 20V5A1.5 1.5 0 0 1 7 3.5Z"/>
									<path d="M14 3.5V8h4.5M8.5 12h7M8.5 15.5h7M8.5 19h4"/>
								</svg>
							</span>
							<span class="lx-doc-list__body">
								<?php if ( $doc_cat ) : ?>
									<span class="lx-doc-list__cat"><?php echo esc_html( $doc_cat->name ); ?></span>
								<?php endif; ?>
								<span class="lx-doc-list__title"><?php the_title(); ?></span>
							</span>
						</a>
					</li>
				<?php endwhile; ?>
			</ul>
			<?php wp_reset_postdata(); ?>
		</div>
	<?php endif; ?>

	<div class="lx-post-cta" data-reveal="right" data-reveal-delay="0.14">
		<div class="lx-post-cta__glow" aria-hidden="true"></div>
		<p class="lx-post-cta__eyebrow"><?php esc_html_e( 'Hợp tác dự án', 'nongnghiepnhietdoi' ); ?></p>
		<h2 class="lx-post-cta__title"><?php esc_html_e( 'Liên hệ hợp tác dự án', 'nongnghiepnhietdoi' ); ?></h2>
		<p class="lx-post-cta__text">
			<?php esc_html_e( 'Gửi hồ sơ năng lực, Call for Proposal hoặc đề xuất hợp tác với đội ngũ chúng tôi.', 'nongnghiepnhietdoi' ); ?>
		</p>
		<a class="lx-post-cta__btn" href="<?php echo esc_url( $partnership_url ); ?>">
			<span><?php esc_html_e( 'Liên hệ ngay', 'nongnghiepnhietdoi' ); ?></span>
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
				<path d="M5 12h14M13 6l6 6-6 6"/>
			</svg>
		</a>
	</div>

</aside>
