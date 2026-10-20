<?php
/**
 * Footer VARC.
 *
 * @package NongNghiepNhietDoi
 */

$varc_logo = NONGNGHIEPNHIETDOI_URI . '/assets/images/logo-varc.png';
?>

<footer id="site-footer" class="site-footer bg-ink">
	<div class="mx-auto grid max-w-[1200px] gap-10 px-4 py-12 sm:grid-cols-2 sm:py-14 lg:grid-cols-4">
		<div>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-flex items-center gap-3" rel="home">
				<span class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-white">
					<img src="<?php echo esc_url( $varc_logo ); ?>" alt="" class="h-12 w-12 rounded-full object-cover" width="48" height="48">
				</span>
			</a>
			<p class="mt-4 text-sm font-semibold text-white">Trung tâm Nghiên cứu và Tư vấn Nông nghiệp Nhiệt đới</p>
			<p class="mt-3 text-sm leading-relaxed text-white/70">Trung tâm Nghiên cứu và Tư vấn Nông nghiệp Nhiệt đới (VARC) chuyển hóa tiến bộ khoa học thành sinh kế bền vững cho nông dân, giá trị gia tăng cho doanh nghiệp và bảo vệ môi trường sinh thái.</p>
		</div>

		<div>
			<h2 class="text-sm font-semibold text-white">Liên kết nhanh</h2>
			<ul class="mt-4 space-y-2 text-sm text-white/70">
				<li><a class="hover:text-white" href="<?php echo esc_url( home_url( '/ve-chung-toi/' ) ); ?>">Về Chúng tôi</a></li>
				<li><a class="hover:text-white" href="<?php echo esc_url( home_url( '/linh-vuc-dich-vu/' ) ); ?>">Lĩnh vực &amp; Dịch Vụ</a></li>
				<li><a class="hover:text-white" href="<?php echo esc_url( home_url( '/du-an-tac-dong/' ) ); ?>">Dự Án &amp; Tác Động</a></li>
				<li><a class="hover:text-white" href="<?php echo esc_url( home_url( '/thu-vien-tin-tuc/' ) ); ?>">Thư Viện &amp; Tin Tức</a></li>
				<li><a class="hover:text-white" href="<?php echo esc_url( home_url( '/hop-tac-du-an/' ) ); ?>">Hợp Tác Dự Án</a></li>
			</ul>
		</div>

		<div>
			<h2 class="text-sm font-semibold text-white">Lĩnh vực &amp; Dịch vụ</h2>
			<ul class="mt-4 space-y-2 text-sm text-white/70">
				<li>Nghiên cứu, Triển khai &amp; Chuyển giao Công nghệ</li>
				<li>Dịch vụ Tư vấn &amp; Đánh giá Dự án Độc lập</li>
				<li>Đề tài KH&amp;CN &amp; Chương trình Quốc gia</li>
			</ul>
		</div>

		<div id="lien-he">
			<h2 class="text-sm font-semibold text-white">Liên hệ &amp; Hợp tác</h2>
			<ul class="mt-4 space-y-3 text-sm text-white/75">
				<li>121 Nguyễn Bỉnh Khiêm, Phường Tân Định, TP. Hồ Chí Minh</li>
				<li><a class="hover:text-white" href="mailto:info@nongnghiepnhietdoi.org">info@nongnghiepnhietdoi.org</a></li>
				<li>Thứ 2 – Thứ 6: 08:00 – 17:00</li>
			</ul>
			<form class="mt-4 flex overflow-hidden rounded-lg bg-white/10 ring-1 ring-white/15" action="<?php echo esc_url( home_url( '/#lien-he' ) ); ?>" method="post">
				<label class="sr-only" for="footer-email"><?php esc_html_e( 'Email', 'nongnghiepnhietdoi' ); ?></label>
				<input id="footer-email" name="email" type="email" required placeholder="Email" class="w-full bg-transparent px-3 py-2.5 text-sm text-white placeholder:text-white/50 focus:outline-none">
				<button type="submit" class="bg-brand px-3 text-white hover:bg-brand-700" aria-label="<?php esc_attr_e( 'Đăng ký', 'nongnghiepnhietdoi' ); ?>">→</button>
			</form>
			<p class="mt-2 text-xs text-white/50">Đăng ký nhận bản tin</p>
		</div>
	</div>
	<div class="border-t border-white/10">
		<div class="mx-auto flex max-w-[1200px] flex-col gap-2 px-4 py-4 text-xs text-white/50 sm:flex-row sm:justify-between">
			<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> Trung tâm Nghiên cứu và Tư vấn Nông nghiệp Nhiệt đới (VARC). Bảo lưu mọi quyền.</p>
			<a class="hover:text-white" href="<?php echo esc_url( home_url( '/#lien-he' ) ); ?>">Chính sách bảo mật</a>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
