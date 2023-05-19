const noJobsMsg = `V súčasnosti nemáme voľné pozície. V prípade záujmu o zaradenie do evidencie môžete poslať mail na <a href='mailto:karieraia.gov.sk'>karieraia.gov.sk</a>`;
//Selectors
const dateHideCompSele = '.ia-date-hide-comp';
const dateHideStartDateAtt = 'data-startDate';
const dateHideEndDateAtt = 'data-endDate';
const jobPositionWrapperClass = 'ia-job-position-wrapper';
const noJobsElemClass = 'ia-no-jobs-msg';
// Elems
const hideElems = document.querySelectorAll(dateHideCompSele);
const jobPositionWrapperElem = document.querySelector(`.${jobPositionWrapperClass}`);

let haveActiveJobs = false;

hideElems.forEach(element => {
    const endDate = new Date(element.getAttribute(dateHideEndDateAtt));
    const currentDate = Date.now();

    if((currentDate > endDate)){
        element.style.display = 'none';
    }else{
        haveActiveJobs = true;
    }
});

// If there are no avaiable jobs then it will append message
if((!document.querySelector(noJobsElemClass)) && (!haveActiveJobs)) {
    let noJobsMsgElem = document.createElement('p');
    noJobsMsgElem.classList.add(noJobsElemClass)
    noJobsMsgElem.innerHTML = noJobsMsg;
    jobPositionWrapperElem.appendChild(noJobsMsgElem);
}