let nextDom = document.getElementById('next');
let prevDom = document.getElementById('prev');

let carouselDom = document.querySelector('.carousel');
let SliderDom = carouselDom.querySelector('.carousel .list');
let thumbnailBorderDom = document.querySelector('.carousel .thumbnail');
let thumbnailItemsDom = thumbnailBorderDom.querySelectorAll('.item');
let timeDom = document.querySelector('.carousel .time');

// Eseményfigyelők hozzáadása a slider megállításához
let isPaused = false;

carouselDom.addEventListener('mouseenter', function () {
    isPaused = true; // Ha az egér belép a slider területére, megállítjuk a slider-t
});
carouselDom.addEventListener('mouseleave', function () {
    isPaused = false; // Ha az egér elhagyja a slider területét, újra elindítjuk a slider-t
});
carouselDom.addEventListener('touchstart', function () {
    isPaused = true; // Ha a felhasználó érinti a slider-t a mobilon, megállítjuk a slider-t
});
carouselDom.addEventListener('touchend', function () {
    isPaused = false; // Ha a felhasználó elengedi az érintést a slider-ről, újra elindítjuk a slider-t
});

thumbnailBorderDom.appendChild(thumbnailItemsDom[0]);
let timeRunning = 1000;
let timeAutoNext = 7000;

nextDom.onclick = function () {
    showSlider('next');
}
prevDom.onclick = function () {
    showSlider('prev');
}
let runTimeOut;
let runNextAuto = setTimeout(() => {
    next.click();
}, timeAutoNext)
function showSlider(type) {
    if (isPaused) return; // Ha a slider meg van állítva, ne csináljon semmit

    let SliderItemsDom = SliderDom.querySelectorAll('.carousel .list .item');
    let thumbnailItemsDom = document.querySelectorAll('.carousel .thumbnail .item');

    if (type === 'next') {
        SliderDom.appendChild(SliderItemsDom[0]);
        thumbnailBorderDom.appendChild(thumbnailItemsDom[0]);
        carouselDom.classList.add('next');
    } else {
        SliderDom.prepend(SliderItemsDom[SliderItemsDom.length - 1]);
        thumbnailBorderDom.prepend(thumbnailItemsDom[thumbnailItemsDom.length - 1]);
        carouselDom.classList.add('prev');
    }
    clearTimeout(runTimeOut);
    runTimeOut = setTimeout(() => {
        carouselDom.classList.remove('next');
        carouselDom.classList.remove('prev');
    }, timeRunning);

    clearTimeout(runNextAuto);
    runNextAuto = setTimeout(() => {
        next.click();
    }, timeAutoNext)
}
