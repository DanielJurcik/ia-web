document.querySelectorAll('.ia-image-item .more-info-button').forEach(item => {
    item.addEventListener('keydown', function(e) {
        // Trigger on Enter (13) or Space (32)
        if (e.keyCode === 13 || e.keyCode === 32) {
            e.preventDefault();
            
            // Toggle a class if you want it to "stick" open on mobile/keyboard
            const expanded = this.getAttribute('aria-expanded') === 'true';

            this.setAttribute('aria-expanded', !expanded);
            
            // This allows the CSS :focus state to stay active
            this.focus(); 
        }
    });
});