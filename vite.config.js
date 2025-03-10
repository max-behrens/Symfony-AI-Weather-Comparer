import { defineConfig } from 'vite';
import symfonyPlugin from 'vite-plugin-symfony';
// Keep your existing plugins if needed
import vue from '@vitejs/plugin-vue';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
  plugins: [
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
    react(),
    symfonyPlugin(),
  ],
  resolve: {
    alias: {
      // Update this path if your JS assets are in a different location
      '@': path.resolve(__dirname, 'assets/js'),
    }
  },
  build: {
    // Output to the Symfony public directory
    outDir: 'public/build',
    rollupOptions: {
      input: {
        // The main entry point for your application
        app: './assets/app.js',
        // Add additional entry points if needed
      },
      output: {
        manualChunks: {
          vendor: ['vue', 'react', 'react-dom'],
        },
      },
    },
    // Generate manifest for Symfony's asset versioning
    manifest: true,
  },
  server: {
    // For development
    hmr: {
      host: 'localhost',
    },
  },
});