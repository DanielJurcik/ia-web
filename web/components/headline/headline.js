adjustDivider();

window.addEventListener('resize', function(event){
    adjustDivider();
    console.log("RESIZE");
});

function adjustDivider(){
    const headlineElems = document.querySelectorAll('.ia-headline-comp');
    headlineElems.forEach(element => {
        const headlineText = element.querySelector('.ia-headline-comp__text');
        headlineText.innerHTML = headlineText.innerHTML + "<span class='ia-headline-comp__cursor'></span>"
        const cursor = element.querySelector('.ia-headline-comp__cursor');
        const divider = element.querySelector('.ia-headline-comp__divider');
        if(divider) divider.style.width = `${cursor.offsetLeft}px`;
        cursor.remove();
    });
}