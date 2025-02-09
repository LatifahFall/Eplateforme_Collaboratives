import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import react from '@vitejs/plugin-react';

export default defineConfig({
  plugins: [react(), vue()],
  server: {
    proxy: {
      '/static': 'http://127.0.0.1:8000/react', 
    },
  },
  build: {
    outDir: 'public/react',  
    manifest: true,          
  },
});
