function setHeights() {
    const divs = document.querySelectorAll('.image-overlay-container');

    divs.forEach(function (div) {
        const width = div.offsetWidth;
        div.style.height = width + 'px';
    });
}

setHeights();
window.onresize = setHeights;