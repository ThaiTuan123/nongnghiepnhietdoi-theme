import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './**/*.php',
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
          DEFAULT: '#856a3d',
          50: '#f7f3ec',
          100: '#ece2d0',
          200: '#dcc9a6',
          300: '#c9ab77',
          400: '#a98a55',
          500: '#856a3d',
          600: '#6f5833',
          700: '#584627',
          800: '#43351d',
          900: '#2f2513',
        },
      },
      fontFamily: {
        sans: ['Montserrat', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        serif: ['Montserrat', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
    },
  },
  plugins: [typography],
};
