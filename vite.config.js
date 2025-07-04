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
      '~': '/resources',
    },
  },
  server: {
    host: '0.0.0.0',
    port: process.env.PORT || 3000,
    hmr: {
      host: 'localhost',
      protocol: 'ws',
    },
    strictPort: true,
  },
  preview: {
    host: '0.0.0.0',
    port: process.env.PORT || 3000,
    allowedHosts: [
      'nail-appointment.onrender.com',
      'localhost'
    ]
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
    chunkSizeWarningLimit: 1600,
  }
});