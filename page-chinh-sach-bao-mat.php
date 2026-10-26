<?php
/**
 * Trang Chính sách bảo mật (slug: chinh-sach-bao-mat).
 *
 * WordPress tự chọn file này theo slug. Nội dung mô tả đúng dữ liệu
 * website đang thu thập: form liên hệ, form tư vấn, bản tin, cookie kỹ thuật
 * và bản đồ Google trên trang Liên hệ.
 *
 * @package NongNghiepNhietDoi
 */

$cs_company = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'site_company_name' ) : '';
$cs_short   = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'site_short_name' ) : 'TARCC';
$cs_email   = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'contact_email' ) : '';
$cs_phone   = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'contact_phone' ) : '';
$cs_address = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'contact_address' ) : '';
$cs_hours   = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'contact_hours' ) : '';

if ( ! $cs_company ) {
	$cs_company = 'Trung tâm Nghiên cứu và Tư vấn Nông nghiệp Nhiệt đới';
}
if ( ! $cs_short ) {
	$cs_short = 'TARCC';
}

$cs_phone_tel = $cs_phone ? preg_replace( '/[^0-9+]/', '', $cs_phone ) : '';
$cs_updated   = '21 tháng 10 năm 2026';
$cs_site      = home_url( '/' );

$cs_sections = array(
	array(
		'id'    => 'gioi-thieu',
		'title' => 'Giới thiệu',
	),
	array(
		'id'    => 'pham-vi',
		'title' => 'Phạm vi áp dụng',
	),
	array(
		'id'    => 'du-lieu',
		'title' => 'Dữ liệu chúng tôi thu thập',
	),
	array(
		'id'    => 'muc-dich',
		'title' => 'Mục đích xử lý',
	),
	array(
		'id'    => 'co-so',
		'title' => 'Cơ sở xử lý',
	),
	array(
		'id'    => 'chia-se',
		'title' => 'Chia sẻ dữ liệu',
	),
	array(
		'id'    => 'cookie',
		'title' => 'Cookie và công nghệ tương tự',
	),
	array(
		'id'    => 'luu-tru',
		'title' => 'Thời gian lưu trữ',
	),
	array(
		'id'    => 'bao-mat',
		'title' => 'Biện pháp bảo mật',
	),
	array(
		'id'    => 'quyen',
		'title' => 'Quyền của bạn',
	),
	array(
		'id'    => 'tre-em',
		'title' => 'Dữ liệu của trẻ em',
	),
	array(
		'id'    => 'ben-thu-ba',
		'title' => 'Liên kết bên thứ ba',
	),
	array(
		'id'    => 'cap-nhat',
		'title' => 'Cập nhật chính sách',
	),
	array(
		'id'    => 'lien-he',
		'title' => 'Liên hệ về dữ liệu cá nhân',
	),
);

get_header();
?>

<main id="main" class="site-main">

	<section class="relative flex min-h-[42vh] items-end overflow-hidden pt-24 md:min-h-[52vh]" data-section="cs-hero" data-dark-hero>
		<div class="absolute inset-0">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'full', array( 'class' => 'h-full w-full object-cover', 'alt' => '' ) ); ?>
			<?php else : ?>
				<div class="h-full w-full bg-gradient-to-br from-brand-900 via-ink to-brand-800"></div>
			<?php endif; ?>
			<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-black/40"></div>
		</div>
		<div class="container-lx relative z-10 pb-10 text-white md:pb-14">
			<nav class="mb-4 flex flex-wrap items-center gap-2 text-xs uppercase tracking-[0.18em] text-white/75" aria-label="breadcrumb" data-reveal>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="transition-colors hover:text-white"><?php esc_html_e( 'Trang chủ', 'nongnghiepnhietdoi' ); ?></a>
				<span aria-hidden="true" class="text-brand-200">/</span>
				<span class="text-brand-200"><?php esc_html_e( 'Chính sách bảo mật', 'nongnghiepnhietdoi' ); ?></span>
			</nav>
			<h1 class="max-w-3xl text-3xl font-bold leading-tight md:text-4xl lg:text-5xl" data-reveal><?php esc_html_e( 'Chính sách bảo mật', 'nongnghiepnhietdoi' ); ?></h1>
			<p class="mt-4 max-w-2xl text-base leading-relaxed text-white/80 md:text-lg" data-reveal>
				<?php echo esc_html( $cs_company ); ?> cam kết bảo vệ dữ liệu cá nhân khi bạn sử dụng website và liên hệ hợp tác với chúng tôi.
			</p>
			<p class="mt-4 text-sm text-white/60" data-reveal><?php echo esc_html( 'Cập nhật lần cuối: ' . $cs_updated ); ?></p>
		</div>
	</section>

	<section class="bg-bone py-14 md:py-20" data-section="chinh-sach-bao-mat">
		<div class="container-lx grid gap-10 lg:grid-cols-[260px_minmax(0,1fr)] lg:gap-14">

			<aside class="lg:sticky lg:top-28 lg:self-start" data-reveal>
				<p class="text-xs font-semibold uppercase tracking-[0.18em] text-brand"><?php esc_html_e( 'Mục lục', 'nongnghiepnhietdoi' ); ?></p>
				<nav class="mt-4" aria-label="<?php esc_attr_e( 'Mục lục chính sách bảo mật', 'nongnghiepnhietdoi' ); ?>">
					<ol class="space-y-1.5 border-l border-brand/20">
						<?php foreach ( $cs_sections as $index => $section ) : ?>
							<li>
								<a class="block border-l-2 border-transparent py-1.5 pl-4 text-sm leading-snug text-neutral-600 transition-colors hover:border-brand hover:text-brand-800" href="#<?php echo esc_attr( $section['id'] ); ?>">
									<span class="mr-1.5 text-neutral-400"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
									<?php echo esc_html( $section['title'] ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ol>
				</nav>
			</aside>

			<article class="min-w-0 space-y-12 text-neutral-700">

				<section id="gioi-thieu" class="scroll-mt-28" data-reveal>
					<h2 class="text-2xl font-bold text-neutral-900 md:text-3xl">1. Giới thiệu</h2>
					<div class="mt-4 space-y-4 leading-relaxed">
						<p>
							Chính sách này giải thích cách <strong class="font-semibold text-neutral-900"><?php echo esc_html( $cs_company ); ?></strong>
							<?php if ( $cs_short ) : ?>
								(<?php echo esc_html( $cs_short ); ?>)
							<?php endif; ?>
							thu thập, sử dụng, lưu trữ và bảo vệ dữ liệu cá nhân khi bạn truy cập website
							<a class="font-medium text-brand-700 underline decoration-brand/30 underline-offset-2 hover:text-brand-800" href="<?php echo esc_url( $cs_site ); ?>"><?php echo esc_html( wp_parse_url( $cs_site, PHP_URL_HOST ) ); ?></a>.
						</p>
						<p>
							<?php echo esc_html( $cs_short ); ?> là đơn vị nghiên cứu, tư vấn và chuyển giao trong lĩnh vực nông nghiệp nhiệt đới. Chúng tôi chỉ xử lý dữ liệu cá nhân ở mức cần thiết để trả lời yêu cầu, duy trì hợp tác và vận hành website an toàn.
						</p>
					</div>
				</section>

				<section id="pham-vi" class="scroll-mt-28" data-reveal>
					<h2 class="text-2xl font-bold text-neutral-900 md:text-3xl">2. Phạm vi áp dụng</h2>
					<div class="mt-4 space-y-4 leading-relaxed">
						<p>Chính sách áp dụng với mọi người truy cập website, gồm:</p>
						<ul class="list-disc space-y-2 pl-5">
							<li>Khách truy cập các trang thông tin, dự án, tin tức và thư viện.</li>
							<li>Người gửi form liên hệ hoặc form đăng ký tư vấn, hợp tác.</li>
							<li>Người đăng ký nhận bản tin ở chân trang.</li>
							<li>Đối tác, nhà tài trợ, nhà nghiên cứu và cơ quan liên hệ với <?php echo esc_html( $cs_short ); ?> qua website.</li>
						</ul>
						<p>
							Chính sách không điều chỉnh các website, mạng xã hội hoặc dịch vụ của bên thứ ba mà bạn mở từ liên kết trên trang này. Những nền tảng đó có chính sách riêng.
						</p>
					</div>
				</section>

				<section id="du-lieu" class="scroll-mt-28" data-reveal>
					<h2 class="text-2xl font-bold text-neutral-900 md:text-3xl">3. Dữ liệu chúng tôi thu thập</h2>
					<div class="mt-4 space-y-6 leading-relaxed">
						<div>
							<h3 class="text-lg font-semibold text-neutral-900">3.1. Dữ liệu bạn cung cấp</h3>
							<p class="mt-2">Khi bạn chủ động gửi thông tin, chúng tôi có thể nhận:</p>
							<ul class="mt-3 list-disc space-y-2 pl-5">
								<li><strong class="font-semibold text-neutral-900">Form liên hệ:</strong> họ tên, số điện thoại, email và nội dung tin nhắn.</li>
								<li><strong class="font-semibold text-neutral-900">Form đăng ký tư vấn hoặc hợp tác:</strong> họ tên, email, số điện thoại, nhu cầu tư vấn và thông tin mô tả công việc bạn chọn hoặc ghi.</li>
								<li><strong class="font-semibold text-neutral-900">Đăng ký bản tin:</strong> địa chỉ email.</li>
							</ul>
							<p class="mt-3">Bạn không bắt buộc phải cung cấp mọi trường. Nếu thiếu họ tên hoặc email ở các form có đánh dấu bắt buộc, chúng tôi không thể phản hồi đúng yêu cầu.</p>
						</div>
						<div>
							<h3 class="text-lg font-semibold text-neutral-900">3.2. Dữ liệu thu tự động</h3>
							<p class="mt-2">Khi bạn duyệt website, máy chủ và trình duyệt có thể ghi lại dữ liệu kỹ thuật như địa chỉ IP, loại trình duyệt, hệ điều hành, thời điểm truy cập, trang đã xem và địa chỉ trang giới thiệu. Dữ liệu này giúp website hoạt động, phát hiện lỗi và ngăn truy cập trái phép.</p>
						</div>
						<div>
							<h3 class="text-lg font-semibold text-neutral-900">3.3. Dữ liệu chúng tôi không chủ đích thu thập</h3>
							<p class="mt-2">Website không yêu cầu số định danh cá nhân, thông tin tài khoản ngân hàng, dữ liệu sức khỏe, dữ liệu sinh trắc học hay dữ liệu nhạy cảm khác. Vui lòng không gửi những thông tin đó trong nội dung tin nhắn, trừ khi pháp luật hoặc một thỏa thuận hợp tác cụ thể yêu cầu và bạn đã được thông báo riêng.</p>
						</div>
					</div>
				</section>

				<section id="muc-dich" class="scroll-mt-28" data-reveal>
					<h2 class="text-2xl font-bold text-neutral-900 md:text-3xl">4. Mục đích xử lý</h2>
					<div class="mt-4 leading-relaxed">
						<p>Chúng tôi dùng dữ liệu cá nhân để:</p>
						<ul class="mt-3 list-disc space-y-2 pl-5">
							<li>Tiếp nhận, trả lời và theo dõi yêu cầu liên hệ, tư vấn hoặc hợp tác dự án.</li>
							<li>Gửi thông tin bạn đã yêu cầu về hoạt động nghiên cứu, sự kiện, ấn phẩm hoặc cơ hội hợp tác.</li>
							<li>Quản lý hồ sơ trao đổi với đối tác, nhà tài trợ và cơ quan đặt hàng.</li>
							<li>Vận hành, bảo mật và cải thiện website, gồm thống kê kỹ thuật ở mức cần thiết.</li>
							<li>Lưu bằng chứng giao dịch liên quan khi pháp luật về lưu trữ, kế toán hoặc giải quyết tranh chấp yêu cầu.</li>
						</ul>
						<p class="mt-4">Chúng tôi không bán dữ liệu cá nhân và không dùng dữ liệu form để gửi quảng cáo của bên thứ ba.</p>
					</div>
				</section>

				<section id="co-so" class="scroll-mt-28" data-reveal>
					<h2 class="text-2xl font-bold text-neutral-900 md:text-3xl">5. Cơ sở xử lý</h2>
					<div class="mt-4 space-y-4 leading-relaxed">
						<p>Việc xử lý dựa trên một hoặc nhiều căn cứ sau, tùy từng trường hợp:</p>
						<ul class="list-disc space-y-2 pl-5">
							<li><strong class="font-semibold text-neutral-900">Sự đồng ý của bạn</strong> khi gửi form, đăng ký bản tin hoặc tiếp tục sử dụng website sau khi đã được thông báo về chính sách này.</li>
							<li><strong class="font-semibold text-neutral-900">Thực hiện yêu cầu trước hợp đồng hoặc hợp đồng</strong> khi bạn đề nghị tư vấn, hợp tác hoặc tham gia một dự án.</li>
							<li><strong class="font-semibold text-neutral-900">Nghĩa vụ pháp lý</strong> khi cơ quan nhà nước có thẩm quyền yêu cầu cung cấp hoặc khi luật định nghĩa vụ lưu trữ.</li>
							<li><strong class="font-semibold text-neutral-900">Lợi ích hợp pháp</strong> của <?php echo esc_html( $cs_short ); ?> trong việc bảo vệ hệ thống, ngăn spam và giữ liên lạc ở mức hợp lý với người đã chủ động liên hệ.</li>
						</ul>
						<p>Bạn có thể rút lại sự đồng ý bất cứ lúc nào. Việc rút lại không ảnh hưởng đến tính hợp pháp của xử lý đã thực hiện trước đó, và có thể khiến chúng tôi không tiếp tục cung cấp đúng nội dung bạn đã yêu cầu.</p>
					</div>
				</section>

				<section id="chia-se" class="scroll-mt-28" data-reveal>
					<h2 class="text-2xl font-bold text-neutral-900 md:text-3xl">6. Chia sẻ dữ liệu</h2>
					<div class="mt-4 space-y-4 leading-relaxed">
						<p>Dữ liệu chỉ được chia sẻ khi cần cho các mục đích ở mục 4, với:</p>
						<ul class="list-disc space-y-2 pl-5">
							<li>Cán bộ, chuyên viên của <?php echo esc_html( $cs_short ); ?> được phân công xử lý yêu cầu.</li>
							<li>Nhà cung cấp hạ tầng lưu trữ website, thư điện tử và dịch vụ kỹ thuật, trong phạm vi vận hành hệ thống.</li>
							<li>Cơ quan nhà nước có thẩm quyền khi có yêu cầu hợp pháp.</li>
							<li>Đối tác dự án, chỉ khi việc chia sẻ là cần thiết để thực hiện yêu cầu hợp tác và bạn đã được thông báo hoặc đã đồng ý.</li>
						</ul>
						<p>Trang Liên hệ có thể nhúng bản đồ Google Maps. Khi bản đồ được tải, Google có thể nhận dữ liệu kỹ thuật theo chính sách của Google. Các nút mạng xã hội chỉ đưa bạn sang nền tảng tương ứng khi bạn bấm vào; chúng tôi không chuyển nội dung form sang các nền tảng đó.</p>
					</div>
				</section>

				<section id="cookie" class="scroll-mt-28" data-reveal>
					<h2 class="text-2xl font-bold text-neutral-900 md:text-3xl">7. Cookie và công nghệ tương tự</h2>
					<div class="mt-4 space-y-4 leading-relaxed">
						<p>Website dùng cookie và bộ nhớ trình duyệt ở mức cần thiết để:</p>
						<ul class="list-disc space-y-2 pl-5">
							<li>Ghi nhớ phiên làm việc và bảo vệ form khỏi gửi tự động.</li>
							<li>Giữ trạng thái giao diện, ví dụ vị trí cuộn hoặc hộp thoại đã đóng trong phiên truy cập.</li>
							<li>Cho phép khu vực quản trị hoạt động nếu bạn là người được cấp tài khoản.</li>
						</ul>
						<p>Hiện website không gắn công cụ quảng cáo hay theo dõi hành vi liên trang của bên thứ ba trong giao diện công khai. Nếu sau này chúng tôi bổ sung công cụ đo lường, chính sách này sẽ được cập nhật trước khi công cụ đó xử lý dữ liệu nhận diện bạn.</p>
						<p>Bạn có thể chặn hoặc xóa cookie trong trình duyệt. Một số chức năng, nhất là form và trang quản trị, có thể không hoạt động đúng nếu cookie bị tắt hoàn toàn.</p>
					</div>
				</section>

				<section id="luu-tru" class="scroll-mt-28" data-reveal>
					<h2 class="text-2xl font-bold text-neutral-900 md:text-3xl">8. Thời gian lưu trữ</h2>
					<div class="mt-4 leading-relaxed">
						<ul class="list-disc space-y-2 pl-5">
							<li><strong class="font-semibold text-neutral-900">Yêu cầu liên hệ và tư vấn:</strong> lưu trong thời gian cần để phản hồi và theo dõi hợp tác, thường không quá 24 tháng kể từ lần trao đổi cuối, trừ khi hai bên đang thực hiện dự án hoặc bạn yêu cầu xóa sớm hơn.</li>
							<li><strong class="font-semibold text-neutral-900">Email bản tin:</strong> lưu cho đến khi bạn hủy đăng ký hoặc yêu cầu xóa.</li>
							<li><strong class="font-semibold text-neutral-900">Nhật ký kỹ thuật:</strong> lưu trong thời gian nhà cung cấp máy chủ và <?php echo esc_html( $cs_short ); ?> cần để bảo mật, thường theo chu kỳ xoay vòng nhật ký của hệ thống.</li>
							<li><strong class="font-semibold text-neutral-900">Hồ sơ phải lưu theo luật:</strong> giữ đúng thời hạn pháp luật quy định, kể cả khi bạn đã yêu cầu xóa phần còn lại.</li>
						</ul>
						<p class="mt-4">Hết thời hạn, dữ liệu được xóa hoặc ẩn danh sao cho không còn xác định được bạn.</p>
					</div>
				</section>

				<section id="bao-mat" class="scroll-mt-28" data-reveal>
					<h2 class="text-2xl font-bold text-neutral-900 md:text-3xl">9. Biện pháp bảo mật</h2>
					<div class="mt-4 space-y-4 leading-relaxed">
						<p>Chúng tôi áp dụng các biện pháp tổ chức và kỹ thuật phù hợp với quy mô website, gồm:</p>
						<ul class="list-disc space-y-2 pl-5">
							<li>Truyền dữ liệu form qua kết nối mã hóa HTTPS.</li>
							<li>Giới hạn quyền xem hồ sơ liên hệ trong khu vực quản trị, không công khai trên website.</li>
							<li>Kiểm tra chống gửi tự động trên form.</li>
							<li>Chỉ cấp tài khoản quản trị cho người có nhiệm vụ.</li>
						</ul>
						<p>Không có phương thức truyền hoặc lưu trữ nào an toàn tuyệt đối. Nếu phát hiện sự cố ảnh hưởng dữ liệu cá nhân, chúng tôi sẽ đánh giá, khắc phục và thông báo theo quy định pháp luật hiện hành.</p>
					</div>
				</section>

				<section id="quyen" class="scroll-mt-28" data-reveal>
					<h2 class="text-2xl font-bold text-neutral-900 md:text-3xl">10. Quyền của bạn</h2>
					<div class="mt-4 space-y-4 leading-relaxed">
						<p>Theo pháp luật Việt Nam về bảo vệ dữ liệu cá nhân, bạn có thể:</p>
						<ul class="list-disc space-y-2 pl-5">
							<li>Được biết về hoạt động xử lý dữ liệu của mình.</li>
							<li>Đồng ý hoặc không đồng ý, và rút lại sự đồng ý.</li>
							<li>Xem, chỉnh sửa dữ liệu chưa chính xác.</li>
							<li>Yêu cầu xóa, hạn chế xử lý hoặc phản đối việc xử lý trong các trường hợp luật cho phép.</li>
							<li>Yêu cầu cung cấp dữ liệu của mình.</li>
							<li>Khiếu nại với <?php echo esc_html( $cs_short ); ?> và với cơ quan nhà nước có thẩm quyền, đồng thời yêu cầu bồi thường thiệt hại theo luật nếu quyền của bạn bị xâm phạm.</li>
						</ul>
						<p>
							Gửi yêu cầu qua email
							<?php if ( $cs_email ) : ?>
								<a class="font-medium text-brand-700 underline decoration-brand/30 underline-offset-2 hover:text-brand-800" href="mailto:<?php echo esc_attr( $cs_email ); ?>"><?php echo esc_html( $cs_email ); ?></a>
							<?php else : ?>
								liên hệ ở mục 14
							<?php endif; ?>
							với tiêu đề “Yêu cầu dữ liệu cá nhân”. Vui lòng nêu rõ họ tên, email hoặc số điện thoại đã dùng trên website và nội dung yêu cầu. Chúng tôi có thể cần xác minh bạn là chủ thể dữ liệu trước khi thực hiện.
						</p>
						<p>Chúng tôi phản hồi trong thời hạn pháp luật quy định. Một số dữ liệu có thể được giữ lại nếu còn nghĩa vụ lưu trữ hoặc cần để lập, thực thi hay bảo vệ yêu cầu pháp lý.</p>
					</div>
				</section>

				<section id="tre-em" class="scroll-mt-28" data-reveal>
					<h2 class="text-2xl font-bold text-neutral-900 md:text-3xl">11. Dữ liệu của trẻ em</h2>
					<p class="mt-4 leading-relaxed">
						Website hướng tới cơ quan, doanh nghiệp, nhà nghiên cứu, đối tác và người quan tâm đến nông nghiệp nhiệt đới. Chúng tôi không chủ đích thu thập dữ liệu của trẻ em. Nếu bạn là cha, mẹ hoặc người giám hộ và phát hiện trẻ đã gửi dữ liệu cá nhân cho chúng tôi, hãy liên hệ để chúng tôi xóa thông tin đó.
					</p>
				</section>

				<section id="ben-thu-ba" class="scroll-mt-28" data-reveal>
					<h2 class="text-2xl font-bold text-neutral-900 md:text-3xl">12. Liên kết bên thứ ba</h2>
					<p class="mt-4 leading-relaxed">
						Website có liên kết tới mạng xã hội, bản đồ và trang của đối tác. Khi bạn rời <?php echo esc_html( wp_parse_url( $cs_site, PHP_URL_HOST ) ); ?>, việc xử lý dữ liệu do bên đó quyết định. Hãy đọc chính sách của nền tảng trước khi cung cấp thông tin.
					</p>
				</section>

				<section id="cap-nhat" class="scroll-mt-28" data-reveal>
					<h2 class="text-2xl font-bold text-neutral-900 md:text-3xl">13. Cập nhật chính sách</h2>
					<p class="mt-4 leading-relaxed">
						Chúng tôi có thể sửa chính sách khi website, quy trình hợp tác hoặc pháp luật thay đổi. Bản mới được đăng tại trang này và ghi ngày cập nhật ở đầu trang. Với thay đổi làm mở rộng đáng kể mục đích xử lý, chúng tôi sẽ xin lại sự đồng ý khi pháp luật yêu cầu. Việc bạn tiếp tục dùng website sau khi chính sách được đăng nghĩa là bạn đã biết bản cập nhật.
					</p>
				</section>

				<section id="lien-he" class="scroll-mt-28" data-reveal>
					<h2 class="text-2xl font-bold text-neutral-900 md:text-3xl">14. Liên hệ về dữ liệu cá nhân</h2>
					<p class="mt-4 leading-relaxed">Mọi câu hỏi về chính sách này hoặc về dữ liệu cá nhân của bạn, vui lòng liên hệ:</p>
					<div class="mt-6 rounded-2xl border border-brand/15 bg-white p-6 shadow-sm md:p-8">
						<p class="text-lg font-semibold text-neutral-900"><?php echo esc_html( $cs_company ); ?></p>
						<?php if ( $cs_short ) : ?>
							<p class="mt-1 text-sm font-medium uppercase tracking-[0.16em] text-brand"><?php echo esc_html( $cs_short ); ?></p>
						<?php endif; ?>
						<dl class="mt-5 space-y-3 text-sm leading-relaxed">
							<?php if ( $cs_address ) : ?>
								<div>
									<dt class="font-semibold text-neutral-900">Địa chỉ</dt>
									<dd class="mt-0.5"><?php echo nl2br( esc_html( $cs_address ) ); ?></dd>
								</div>
							<?php endif; ?>
							<?php if ( $cs_email ) : ?>
								<div>
									<dt class="font-semibold text-neutral-900">Email</dt>
									<dd class="mt-0.5"><a class="text-brand-700 underline decoration-brand/30 underline-offset-2 hover:text-brand-800" href="mailto:<?php echo esc_attr( $cs_email ); ?>"><?php echo esc_html( $cs_email ); ?></a></dd>
								</div>
							<?php endif; ?>
							<?php if ( $cs_phone ) : ?>
								<div>
									<dt class="font-semibold text-neutral-900">Điện thoại</dt>
									<dd class="mt-0.5"><a class="text-brand-700 underline decoration-brand/30 underline-offset-2 hover:text-brand-800" href="tel:<?php echo esc_attr( $cs_phone_tel ); ?>"><?php echo esc_html( $cs_phone ); ?></a></dd>
								</div>
							<?php endif; ?>
							<?php if ( $cs_hours ) : ?>
								<div>
									<dt class="font-semibold text-neutral-900">Giờ làm việc</dt>
									<dd class="mt-0.5"><?php echo esc_html( $cs_hours ); ?></dd>
								</div>
							<?php endif; ?>
						</dl>
					</div>
				</section>

			</article>
		</div>
	</section>
</main>

<?php
get_footer();
