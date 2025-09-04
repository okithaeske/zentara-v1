import './bootstrap';

// Alpine.js (compiled via Vite) + Focus plugin for x-trap/x-focus
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import collapse from '@alpinejs/collapse';

Alpine.plugin(focus);
Alpine.plugin(collapse);
window.Alpine = Alpine;
Alpine.start();
