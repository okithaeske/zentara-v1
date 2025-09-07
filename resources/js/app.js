import './bootstrap';

// Livewire v3 bundles Alpine. Do not import Alpine core here.
// Register any Alpine plugins after Alpine initializes.
import focus from '@alpinejs/focus';
import collapse from '@alpinejs/collapse';

document.addEventListener('alpine:init', () => {
    window.Alpine.plugin(focus);
    window.Alpine.plugin(collapse);
});
