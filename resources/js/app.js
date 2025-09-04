import './bootstrap';

// Alpine.js (compiled via Vite) + Focus plugin for x-trap/x-focus
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import collapse from '@alpinejs/collapse';

// Expose Alpine and defer its start until Livewire is ready
window.Alpine = Alpine;

// If Livewire is used, ensure Alpine starts after Livewire is fully booted
window.deferLoadingAlpine = (callback) => {
    window.addEventListener('livewire:load', callback);
};

Alpine.plugin(focus);
Alpine.plugin(collapse);
Alpine.start();
