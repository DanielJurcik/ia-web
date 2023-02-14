(function() {
	const menuItemsElems = document.querySelectorAll('.elementor-nav-menu .menu-item');

    menuItemsElems.forEach(item => {
        const link = item.querySelector('a.elementor-item');
        if (!link) return;
        if (link.innerHTML === 'YT'){
            item.classList.add('yt-menu-item');
            item.querySelector('a').setAttribute("target", "_blank");
        } 
        if (link.innerHTML === 'FB'){
            item.classList.add('fb-menu-item');
            item.querySelector('a').setAttribute("target", "_blank");
        }
    });

})();