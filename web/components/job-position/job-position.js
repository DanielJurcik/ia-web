const noJobsMsg = 'Aktuálne nie sú k dispozícii žiadne voľné pozície. Ich ponuku priebežne aktualizujeme.';
const dateHideCompSele = '.ia-date-hide-comp';
const dateHideEndDateAtt = 'data-endDate';
const jobPositionWrapperClass = 'ia-job-position-wrapper';
const noJobsElemClass = 'ia-no-jobs-msg';

const hideElems = document.querySelectorAll(dateHideCompSele);
const jobPositionWrapperElem = document.querySelector(`.${jobPositionWrapperClass}`);
const isEditor = document.body.classList.contains('elementor-editor-active');
let haveActiveJobs = false;

hideElems.forEach(element => {
    const endDate = new Date(element.getAttribute(dateHideEndDateAtt));
    const currentDate = new Date();

    if (currentDate > endDate) {
        if (!isEditor) {
            element.remove();
        } else {
            element.style.opacity = '0.5';
            haveActiveJobs = true;
        }
    } else {
        haveActiveJobs = true;
    }
});

if (!haveActiveJobs && jobPositionWrapperElem && !document.querySelector(`.${noJobsElemClass}`)) {
    const noJobsMsgElem = document.createElement('p');
    noJobsMsgElem.className = noJobsElemClass;
    noJobsMsgElem.textContent = noJobsMsg;
    jobPositionWrapperElem.appendChild(noJobsMsgElem);
}