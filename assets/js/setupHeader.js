export const setupHeader = () => {
    const headerElement = document.getElementById('header');
    const overlayElement = document.getElementById('overlay');
    const mobileHeaderElement = document.getElementById('mobile-header');
    const bodyElement = document.getElementsByTagName('body')[0];

    mobileHeaderElement.getElementsByClassName('menu')[0].addEventListener('click', ($event) => {
        show();
        $event.stopPropagation();
    });

    headerElement.getElementsByClassName('close')[0].addEventListener('click', ($event) => {
        hide();
    });

    bodyElement.addEventListener('click', ($event) => {
        if (headerElement.classList.contains('visible') && !headerElement.contains($event.target)) {
            hide();
        }
    });

    const show = () => {
        if (!headerElement.classList.contains('visible')) {
            headerElement.classList.add('visible');
            overlayElement.classList.add('visible');
            bodyElement.classList.add('locked');
        }
    };

   const hide = () => {
        if (headerElement.classList.contains('visible')) {
            headerElement.classList.remove('visible');
            overlayElement.classList.remove('visible');
            bodyElement.classList.remove('locked');
        }
    };
};