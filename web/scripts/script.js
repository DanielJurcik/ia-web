(function() {
    ////////////////////////////////////////////////
    ////////////////////////////////////////////////
    // Nastavenie premenných - tu meniť linky
    const youtubeUrl = "https://www.youtube.com/channel/UCSQf3Ue--LRKuufth4Ayh8Q/videos?view=0&sort=dd&shelf_id=0";
    const facebookUrl = "https://www.facebook.com/iampsvr/";
    ////////////////////////////////////////////////
    ////////////////////////////////////////////////

    function fragmentFromString(strHTML) {
        return document.createRange().createContextualFragment(strHTML);
    }

    // Nájdenie menu elementu
    const secondNavElem = document.querySelector(`[data-elementor-type="wp-page"] nav .elementor-nav-menu`);

    let fbStringElem = `<a href="${facebookUrl}" target="_blank">
					<span class="elementor-screen-only">Facebook</span>
					<i class="fab fa-facebook"></i>					
                </a>`;

    let ytStringElem = `<a href="${youtubeUrl}" target="_blank">
        <span class="elementor-screen-only">Youtube</span>
        <i class="fab fa-youtube"></i>					
        </a>`;
    
    let fbFragment = fragmentFromString(fbStringElem);
    let ytFragment = fragmentFromString(ytStringElem);

    secondNavElem.appendChild(fbFragment);
    secondNavElem.appendChild(ytFragment);

})();