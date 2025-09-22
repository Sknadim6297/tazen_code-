// side bar start  
function openNav() {
    "use strict";
    const sidepanel = document.getElementById("mySidepanel");
    if (sidepanel) {
        sidepanel.style.left = "0";
    } else {
        console.error("Error: Side panel element not found!");
    }
}

function closeNav() {
    "use strict";
    const sidepanel = document.getElementById("mySidepanel");
    if (sidepanel) {
        sidepanel.style.left = "-320px";
    } else {
        console.error("Error: Side panel element not found!");
    }
}

// search-bar
function open_search_bar() {
    "use strict";
    const sidepanel = document.getElementById("search-bar");
    if (sidepanel) {
        sidepanel.style.height = "100vh";
        sidepanel.style.borderRadius = "0";
    } else {
        console.error("Error: Side panel element not found!");
    }
}

function close_search_bar() {
    "use strict";
    const sidepanel = document.getElementById("search-bar");
    if (sidepanel) {
        sidepanel.style.height = "0";
        sidepanel.style.borderTopLeftRadius = "100%";
        sidepanel.style.borderTopRightRadius = "100%";
    } else {
        console.error("Error: Side panel element not found!");
    }
}
// right-sidebar
function open_right_side() {
    "use strict";
    const sidepanel = document.getElementById("right_side");
    if (sidepanel) {
        sidepanel.style.right = "0";
    } else {
        console.error("Error: Side panel element not found!");
    }
}

function close_right_sade() {
    "use strict";
    const sidepanel = document.getElementById("right_side");
    if (sidepanel) {
        sidepanel.style.right = "-355px";
    } else {
        console.error("Error: Side panel element not found!");
    }
}

// button back to top 
window.onscroll = function() {
    scrollFunction()
};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("backToTopBtn").style.display = "block";
    } else {
        document.getElementById("backToTopBtn").style.display = "none";
    }
}

function scrollToTop() {
    const scrollToTopBtn = document.documentElement || document.body;
    scrollToTopBtn.scrollIntoView({
        behavior: "smooth"
    });
}


// responsive Logoipsum Slider
if (typeof jQuery !== 'undefined' && jQuery && jQuery.fn && typeof jQuery.fn.slick === 'function') {
    $('.logoipsum-slider').slick({
    arrows: false,
    dots: false,
    infinite: true,
    infinite: true,
    initialSlide: 1,
    autoplay: true,
    speed: 300,
    slidesToShow: 5,
    slidesToScroll: 1,
    pauseOnHover: false,
    cssEase: 'linear',  
    responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 1,
                infinite: true,
                dots: false,
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },
    ]
});

// portfolio gallary tab
function open_img(evt, cityName) {
    var i, tabcontent, tablinks;

    // Hide all tab content
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Remove active class from all tab links
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].classList.remove("active");
    }

    // Show the selected tab content and mark the corresponding tab link as active
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.classList.add("active");
}

// portfolio gallary tab
function open_img_new(evt, cityName) {
    var i, tabcontent, tablinks;

    // Hide all tab content
    tabcontent = document.getElementsByClassName("tabcontentnew");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Remove active class from all tab links
    tablinks = document.getElementsByClassName("tablinksnew");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].classList.remove("active");
    }

    // Show the selected tab content and mark the corresponding tab link as active
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.classList.add("active");
}
// portfolio gallary tab
function open_img_two(evt, cityName) {
    var i, tabcontent, tablinks;

    // Hide all tab content
    tabcontent = document.getElementsByClassName("tabcontenttwo");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Remove active class from all tab links
    tablinks = document.getElementsByClassName("tablinkstwo");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].classList.remove("active");
    }

    // Show the selected tab content and mark the corresponding tab link as active
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.classList.add("active");
}


// ============= testimonial Slider
if (typeof jQuery !== 'undefined' && jQuery && jQuery.fn && typeof jQuery.fn.slick === 'function') {
    $(document).ready(function() {
        var slider = $('.testimonial_slider');

        slider.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: true,
            dots: false,
        });

        // Pause the slider on hover
        slider.on('mouseenter', function() {
            slider.slick('slickPause');
        });

        // Resume the slider when not hovering
        slider.on('mouseleave', function() {
            slider.slick('slickPlay');
        });
    });
} else {
    console.warn('Slick slider is not available. Skipping testimonial slider initialization.');
}

// responsive star Slider
if (typeof jQuery !== 'undefined' && jQuery && jQuery.fn && typeof jQuery.fn.slick === 'function') {
    $('.star-slider').slick({
    arrows: false,
    dots: false,
    infinite: false,
    autoplay: true,
    speed: 300,
    slidesToShow: 7,
    slidesToScroll: 1,
    responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 5,
                slidesToScroll: 1,
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 5,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1
            }
        },
    ]
});

// responsive team Slider
if (typeof jQuery !== 'undefined' && jQuery && jQuery.fn && typeof jQuery.fn.slick === 'function') {
    $('.team-slider').slick({
    arrows: true,
    dots: false,
    infinite: false,
    autoplay: true,
    speed: 2000,
    slidesToShow: 4,
    slidesToScroll: 1,
    responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
                infinite: true,
                dots: true,
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
    });
} else {
    console.warn('Slick slider is not available. Skipping team-slider initialization.');
}
// ============= slider end

// responsive service Slider
if (typeof jQuery !== 'undefined' && jQuery && jQuery.fn && typeof jQuery.fn.slick === 'function') {
    $('.service-slider').slick({
    arrows: true,
    dots: false,
    infinite: false,
    autoplay: true,
    speed: 2000,
    slidesToShow: 4,
    slidesToScroll: 1,
    responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
                infinite: true,
                dots: true,
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
    });
} else {
    console.warn('Slick slider is not available. Skipping service-slider initialization.');
}
// ============= slider end

// ============= counter start ============= // 

(function(e) {
    "use strict";
    e.fn.counterUp = function(t) {
        var n = e.extend({
            time: 400,
            delay: 10
        }, t);
        return this.each(function() {
            var t = e(this),
                r = n,
                i = function() {
                    var e = [],
                        n = r.time / r.delay,
                        i = t.text(),
                        s = /[0-9]+,[0-9]+/.test(i);
                    i = i.replace(/,/g, "");
                    var o = /^[0-9]+$/.test(i),
                        u = /^[0-9]+\.[0-9]+$/.test(i),
                        a = u ? (i.split(".")[1] || [])
                        .length : 0;
                    for (var f = n; f >= 1; f--) {
                        var l = parseInt(i / n * f);
                        u && (l = parseFloat(i / n * f)
                            .toFixed(a));
                        if (s)
                            while (/(\d+)(\d{3})/.test(l.toString())) l = l.toString()
                                .replace(/(\d+)(\d{3})/, "$1,$2");
                        e.unshift(l)
                    }
                    t.data("counterup-nums", e);
                    t.text("0");
                    var c = function() {
                        t.text(t.data("counterup-nums")
                            .shift());
                        if (t.data("counterup-nums")
                            .length) setTimeout(t.data("counterup-func"), r.delay);
                        else {
                            delete t.data("counterup-nums");
                            t.data("counterup-nums", null);
                            t.data("counterup-func", null)
                        }
                    };
                    t.data("counterup-func", c);
                    setTimeout(t.data("counterup-func"), r.delay)
                };
            t.waypoint(i, {
                offset: "100%",
                triggerOnce: !0
            })
        })
    }
})(jQuery);

jQuery(document)
    .ready(function($) {
        $('.count')
            .counterUp({
                delay: 10,
                time: 2000
            });
    });
// ============= counter end ============= //

// footer validation start
const fom = document.getElementById('footer-form');
const footerMessage = document.getElementById('footer-message');

fom.addEventListener('submit', (event) => {
    event.preventDefault();
    footerMessage.innerHTML = 'Form submitted success fully!';
    footerMessage.style.display = 'block';
    fom.reset();
    setTimeout(() => {
        footerMessage.style.display = 'none';
    }, 3000);
});
// footer validation end



//top
// var testimonial_top_slider = new Swiper('.testimonial-slide-top', {
//   spaceBetween: 24,
//   centeredSlides: true,
//   speed: 8000,
//   autoplay: {
//     delay: 1,
//   },
//   loop: true,
//   slidesPerView:'auto',
//   allowTouchMove: false,
//   disableOnInteraction: true
// });

// // Bottom
// var testimonial_bottom_slider = new Swiper('.testimonial-slide-bottom', {
//   spaceBetween: 24,
//   centeredSlides: true,
//   speed: 8000,
//   autoplay: {
//     delay: 1,
//     reverseDirection: true
//   },
//   loop: true,
//   slidesPerView:'auto',
//   allowTouchMove: false,
//   disableOnInteraction: true
// });


// // Testimonial Image Generator
// var testimonialImg = new Swiper('.testimonial-img-slide', {
//   fadeEffect: { crossFade: true },
//   effect: 'fade',
//   loop: true,
//   allowTouchMove : false,
// })
  
// var testimonialInfo = new Swiper('.testimonial-info-slide', {
// spaceBetween: 24,
// slidesPerView: 1,
// loop: true,
// speed: 800,
// allowTouchMove : false,
// navigation: {
//   nextEl: ".testimonial-info-button-next",
//   prevEl: ".testimonial-info-button-prev",
// },
// pagination: {
//   el: ".testimonial-info-pagination",
//   clickable: true,
// },
// thumbs: {
//   swiper: testimonialImg
// }
// });


// var cg_testimonialSlider = new Swiper('.cg-testimonial-slide', {
//   slidesPerView: 3,
//   spaceBetween: 15,
//   loop:true,
//   speed: 1000,
//   breakpoints: {
//     320: {
//       slidesPerView: 1
//     },
//     480: {
//       slidesPerView: 1
//     },
//     768: {
//       slidesPerView: 2
//     },
//     992: {
//       slidesPerView: 2
//     },
//     1200: {
//       slidesPerView: 3
//     },
//     1400: {
//       slidesPerView:3
//     }
//   },
//   navigation: {
//     nextEl: ".cg-testimonial-info-button-next",
//     prevEl: ".cg-testimonial-info-button-prev",
//   },
//   pagination: {
//     el: ".cg-testimonial-info-pagination",
//     clickable: true,
//   },
//   });
