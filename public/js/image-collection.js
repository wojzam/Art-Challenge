const overlays = document.querySelectorAll('.overlay');
const popup = document.querySelector('.popup-overlay');
const popupImage = popup.getElementsByTagName("img")[0];
const closeButton = document.querySelector(".close");

function setHeights() {
    const divs = document.querySelectorAll('.image-overlay-container');

    divs.forEach(function (div) {
        const width = div.offsetWidth;
        div.style.height = width + 'px';
    });
}

setHeights();
window.onresize = setHeights;

function showPopup(){
    popup.style.display = "flex";
}

function hidePopup(){
    popup.style.display = "none";
}

function createImagePopup() {
    const image = this.parentNode.getElementsByClassName("collection-image")[0];
    popupImage.src = image.src;
    showPopup();
}
overlays.forEach(button => button.addEventListener("click", createImagePopup));
closeButton.addEventListener("click", hidePopup);
popup.addEventListener("click", hidePopup);
