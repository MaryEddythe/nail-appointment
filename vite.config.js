import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js'
      ],
      refresh: [
        'resources/views/**',
        'routes/**',
      ],
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
  ],
  resolve: {
    alias: {
      '@': '/resources/js',
      '~': '/resources', // Additional alias
    },
  },
  server: {
    host: '0.0.0.0',
    port: process.env.PORT || 3000,
    hmr: {
      host: 'localhost',
    },
    strictPort: true, // Critical for Render
  },
  build: {
    manifest: true,
    rollupOptions: {
      output: {
        manualChunks: {
          vendor: ['vue', '@inertiajs/vue3'],
          datefns: ['date-fns'],
        },
      },
    },
    chunkSizeWarningLimit: 1600, // For larger apps
},
});