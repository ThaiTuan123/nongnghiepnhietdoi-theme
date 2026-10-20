<?php
/**
 * Homepage sections for VARC.
 *
 * @package NongNghiepNhietDoi
 */

$img       = NONGNGHIEPNHIETDOI_URI . '/assets/images';
$hero_mp4  = NONGNGHIEPNHIETDOI_DIR . '/assets/video/hero.mp4';
$has_video = file_exists( $hero_mp4 );
?>

<section class="relative isolate min-h-[100svh] overflow-hidden bg-ink text-white">
	<?php if ( $has_video ) : ?>
		<video class="hero-video absolute inset-0 h-full w-full object-cover" autoplay muted loop playsinline poster="<?php echo esc_url( $img . '/hero-field.jpg' ); ?>">
			<source src="<?php echo esc_url( NONGNGHIEPNHIETDOI_URI . '/assets/video/hero.mp4' ); ?>" type="video/mp4">
		</video>
	<?php else : ?>
		<img src="<?php echo esc_url( $img . '/hero-field.jpg' ); ?>" alt="" class="absolute inset-0 h-full w-full object-cover" width="2000" height="1125">
	<?php endif; ?>
	<div class="absolute inset-0 bg-gradient-to-l from-black/55 via-black/15 to-black/10"></div>
	<div class="relative mx-auto flex min-h-[100svh] w-full max-w-[1360px] items-end px-4 pb-14 pt-28 sm:items-center sm:px-6 sm:pb-0 lg:justify-end lg:px-8" data-reveal>
		<div class="w-full max-w-[560px]">
			<p class="mb-5 inline-flex w-fit items-center rounded-full border border-white/45 bg-white/10 px-4 py-1.5 text-sm text-white/95 backdrop-blur-sm">Nghiên cứu &amp; tư vấn</p>
			<h1 class="font-sans text-[2rem] font-bold leading-[1.08] tracking-tight text-white sm:text-5xl lg:text-[56px]">Tiên phong nông nghiệp thích ứng khí hậu</h1>
			<p class="mt-5 max-w-md text-sm leading-relaxed text-white/90 sm:text-base">Chuyển hóa công nghệ vi sinh, xử lý môi trường và đo lường phát thải thành sinh kế bền vững cho nông dân Việt Nam.</p>
			<a href="#lien-he" class="varc-cta mt-8 inline-flex items-center gap-3 rounded-full bg-brand py-2 pl-6 pr-2 text-sm font-semibold text-white hover:bg-brand-700">
				<?php esc_html_e( 'Hợp tác dự án', 'nongnghiepnhietdoi' ); ?>
				<span class="varc-cta-icon inline-flex h-10 w-10 items-center justify-center rounded-full bg-sun text-white" aria-hidden="true">
					<svg class="h-4 w-4" viewBox="0 0 16 16" fill="none"><path d="M4 12 12 4M6 4h6v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</span>
			</a>
		</div>
	</div>
</section>

<section class="bg-brand text-white" aria-label="<?php esc_attr_e( 'Số liệu', 'nongnghiepnhietdoi' ); ?>">
	<div class="mx-auto grid max-w-[1200px] grid-cols-2 gap-6 px-4 py-8 lg:grid-cols-4" data-reveal-stagger>
		<?php
		$stats = array(
			array( '25', '+', 'Chuyên gia & nhà khoa học cố vấn', false ),
			array( '10000', '+', 'Hợp tác xã & nông dân trong mạng lưới', true ),
			array( '40', '+', 'Mô hình vi sinh & CSA đã triển khai', false ),
			array( '15', '+', 'Tỉnh/thành có hoạt động triển khai', false ),
		);
		foreach ( $stats as $stat ) :
			?>
			<div class="text-center">
				<p class="text-2xl font-bold sm:text-3xl" data-count="<?php echo esc_attr( $stat[0] ); ?>" data-count-suffix="<?php echo esc_attr( $stat[1] ); ?>" <?php echo $stat[3] ? 'data-count-group' : ''; ?>><?php echo esc_html( ( $stat[3] ? '10.000' : $stat[0] ) . $stat[1] ); ?></p>
				<p class="mt-1 text-xs text-white/85 sm:text-sm"><?php echo esc_html( $stat[2] ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<section id="ve-varc" class="scroll-mt-28 bg-white">
	<div class="mx-auto grid max-w-[1200px] items-center gap-8 px-4 py-12 md:py-16 lg:grid-cols-2">
		<div class="overflow-hidden rounded-3xl" data-reveal="image">
			<div data-reveal-frame>
				<img src="<?php echo esc_url( $img . '/about-field.jpg' ); ?>" alt="Cánh đồng trong mạng lưới đồng hành của VARC" class="h-full max-h-[280px] w-full object-cover sm:max-h-[420px]" width="1400" height="934">
			</div>
		</div>
		<div data-reveal="right">
			<p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand">Về VARC</p>
			<h2 class="mt-3 font-sans text-3xl font-bold tracking-tight text-ink md:text-4xl">Trung tâm nghiên cứu khoa học</h2>
			<p class="mt-4 text-[16px] leading-relaxed text-slate-600">VARC là đầu mối nghiên cứu và tư vấn nông nghiệp nhiệt đới: đưa công nghệ vi sinh, nông nghiệp thích ứng khí hậu và đo lường phát thải ra đồng ruộng, để nông hộ có sinh kế ổn định hơn và doanh nghiệp có chuỗi cung ứng sạch hơn.</p>
			<ul class="mt-6 space-y-3 text-sm text-slate-700">
				<li class="flex gap-3"><span class="mt-1 h-2 w-2 shrink-0 rounded-full bg-sun"></span>Nghiên cứu ứng dụng gắn với hiện trường, không dừng ở phòng thí nghiệm.</li>
				<li class="flex gap-3"><span class="mt-1 h-2 w-2 shrink-0 rounded-full bg-brand"></span>Đồng hành hợp tác xã, doanh nghiệp và cơ quan quản lý trong cùng một mạng lưới.</li>
				<li class="flex gap-3"><span class="mt-1 h-2 w-2 shrink-0 rounded-full bg-brand-700"></span>Đo được tác động: năng suất, sinh kế và phát thải khí nhà kính.</li>
			</ul>
		</div>
	</div>
</section>

<section id="nang-luc" class="scroll-mt-28">
	<div class="mx-auto max-w-[1200px] px-4 py-12 md:py-16">
		<p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand">Năng lực khác biệt</p>
		<h2 data-reveal class="mt-3 max-w-2xl font-sans text-3xl font-bold tracking-tight text-ink md:text-4xl">Khoa học ra đồng, đo được kết quả</h2>
		<div class="mt-8 grid gap-4 sm:mt-10 sm:grid-cols-2 sm:gap-5 lg:grid-cols-4" data-reveal-stagger>
			<?php
			$caps = array(
				array( '01', 'Vi sinh bản địa', 'Phân lập, nhân sinh khối và chuyển giao chế phẩm IMO phù hợp đất và cây của từng vùng.' ),
				array( '02', 'Hiện trường CSA', 'Thiết kế mô hình nông nghiệp thông minh với khí hậu, theo mùa vụ và quy mô hợp tác xã.' ),
				array( '03', 'Đo phát thải', 'Phương pháp đo lường phát thải khí nhà kính để đối chiếu trước và sau can thiệp.' ),
				array( '04', 'Chuyển giao', 'Tập huấn nông hộ, sổ tay kỹ thuật và đồng hành sau khi mô hình được bàn giao.' ),
			);
			foreach ( $caps as $cap ) :
				?>
				<article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
					<p class="text-sm font-bold text-sun"><?php echo esc_html( $cap[0] ); ?></p>
					<h3 class="mt-3 font-sans text-lg font-bold text-ink"><?php echo esc_html( $cap[1] ); ?></h3>
					<p class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $cap[2] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section id="linh-vuc" class="scroll-mt-28 bg-white">
	<div class="mx-auto max-w-[1200px] px-4 py-12 md:py-16">
		<p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand">Lĩnh vực hoạt động</p>
		<h2 data-reveal class="mt-3 font-sans text-3xl font-bold tracking-tight text-ink md:text-4xl">Sáu nhóm việc VARC đang làm</h2>
		<div class="mt-8 grid gap-4 sm:mt-10 sm:grid-cols-2 lg:grid-cols-3" data-reveal-stagger>
			<?php
			$fields = array(
				array( 'Công nghệ vi sinh', 'Chế phẩm xử lý phụ phẩm, cải tạo đất và tăng sức chống chịu của cây trồng.' ),
				array( 'Thích ứng khí hậu', 'Mô hình CSA cho vùng nhiệt đới: nước, giống, lịch mùa và rủi ro thời tiết.' ),
				array( 'Xử lý môi trường', 'Ủ phân hữu cơ, giảm đốt phụ phẩm và xử lý ô nhiễm tại nông hộ.' ),
				array( 'Phát thải khí nhà kính', 'Đo, báo cáo và đề xuất biện pháp giảm phát thải trên đồng ruộng.' ),
				array( 'Đào tạo chuyển giao', 'Cẩm nang, tập huấn hiện trường và mạng lưới khuyến nông cộng đồng.' ),
				array( 'Tư vấn độc lập', 'Đánh giá dự án, đề tài khoa học công nghệ và chương trình quốc gia.' ),
			);
			foreach ( $fields as $field ) :
				?>
				<article class="rounded-2xl border border-slate-100 bg-bone p-6">
					<h3 class="font-sans text-lg font-bold text-ink"><?php echo esc_html( $field[0] ); ?></h3>
					<p class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $field[1] ); ?></p>
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
		<div class="mt-8 grid gap-4 sm:mt-10 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3" data-reveal-stagger>
			<?php
			$projects = array(
				array( 'Nhân sinh khối IMO tại nông hộ', 'Quy trình làm chế phẩm vi sinh bản địa từ phụ phẩm sẵn có, cho hợp tác xã tự nhân và sử dụng.' ),
				array( 'Mô hình CSA giảm phát thải', 'Canh tác thích ứng khí hậu kết hợp đo phát thải trước và sau một vụ.' ),
				array( 'Ủ phân từ phụ phẩm cây trồng', 'Chuyển rơm rạ, thân bắp và vỏ cà phê thành phân hữu cơ thay vì đốt bỏ.' ),
			);
			foreach ( $projects as $i => $project ) :
				?>
				<article class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-100">
					<div class="h-40 bg-cover bg-center" style="background-image:linear-gradient(160deg,rgba(0,156,72,.82),rgba(6,53,31,.55)),url('<?php echo esc_url( $img . ( 1 === $i ? '/about-field.jpg' : '/hero-field.jpg' ) ); ?>')"></div>
					<div class="p-6">
						<h3 class="font-sans text-lg font-bold text-ink"><?php echo esc_html( $project[0] ); ?></h3>
						<p class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $project[1] ); ?></p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section id="con-nguoi" class="scroll-mt-28 bg-white">
	<div class="mx-auto max-w-[1200px] px-4 py-12 md:py-16">
		<p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand">Con người VARC</p>
		<h2 data-reveal class="mt-3 max-w-2xl font-sans text-3xl font-bold tracking-tight text-ink md:text-4xl">Nhà khoa học, kỹ thuật viên và người đứng trên ruộng</h2>
		<p class="mt-4 max-w-2xl text-slate-600">Đội ngũ VARC gồm chuyên gia cố vấn, cán bộ hiện trường và mạng lưới nông dân nòng cốt. Mỗi mô hình có người chịu trách nhiệm khoa học và người chịu trách nhiệm ngoài đồng.</p>
		<div class="mt-8 grid gap-4 sm:mt-10 md:grid-cols-3" data-reveal-stagger>
			<?php
			$people = array(
				array( 'Nhà khoa học cố vấn', 'Định hướng đề tài vi sinh, môi trường và phát thải; phản biện quy trình trước khi ra đồng.' ),
				array( 'Cán bộ hiện trường', 'Lắp đặt mô hình, tập huấn nông hộ và ghi nhận số liệu theo vụ.' ),
				array( 'Nông dân nòng cốt', 'Nhân chế phẩm, duy trì mô hình và lan tỏa trong hợp tác xã.' ),
			);
			foreach ( $people as $person ) :
				?>
				<article class="rounded-2xl bg-bone p-6">
					<div class="flex h-14 w-14 items-center justify-center rounded-full bg-brand text-lg font-bold text-white" aria-hidden="true"><?php echo esc_html( mb_substr( $person[0], 0, 1 ) ); ?></div>
					<h3 class="mt-4 font-sans text-lg font-bold text-ink"><?php echo esc_html( $person[0] ); ?></h3>
					<p class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $person[1] ); ?></p>
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

<section id="he-sinh-thai" class="scroll-mt-28 bg-ink text-white">
	<div class="mx-auto max-w-[1200px] px-4 py-12 md:py-16">
		<p class="text-xs font-semibold uppercase tracking-[0.16em] text-sun">Hệ sinh thái</p>
		<h2 data-reveal class="mt-3 max-w-2xl font-sans text-3xl font-bold tracking-tight md:text-4xl">VARC đứng giữa bốn nhóm đối tác</h2>
		<div class="mt-8 grid gap-4 sm:mt-10 sm:grid-cols-2 lg:grid-cols-4" data-reveal-stagger>
			<?php
			$eco = array(
				array( 'Nông hộ & HTX', 'Nơi mô hình được làm, đo và nhân rộng.' ),
				array( 'Nhà khoa học', 'Nguồn quy trình, phản biện và đào tạo.' ),
				array( 'Doanh nghiệp', 'Chuỗi tiêu thụ, chế phẩm và đồng tài trợ thử nghiệm.' ),
				array( 'Cơ quan quản lý', 'Chương trình ngành, đề tài và khung đo phát thải.' ),
			);
			foreach ( $eco as $node ) :
				?>
				<article class="rounded-2xl bg-white/5 p-6 ring-1 ring-white/10">
					<h3 class="font-sans text-lg font-bold"><?php echo esc_html( $node[0] ); ?></h3>
					<p class="mt-2 text-sm leading-relaxed text-white/70"><?php echo esc_html( $node[1] ); ?></p>
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
				<a href="#tin-tuc" class="text-sm font-semibold text-brand">Xem tất cả →</a>
			</div>
			<div class="mt-8 grid gap-4 sm:grid-cols-2 md:grid-cols-3" data-reveal-stagger>
				<?php
				$news = array(
					array( '24/08/2026', 'Cẩm nang: Nhân sinh khối chế phẩm vi sinh bản địa (IMO) tại nông hộ', 'Hướng dẫn chi tiết cách thu bắt và nhân sinh khối vi sinh vật bản địa ngay tại nông hộ.' ),
					array( '23/08/2026', 'VARC ký kết hợp tác nghiên cứu công nghệ vi sinh với đối tác doanh nghiệp', 'Lễ ký kết mở ra giai đoạn hợp tác nghiên cứu, thử nghiệm và thương mại hóa các chế phẩm vi sinh.' ),
					array( '22/08/2026', 'Cẩm nang: Ủ phân hữu cơ từ phụ phẩm nông nghiệp bằng chế phẩm vi sinh', 'Quy trình ủ nóng 40 ngày biến rơm rạ, thân bắp và vỏ cà phê thành phân hữu cơ.' ),
				);
				foreach ( $news as $post_item ) :
					?>
					<article class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-100">
						<div class="h-28 bg-gradient-to-br from-brand-700 to-brand"></div>
						<div class="p-4">
							<p class="text-xs text-slate-400"><?php echo esc_html( $post_item[0] ); ?></p>
							<h3 class="mt-2 font-sans text-[15px] font-bold leading-snug text-brand"><?php echo esc_html( $post_item[1] ); ?></h3>
							<p class="mt-2 line-clamp-3 text-sm text-slate-600"><?php echo esc_html( $post_item[2] ); ?></p>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
		<aside class="h-fit rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-100" data-reveal="right">
			<h3 class="font-sans text-base font-bold text-ink">Tài liệu mới</h3>
			<ul class="mt-4 space-y-4 text-sm">
				<li>
					<p class="font-semibold text-ink">Cẩm nang: Ứng dụng chế phẩm vi sinh xử lý môi trường trong nông hộ</p>
					<p class="text-xs text-slate-400">Cẩm nang kỹ thuật cho nông dân</p>
				</li>
				<li>
					<p class="font-semibold text-ink">Báo cáo chuyên đề: Phương pháp đo lường phát thải khí nhà kính</p>
					<p class="text-xs text-slate-400">Công trình nghiên cứu &amp; Báo cáo</p>
				</li>
			</ul>
			<a href="#tin-tuc" class="mt-5 flex justify-center rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-ink hover:border-brand hover:text-brand">Xem tất cả</a>
		</aside>
	</div>
</section>

<section class="bg-gradient-to-r from-[#06351f] to-brand text-white">
	<div class="mx-auto flex max-w-[1200px] flex-col items-start justify-between gap-6 px-4 py-10 md:flex-row md:items-center md:py-12" data-reveal>
		<div>
			<h2 class="font-sans text-2xl font-bold md:text-3xl">Cùng VARC kiến tạo nền nông nghiệp phát thải thấp</h2>
			<p class="mt-2 max-w-2xl text-sm text-white/80 md:text-base">Chúng tôi sẵn sàng đồng hành cùng các Quỹ quốc tế, Đại sứ quán, NGO, doanh nghiệp và cơ quan quản lý nhà nước.</p>
		</div>
		<a href="#lien-he" class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-semibold text-ink hover:bg-bone">Hợp tác dự án <span aria-hidden="true">→</span></a>
	</div>
</section>
