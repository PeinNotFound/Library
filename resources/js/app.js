import './bootstrap';

import Alpine from 'alpinejs';

// Gestion des messages flash
document.addEventListener('DOMContentLoaded', function() {
    const flashMessages = document.querySelectorAll('.flash-message');
    
    flashMessages.forEach(message => {
        setTimeout(() => {
            message.classList.add('opacity-0');
            setTimeout(() => message.remove(), 300);
        }, 5000);
    });
});

window.Alpine = Alpine;

Alpine.start();


