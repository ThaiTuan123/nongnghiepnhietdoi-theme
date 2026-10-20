import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import { writeFileSync, rmSync, existsSync } from 'node:fs';
import { resolve } from 'node:path';

const DEV_SERVER = 'http://localhost:5173';
const HOT_FILE = resolve(__dirname, 'src/.hot');

// Write/remove src/.hot so functions.php knows whether the dev server is running.
function wpHmr() {
  return {
    name: 'nongnghiepnhietdoi-wp-hmr',
    configureServer() {
      writeFileSync(HOT_FILE, DEV_SERVER);
      const clean = () => {
        if (existsSync(HOT_FILE)) rmSync(HOT_FILE);
      };
      process.on('SIGINT', () => {
        clean();
        process.exit();
      });
      process.on('SIGTERM', () => {
        clean();
        process.exit();
      });
      process.on('exit', clean);
    },
  };
}

export default defineConfig({
  plugins: [vue(), wpHmr()],
  base: process.env.NODE_ENV === 'development' ? '/' : '/wp-content/themes/nongnghiepnhietdoi/dist/',
  server: {
    host: 'localhost',
    port: 5173,
    strictPort: true,
    cors: true,
    origin: DEV_SERVER,
  },
  build: {
    manifest: true,
    outDir: 'dist',
    emptyOutDir: true,
    rollupOptions: {
      input: resolve(__dirname, 'src/main.js'),
    },
  },
  resolve: {
    alias: {
      '@': resolve(__dirname, 'src'),
    },
  },
});
