window.onload = function () {
    let tooltipElem;
    const linksWithToolipElems = document.querySelectorAll('[data-toggle="tooltip"]');

    createTooltip();
    addEventListenersToDownloadLinks(linksWithToolipElems)

    function addEventListenersToDownloadLinks(elems){
        elems.forEach(linkElem => {
            linkElem.title = '';
            linkElem.addEventListener('mouseover', (event) => {
                event.preventDefault;
                const content = linkElem.getAttribute('data-title');
                const positionX = event.clientX;
                const positionY = event.clientY;
                tooltipElem.innerHTML = `<p>${content}</p>`;
                tooltipElem.style.top = `${positionY-60}px`;
                tooltipElem.style.left = `${positionX}px`;
                tooltipElem.style.display = 'block';
            }, false);
    
            linkElem.addEventListener('mouseleave', () => {
                tooltipElem.style.display = 'none';
            }, false);
        });
    }
        
    function createTooltip(){
        tooltipElem = document.createElement("div");
        const loremPara = document.createElement("p");
        tooltipElem.classList.add('ia-tooltip');
        document.body.appendChild(tooltipElem);
        tooltipElem.appendChild(loremPara);
    } 
}
