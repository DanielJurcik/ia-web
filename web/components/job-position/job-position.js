const dateHideCompSele = '.ia-date-hide-comp';
const dateHideStartDateAtt = 'data-startDate';
const dateHideEndDateAtt = 'data-endDate';

const hideElems = document.querySelectorAll(dateHideCompSele);
hideElems.forEach(element => {
    const endDate = new Date(element.getAttribute(dateHideEndDateAtt));
    const currentDate = Date.now();
    
    if((currentDate > endDate)){
        element.style.display = 'none';
    }
});