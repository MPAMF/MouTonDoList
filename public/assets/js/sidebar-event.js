function checkSidebar() {
    if(window.innerWidth > 992)
        body.classList.remove('scrolling-disabled')
    else if(target.classList.contains('show'))
        body.classList.add('scrolling-disabled')
    else
        body.classList.remove('scrolling-disabled')
}

// Select the node that will be observed for mutations
const target = document.getElementById('verticalNavbar')

// if sidebar is shown by default
$( window ).on( "load", checkSidebar )
// if window is resized
window.addEventListener('resize', checkSidebar)

// Options for the observer (which mutations to observe)
const options = {
    attributes: true
}

const callback = (mutationList, observer) => {
    for (const mutation of mutationList) {
        if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
            checkSidebar()
        }
    }
};

// Create an observer instance linked to the callback function
const observer = new MutationObserver(callback);

// Start observing the target node for configured mutations
observer.observe(target, options);