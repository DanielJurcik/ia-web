const noJobsMsg = `Aktuálne nie sú k dispozícii žiadne voľné pozície. Ich ponuku priebežne aktualizujeme.`;
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