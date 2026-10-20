# Nông nghiệp nhiệt đới Theme

Theme WordPress cho **Nông nghiệp nhiệt đới**. Giữ nguyên stack của theme mẫu: Vue 3, Tailwind CSS, Vite, GSAP, Lenis và ACF Pro. Giao diện hiện tại là khung mẫu — nội dung và bố cục sẽ được chỉnh lại cho đúng dự án.

## Yêu cầu

- WordPress 6.x, PHP 8.x
- Plugin **ACF Pro** (bắt buộc, để dùng Flexible Content + Options page)
- Node.js 18+ (chỉ khi build frontend)

## Cài đặt frontend

```bash
cd wp-content/themes/nongnghiepnhietdoi
npm install
npm run build      # build production ra dist/
npm run dev        # dev server + HMR (Vite)
```

- `npm run build` tạo `dist/` + manifest; `functions.php` tự enqueue.
- `npm run dev` tạo `src/.hot`; theme tự nạp asset từ Vite dev server (`http://localhost:5173`). Dừng dev server sẽ tự xoá `.hot`.

## Lint & format

```bash
npm install
composer install   # cần PHP 8+ trên PATH (Local WP cũng được)

npm run format       # Prettier (JS/Vue/CSS/JSON/MD)
npm run lint         # ESLint (JS/Vue)
npm run lint:fix    # ESLint --fix
npm run lint:php     # PHPCS (WordPress Coding Standards)
npm run fix:php      # PHPCBF auto-fix PHP
npm run lint:all     # ESLint + Prettier check + PHPCS
```

Cấu hình: `.editorconfig`, `.prettierrc.json`, `eslint.config.js`, `phpcs.xml.dist`.

## Nội dung

1. Kích hoạt theme + ACF Pro. Field group tự nạp từ `acf-json/`.
2. Vào trang bất kỳ (hoặc "Trang chủ") → thêm các phần trong **"Nội dung trang (Sections)"**: Hero, Giới thiệu, Lĩnh vực, Dự án tiêu biểu, Tin tức, Liên hệ.
3. Thông tin liên hệ chung: **Nông nghiệp nhiệt đới → Cài đặt chung**.
4. Menu: **Giao diện → Menu**, gán vào vị trí _Menu chính_ / _Menu chân trang_ / _Mạng xã hội_.
5. "Trang chủ": Cài đặt → Đọc → Trang tĩnh, chọn trang làm Trang chủ.

## Cấu trúc

```
nongnghiepnhietdoi/
├─ acf-json/                 # ACF field groups (version control)
├─ inc/                      # setup, menus, enqueue, acf
├─ template-parts/sections/  # 1 file / 1 layout ACF
├─ src/                      # Vue, animations, styles (Vite)
│  ├─ animations/            # smoothScroll, reveal, parallax (GSAP + Lenis)
│  ├─ components/            # Vue islands
│  ├─ modules/               # header (menu, scrolled state)
│  └─ styles/app.css         # Tailwind + brand tokens
├─ front-page.php page.php single.php archive.php ...
└─ dist/                     # sinh ra bởi build (không commit)
```

## Màu thương hiệu

`#856a3d` → token Tailwind `brand` (`text-brand`, `bg-brand`, ...). Không hardcode hex trong markup.
