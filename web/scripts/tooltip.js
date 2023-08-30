const linksWithToolipElems = document.querySelectorAll('[data-toggle="tooltip"]');

const tooltipElem = document.createElement("div");
tooltipElem.classList.add('ia-tooltip');
document.body.appendChild(tooltipElem);


linksWithToolipElems.forEach(linkElem => {
    linkElem.addEventListener('mouseover', activateTooltip(linkElem));
    linkElem.addEventListener('mouseleave', disableTooltip(linkElem));
});
console.log(linksWithToolipElems);



function activateTooltip(elem){
   const content = elem.getAttribute('data-title');
   const positionX = 0;
   const positionY = 0;
   tooltipElem.style.display = 'block';
}

function disableTooltip(elem){
    tooltipElem.style.display = 'none';
}
