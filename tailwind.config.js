import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './**/*.php',
    './index.html',
    './src/**/*.{vue,js,ts}',
    '!./node_modules/**',
    '!./dist/**',
    '!./vendor/**',
  ],
  theme: {
    container: {
      center: true,
      padding: {
        DEFAULT: '1rem',
        sm: '1.5rem',
        lg: '2rem',
        xl: '2.5rem',
      },
    },
    screens: {
      sm: '640px', // mobile landscape
      md: '768px', // tablet portrait
      lg: '1024px', // tablet landscape / small laptop
      xl: '1280px', // laptop
      '2xl': '1536px', // desktop
    },
    extend: {
      colors: {
        brand: {
          DEFAULT: '#009C48',
          50: '#e7f8ee',
          100: '#c5edd4',
          200: '#8ed9ad',
          300: '#4ec07e',
          400: '#1aad5b',
          500: '#009C48',
          600: '#00843d',
          700: '#006b32',
          800: '#005428',
          900: '#06351f',
        },
        sun: {
          DEFAULT: '#F07818',
          50: '#fff4ea',
          500: '#F07818',
          600: '#d8660d',
        },
        ink: '#0B1F33',
        'forest-ink': '#009C48',
        'vivid-lime': '#e8fe85',
        bone: '#f4f7f5',
        'ash-gray': '#efefef',
        charcoal: '#212529',
        graphite: '#353535',
        pewter: '#6d6d6d',
        'sky-card': '#b2cee7',
        'peach-card': '#fceace',
        'sage-card': '#e6ecd5',
        moss: '#c3cda7',
      },
      fontFamily: {
        sans: ['Be Vietnam Pro', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        serif: ['Be Vietnam Pro', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        inter: ['Be Vietnam Pro', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        reckless: ['Be Vietnam Pro', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      fontSize: {
        caption: ['12px', { lineHeight: '1.5', letterSpacing: '0.025em' }],
        'body-sm': ['14px', { lineHeight: '1.5', letterSpacing: '0.025em' }],
        body: ['16px', { lineHeight: '1.52', letterSpacing: '-0.022em' }],
        subheading: ['24px', { lineHeight: '1.24', letterSpacing: '-0.012em' }],
        'heading-sm': ['37px', { lineHeight: '1.22', letterSpacing: '-0.012em' }],
        heading: ['45px', { lineHeight: '1.06', letterSpacing: '-0.012em' }],
        'heading-lg': ['57px', { lineHeight: '1.06', letterSpacing: '-0.012em' }],
        display: ['80px', { lineHeight: '1', letterSpacing: '-0.037em' }],
      },
      borderRadius: {
        card: '20px',
        link: '26px',
        input: '33px',
        button: '100px',
        'nav-pill': '110px',
        'hero-card': '30px',
      },
      maxWidth: {
        page: '1200px',
      },
    },
  },
  plugins: [typography],
};
