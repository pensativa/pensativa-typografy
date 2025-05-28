let jsSliderInitOnce = !1,
    jsSliderExclusives,
    jsSliderAuthored1,
    jsSliderAuthored2;

// Slider init
function jsSliderCreate(sliderBlock, container, autoplay = false, count = 1, gap = 0) {
    const slider = document.querySelector(sliderBlock);
    const sliderContainer = document.querySelector(`${sliderBlock} ${container}`);
    const slides = document.querySelectorAll(`${sliderBlock} .gallery__img`);
    const sliderBtnPrev = document.querySelector(`${sliderBlock} .swiper-left`);
    const sliderBtnNext = document.querySelector(`${sliderBlock} .swiper-right`);
    let sliderDotsContainer = document.querySelector(`${sliderBlock} .swiper-dots`);

    if (!slider || 
        !sliderContainer || 
        !slides.length || 
        slider.classList.contains('slider-init') /* if slide have been init before */) return;

    slider.classList.add('slider-init');
    let slidesPerView = window.innerWidth < 920 ? 1 : count;
    let total = 0;
    let numIndex = 0;
    const numOfDots = Math.ceil(slides.length / slidesPerView);
    let timer;

    if (slidesPerView >= slides.length) {
        if (sliderBtnPrev && sliderBtnNext) {
            sliderBtnPrev.style.display = 'none';
            sliderBtnNext.style.display = 'none';
        }
        return; // if slides count is less than slidesPerView, do not create slider
    }

    // Setting the width of the slider container
    function setContainerWidth() {
        total = slides.length * (slider.getBoundingClientRect().width + gap);
        sliderContainer.style.width = `${total}px`;
    }
    setContainerWidth();

    // Creating dots dependent on the count of slides
    function createDots() {
        if (sliderDotsContainer) {
            sliderDotsContainer.innerHTML = '';
            for (let i = 0; i < numOfDots; i++) {
                const dot = document.createElement('span');
                dot.classList.add('swiper-dot');
                dot.addEventListener('click', () => goToSlide(i));
                sliderDotsContainer.appendChild(dot);
            }
            updateActiveDot();
        }
    }

    // Update active dot
    function updateActiveDot() {
        if (sliderDotsContainer) {
            const dots = sliderDotsContainer.querySelectorAll('.swiper-dot');
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === numIndex);
                dot.classList.toggle('animate', i === numIndex);
            });
        }
    }

    // Changing slides main function
    function goToSlide(index) {
        if (index < 0) index = numOfDots - 1;
        if (index >= numOfDots) index = 0;
        numIndex = index;

        const offset = (total / numOfDots) * numIndex;
        sliderContainer.style.transform = `translateX(-${offset}px)`;

        updateActiveDot();
        resetAutoChange();
    }

    // Changing slides by button prev/next
    sliderBtnPrev?.addEventListener('click', () => goToSlide(numIndex - 1));
    sliderBtnNext?.addEventListener('click', () => goToSlide(numIndex + 1));

    // Auto-changing with Intersection Observer
    function autoChange() {
        if (autoplay) {
            timer = setInterval(() => goToSlide(numIndex + 1), 5000);
        }
    }

    function playAutoChange() {
        goToSlide(numIndex + 1);
        if (timer) {
            resetAutoChange();
        } else {
            autoChange()
        }
    }

    function resetAutoChange() {
        if (timer) {
            clearInterval(timer);
            autoChange();
        }
    }

    function stopAutoChange() {
        if (timer) {
            clearInterval(timer);
        }
    }

    let observer;
    function observeSlider() {
        if (!autoplay) return;

        observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                entry.isIntersecting ? playAutoChange() : stopAutoChange();
            });
        }, { threshold: 0.3 });
        observer.observe(slider);
    }

    // Changing slides by swipe
    sliderContainer.addEventListener('touchstart', touchStart, { passive: true });
    sliderContainer.addEventListener('touchmove', touchMove, { passive: true });

    let xDown, 
        yDown;

    function touchStart(evt) {
        const { clientX, clientY } = evt.touches[0];
        xDown = clientX; yDown = clientY;
    }

    function touchMove(evt) {
        if (!xDown || !yDown) {
            return; 
        }

        const { clientX, clientY } = evt.touches[0];

        const xDiff = xDown - clientX;
        const yDiff = yDown - clientY;

        if (Math.abs(xDiff) > Math.abs(yDiff)) {
            xDiff > 0 ? goToSlide(numIndex + 1) : goToSlide(numIndex - 1);
        }
        
        xDown = yDown = null;
    }

    // Destroy slider
    function destroySlider() {
        clearInterval(timer);
        slider.classList.remove('slider-init')
        sliderContainer.style.transform = '';
        sliderContainer.style.width = '';
        observer?.disconnect();
        sliderBtnPrev?.removeEventListener('click', () => goToSlide(numIndex - 1));
        sliderBtnNext?.removeEventListener('click', () => goToSlide(numIndex + 1));
        sliderContainer.removeEventListener('touchstart', touchStart);
        sliderContainer.removeEventListener('touchend', touchMove);
        if (sliderDotsContainer) {
            sliderDotsContainer.innerHTML = '';
        }
        console.log('Slider destroyed');
    }

    // Resize changes
    window.addEventListener('resize', () => {
        setContainerWidth();
        createDots();
        // goToSlide(numIndex);
    });

    // Initialization
    setContainerWidth();
    createDots();
    observeSlider();

    return {
        destroy: destroySlider
    };
}


function jsSliderInit() {
    if (!jsSliderInitOnce) {
        jsSliderInitOnce = !0;
    } else {
        return;
    }

    // real init after first scroll
    window.addEventListener('scroll', () => {

        // create exclusives slider
        jsSliderExclusives = jsSliderCreate('.case-gallery', '.gallery', true);

    }, {passive: true, once: true});
}

setTimeout(() => {
    jsSliderInit();
}, 100);
