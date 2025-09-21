/*
=============
Glide Js Carousel
=============
 */

const slider1 = document.getElementById("glide_1");
const slider2 = document.getElementById("glide_2");
const slider3 = document.getElementById("glide_3");
const slider4 = document.getElementById("glide_4");
const slider5 = document.getElementById("glide_5");


// Testimonial

if (slider4) {
  new Glide("#glide_4", {
    type: "carousel",
    startAt: 0,
    perView: 1,
    rewin: false,
    animationDuration: 800,
    animationTimingFunc: "cubic-bezier(0.165, 0.840, 0.440, 1.000)",
  }).mount();
}


// News
if (slider5) {
  new Glide("#glide_5", {
    type: "carousel",
    startAt: 0,
    perView: 3,
    rewin: false,
    autoplay: 3000,
    animationDuration: 800,
    animationTimingFunc: "cubic-bezier(0.165, 0.840, 0.440, 1.000)",
    breakpoints: {
      998: {
        perView: 2,
      },
      768: {
        perView: 1,
      },
    },
  }).mount();
}

AOS.init();
