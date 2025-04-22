"use strict";

let mainContent;
(function () {
    let html = document.querySelector('html');
    mainContent = document.querySelector('.main-content');
    if (document.querySelector("#switcher-canvas")) {
        localStorageBackup2();
        switcherClick();
        checkOptions();
        setTimeout(() => {
            checkOptions();
        }, 1000);
    }
    /* LTR to RTL */
    // html.setAttribute("dir" , "rtl") // for rtl version

})();

function switcherClick() {
    let ltrBtn, rtlBtn, verticalBtn, horiBtn, lightBtn, darkBtn, boxedBtn, defaultwidthBtn, fullwidthBtn, scrollHeaderBtn, scrollMenuBtn, fixedHeaderBtn, fixedMenuBtn, lightHeaderBtn, darkHeaderBtn, colorHeaderBtn, gradientHeaderBtn, lightMenuBtn, darkMenuBtn, colorMenuBtn, gradientMenuBtn, transparentMenuBtn, transparentHeaderBtn, regular, classic, modern, defaultBtn, closedBtn, iconTextBtn, detachedBtn, overlayBtn, doubleBtn, menuClickBtn, menuHoverBtn, iconClickBtn, iconHoverBtn, primaryDefaultColor1Btn, primaryDefaultColor2Btn, primaryDefaultColor3Btn, primaryDefaultColor4Btn, primaryDefaultColor5Btn, bgDefaultColor1Btn, bgDefaultColor2Btn, bgDefaultColor3Btn, bgDefaultColor4Btn, bgDefaultColor5Btn, bgImage1Btn, bgImage2Btn, bgImage3Btn, bgImage4Btn, bgImage5Btn, ResetAll, resetBtn, loaderEnable, loaderDisable;
    let html = document.querySelector('html');
    lightBtn = document.querySelector('#switcher-light-theme');
    darkBtn = document.querySelector('#switcher-dark-theme');
    ltrBtn = document.querySelector('#switcher-ltr');
    rtlBtn = document.querySelector('#switcher-rtl');
    verticalBtn = document.querySelector('#switcher-vertical');
    horiBtn = document.querySelector('#switcher-horizontal');
    defaultwidthBtn = document.querySelector('#switcher-default-width');
    boxedBtn = document.querySelector('#switcher-boxed');
    fullwidthBtn = document.querySelector('#switcher-full-width');
    fixedMenuBtn = document.querySelector('#switcher-menu-fixed');
    scrollMenuBtn = document.querySelector('#switcher-menu-scroll');
    fixedHeaderBtn = document.querySelector('#switcher-header-fixed');
    scrollHeaderBtn = document.querySelector('#switcher-header-scroll');
    lightHeaderBtn = document.querySelector('#switcher-header-light');
    darkHeaderBtn = document.querySelector('#switcher-header-dark');
    colorHeaderBtn = document.querySelector('#switcher-header-primary');
    gradientHeaderBtn = document.querySelector('#switcher-header-gradient');
    transparentHeaderBtn = document.querySelector('#switcher-header-transparent');
    lightMenuBtn = document.querySelector('#switcher-menu-light');
    darkMenuBtn = document.querySelector('#switcher-menu-dark');
    colorMenuBtn = document.querySelector('#switcher-menu-primary');
    gradientMenuBtn = document.querySelector('#switcher-menu-gradient');
    transparentMenuBtn = document.querySelector('#switcher-menu-transparent');
    regular = document.querySelector('#switcher-regular');
    classic = document.querySelector('#switcher-classic');
    modern = document.querySelector('#switcher-modern');
    defaultBtn = document.querySelector('#switcher-default-menu');
    menuClickBtn = document.querySelector('#switcher-menu-click');
    menuHoverBtn = document.querySelector('#switcher-menu-hover');
    iconClickBtn = document.querySelector('#switcher-icon-click');
    iconHoverBtn = document.querySelector('#switcher-icon-hover');
    closedBtn = document.querySelector('#switcher-closed-menu');
    iconTextBtn = document.querySelector('#switcher-icontext-menu');
    overlayBtn = document.querySelector('#switcher-icon-overlay');
    doubleBtn = document.querySelector('#switcher-double-menu');
    detachedBtn = document.querySelector('#switcher-detached');
    resetBtn = document.querySelector('#resetbtn');
    primaryDefaultColor1Btn = document.querySelector('#switcher-primary');
    primaryDefaultColor2Btn = document.querySelector('#switcher-primary1');
    primaryDefaultColor3Btn = document.querySelector('#switcher-primary2');
    primaryDefaultColor4Btn = document.querySelector('#switcher-primary3');
    primaryDefaultColor5Btn = document.querySelector('#switcher-primary4');
    bgDefaultColor1Btn = document.querySelector('#switcher-background');
    bgDefaultColor2Btn = document.querySelector('#switcher-background1');
    bgDefaultColor3Btn = document.querySelector('#switcher-background2');
    bgDefaultColor4Btn = document.querySelector('#switcher-background3');
    bgDefaultColor5Btn = document.querySelector('#switcher-background4');
    bgImage1Btn = document.querySelector('#switcher-bg-img');
    bgImage2Btn = document.querySelector('#switcher-bg-img1');
    bgImage3Btn = document.querySelector('#switcher-bg-img2');
    bgImage4Btn = document.querySelector('#switcher-bg-img3');
    bgImage5Btn = document.querySelector('#switcher-bg-img4');
    ResetAll = document.querySelector('#reset-all');
    loaderEnable = document.querySelector('#switcher-loader-enable');
    loaderDisable = document.querySelector('#switcher-loader-disable');

    // primary theme
    let primaryColor1Var = primaryDefaultColor1Btn.addEventListener('click', () => {
        localStorage.setItem("primaryRGB", "119, 60, 211");
        html.style.setProperty('--primary-rgb', `119, 60, 211`);
    })
    let primaryColor2Var = primaryDefaultColor2Btn.addEventListener('click', () => {
        localStorage.setItem("primaryRGB", "28, 121, 196");
        html.style.setProperty('--primary-rgb', `28, 121, 196`);
    })
    let primaryColor3Var = primaryDefaultColor3Btn.addEventListener('click', () => {
        localStorage.setItem("primaryRGB", "163, 33, 201");
        html.style.setProperty('--primary-rgb', `163, 33, 201`);
    })
    let primaryColor4Var = primaryDefaultColor4Btn.addEventListener('click', () => {
        localStorage.setItem("primaryRGB", "29, 174, 87");
        html.style.setProperty('--primary-rgb', `29, 174, 87`);
    })
    let primaryColor5Var = primaryDefaultColor5Btn.addEventListener('click', () => {
        localStorage.setItem("primaryRGB", "174, 115, 29");
        html.style.setProperty('--primary-rgb', `174, 115, 29`);
    })

    // Background theme
    let backgroundColor1Var = bgDefaultColor1Btn.addEventListener('click', () => {
        localStorage.setItem('bodyBgRGB', "59, 32, 110");
        localStorage.setItem('bodylightRGB', "73, 46, 124");
        html.setAttribute('data-theme-mode', 'dark');
        html.setAttribute('data-menu-styles', 'dark');
        html.setAttribute('data-header-styles', 'dark');
        document.querySelector('html').style.setProperty('--body-bg-rgb', localStorage.bodyBgRGB);
        document.querySelector('html').style.setProperty('--body-bg-rgb2', localStorage.bodylightRGB);
        document.querySelector('html').style.setProperty('--light-rgb', "73, 46, 124");
        document.querySelector('html').style.setProperty('--form-control-bg', "rgb(73, 46, 124)");
        document.querySelector('html').style.setProperty('--input-border', "rgba(255,255,255,0.1)");
        document.querySelector('html').style.setProperty('--gray-3', "rgba(255,255,255,0.1)");
        document.querySelector('#switcher-dark-theme').checked = true;
        document.querySelector('#switcher-menu-dark').checked = true;
        document.querySelector('#switcher-header-dark').checked = true;
        localStorage.setItem("menoMenu", "dark");
        localStorage.setItem("menoHeader", "dark");
    })
    let backgroundColor2Var = bgDefaultColor2Btn.addEventListener('click', () => {
        localStorage.setItem('bodyBgRGB', "4, 59, 103");
        localStorage.setItem('bodylightRGB', "18, 73, 117");
        html.setAttribute('data-theme-mode', 'dark');
        html.setAttribute('data-menu-styles', 'dark');
        html.setAttribute('data-header-styles', 'dark');
        document.querySelector('html').style.setProperty('--body-bg-rgb', localStorage.bodyBgRGB);
        document.querySelector('html').style.setProperty('--body-bg-rgb2', localStorage.bodylightRGB);
        document.querySelector('html').style.setProperty('--light-rgb', "18, 73, 117");
        document.querySelector('html').style.setProperty('--form-control-bg', "rgb(18, 73, 117)");
        document.querySelector('html').style.setProperty('--input-border', "rgba(255,255,255,0.1)");
        document.querySelector('html').style.setProperty('--gray-3', "rgba(255,255,255,0.1)");
        document.querySelector('#switcher-dark-theme').checked = true;
        document.querySelector('#switcher-menu-dark').checked = true;
        document.querySelector('#switcher-header-dark').checked = true;
        localStorage.setItem("menoMenu", "dark");
        localStorage.setItem("menoHeader", "dark");
    })
    let backgroundColor3Var = bgDefaultColor3Btn.addEventListener('click', () => {
        localStorage.setItem('bodyBgRGB', "95, 4, 103");
        localStorage.setItem('bodylightRGB', "109, 18, 117");
        html.setAttribute('data-theme-mode', 'dark');
        html.setAttribute('data-menu-styles', 'dark');
        html.setAttribute('data-header-styles', 'dark');
        document.querySelector('html').style.setProperty('--body-bg-rgb', localStorage.bodyBgRGB);
        document.querySelector('html').style.setProperty('--body-bg-rgb2', localStorage.bodylightRGB);
        document.querySelector('html').style.setProperty('--light-rgb', "109, 18, 117");
        document.querySelector('html').style.setProperty('--form-control-bg', "rgb(109, 18, 117)");
        document.querySelector('html').style.setProperty('--input-border', "rgba(255,255,255,0.1)");
        document.querySelector('html').style.setProperty('--gray-3', "rgba(255,255,255,0.1)");
        document.querySelector('#switcher-dark-theme').checked = true;
        document.querySelector('#switcher-menu-dark').checked = true;
        document.querySelector('#switcher-header-dark').checked = true;
        localStorage.setItem("menoMenu", "dark");
        localStorage.setItem("menoHeader", "dark");
    })
    let backgroundColor4Var = bgDefaultColor4Btn.addEventListener('click', () => {
        localStorage.setItem('bodyBgRGB', "1, 58, 21");
        localStorage.setItem('bodylightRGB', "15, 72, 35");
        html.setAttribute('data-theme-mode', 'dark');
        html.setAttribute('data-menu-styles', 'dark');
        html.setAttribute('data-header-styles', 'dark');
        document.querySelector('html').style.setProperty('--body-bg-rgb', localStorage.bodyBgRGB);
        document.querySelector('html').style.setProperty('--body-bg-rgb2', localStorage.bodylightRGB);
        document.querySelector('html').style.setProperty('--light-rgb', "15, 72, 35");
        document.querySelector('html').style.setProperty('--form-control-bg', "rgb(15, 72, 35)");
        document.querySelector('html').style.setProperty('--input-border', "rgba(255,255,255,0.1)");
        document.querySelector('html').style.setProperty('--gray-3', "rgba(255,255,255,0.1)");
        document.querySelector('#switcher-dark-theme').checked = true;
        document.querySelector('#switcher-menu-dark').checked = true;
        document.querySelector('#switcher-header-dark').checked = true;
        localStorage.setItem("menoMenu", "dark");
        localStorage.setItem("menoHeader", "dark");
    })
    let backgroundColor5Var = bgDefaultColor5Btn.addEventListener('click', () => {
        localStorage.setItem('bodyBgRGB', "83, 51, 4");
        localStorage.setItem('bodylightRGB', "97, 65, 18");
        html.setAttribute('data-theme-mode', 'dark');
        html.setAttribute('data-menu-styles', 'dark');
        html.setAttribute('data-header-styles', 'dark');
        document.querySelector('html').style.setProperty('--body-bg-rgb', localStorage.bodyBgRGB);
        document.querySelector('html').style.setProperty('--body-bg-rgb2', localStorage.bodylightRGB);
        document.querySelector('html').style.setProperty('--light-rgb', "97, 65, 18");
        document.querySelector('html').style.setProperty('--form-control-bg', "rgb(97, 65, 18)");
        document.querySelector('html').style.setProperty('--input-border', "rgba(255,255,255,0.1)");
        document.querySelector('html').style.setProperty('--gray-3', "rgba(255,255,255,0.1)");
        document.querySelector('#switcher-dark-theme').checked = true;
        document.querySelector('#switcher-menu-dark').checked = true;
        document.querySelector('#switcher-header-dark').checked = true;
        localStorage.setItem("menoMenu", "dark");
        localStorage.setItem("menoHeader", "dark");
    })

    // Bg image
    let bgImg1Var = bgImage1Btn.addEventListener('click', () => {
        html.setAttribute('data-bg-img', 'bgimg1')
        localStorage.setItem("bgimg", "bgimg1")
    })
    let bgImg2Var = bgImage2Btn.addEventListener('click', () => {
        html.setAttribute('data-bg-img', 'bgimg2')
        localStorage.setItem("bgimg", "bgimg2")
    })
    let bgImg3Var = bgImage3Btn.addEventListener('click', () => {
        html.setAttribute('data-bg-img', 'bgimg3')
        localStorage.setItem("bgimg", "bgimg3")
    })
    let bgImg4Var = bgImage4Btn.addEventListener('click', () => {
        html.setAttribute('data-bg-img', 'bgimg4')
        localStorage.setItem("bgimg", "bgimg4")
    })
    let bgImg5Var = bgImage5Btn.addEventListener('click', () => {
        html.setAttribute('data-bg-img', 'bgimg5')
        localStorage.setItem("bgimg", "bgimg5")
    })

    /* Light Layout Start */
    let lightThemeVar = lightBtn.addEventListener('click', () => {
        lightFn();
        localStorage.setItem("menoHeader", 'light');
        localStorage.removeItem("bodylightRGB")
        localStorage.removeItem("bodyBgRGB")
        localStorage.removeItem("menoMenu")
        if (html.getAttribute('data-nav-layout') === 'horizontal') {
            html.setAttribute('data-header-styles', 'light');
        }
    })
    /* Light Layout End */

    /* Dark Layout Start */
    let darkThemeVar = darkBtn.addEventListener('click', () => {
        darkFn();
        localStorage.setItem("menoMenu", 'dark');
        localStorage.setItem("menoHeader", 'dark');
        if (html.getAttribute('data-nav-layout') === 'horizontal') {
            html.setAttribute('data-header-styles', 'dark');
        }
    });
    /* Dark Layout End */

    /* Light Menu Start */
    let lightMenuVar = lightMenuBtn.addEventListener('click', () => {
        html.setAttribute('data-menu-styles', 'light');
        localStorage.setItem("menoMenu", 'light');
    });
    /* Light Menu End */

    /* Color Menu Start */
    let colorMenuVar = colorMenuBtn.addEventListener('click', () => {
        html.setAttribute('data-menu-styles', 'color');
        localStorage.setItem("menoMenu", 'color');
    });
    /* Color Menu End */

    /* Dark Menu Start */
    let darkMenuVar = darkMenuBtn.addEventListener('click', () => {
        html.setAttribute('data-menu-styles', 'dark');
        localStorage.setItem("menoMenu", 'dark');
    });
    /* Dark Menu End */

    /* Gradient Menu Start */
    let gradientMenuVar = gradientMenuBtn.addEventListener('click', () => {
        html.setAttribute('data-menu-styles', 'gradient');
        localStorage.setItem("menoMenu", 'gradient');
    });
    /* Gradient Menu End */

    /* Transparent Menu Start */
    let transparentMenuVar = transparentMenuBtn.addEventListener('click', () => {
        html.setAttribute('data-menu-styles', 'transparent');
        localStorage.setItem("menoMenu", 'transparent');
    });
    /* Transparent Menu End */

    /* Light Header Start */
    let lightHeaderVar = lightHeaderBtn.addEventListener('click', () => {
        html.setAttribute('data-header-styles', 'light');
        localStorage.setItem("menoHeader", 'light');
    });
    /* Light Header End */

    /* Color Header Start */
    let colorHeaderVar = colorHeaderBtn.addEventListener('click', () => {
        html.setAttribute('data-header-styles', 'color');
        localStorage.setItem("menoHeader", 'color');
    });
    /* Color Header End */

    /* Dark Header Start */
    let darkHeaderVar = darkHeaderBtn.addEventListener('click', () => {
        html.setAttribute('data-header-styles', 'dark');
        localStorage.setItem("menoHeader", 'dark');
    });
    /* Dark Header End */

    /* Gradient Header Start */
    let gradientHeaderVar = gradientHeaderBtn.addEventListener('click', () => {
        html.setAttribute('data-header-styles', 'gradient');
        localStorage.setItem("menoHeader", 'gradient');
    });
    /* Gradient Header End */

    /* Transparent Header Start */
    let transparentHeaderVar = transparentHeaderBtn.addEventListener('click', () => {
        html.setAttribute('data-header-styles', 'transparent');
        localStorage.setItem("menoHeader", 'transparent');
    });
    /* Transparent Header End */

    /* Default Width Layout Start */
    let defaultwidthVar = defaultwidthBtn.addEventListener('click', () => {
        html.setAttribute('data-width', 'default');
        localStorage.setItem("menodefaultwidth", true);
        localStorage.removeItem("menoboxed");
        localStorage.removeItem("menofullwidth");
    });
    /* Default Width Layout End */

    /* Full Width Layout Start */
    let fullwidthVar = fullwidthBtn.addEventListener('click', () => {
        html.setAttribute('data-width', 'fullwidth');
        localStorage.setItem("menofullwidth", true);
        localStorage.removeItem("menoboxed");
        localStorage.removeItem("menodefaultwidth");
    });
    /* Full Width Layout End */

    /* Boxed Layout Start */
    let boxedVar = boxedBtn.addEventListener('click', () => {
        html.setAttribute('data-width', 'boxed');
        localStorage.setItem("menoboxed", true);
        localStorage.removeItem("menofullwidth");
        localStorage.removeItem("menodefaultwidth");
        checkHoriMenu()
    });
    /* Boxed Layout End */

    /* Regular page style Start */
    let shadowVar = regular.addEventListener('click', () => {
        html.setAttribute('data-page-style', 'regular');
        localStorage.setItem("menoregular", true);
        localStorage.removeItem("menoclassic");
        localStorage.removeItem("menomodern");
    });
    /* Regular page style End */

    /* Classic page style Start */
    let noShadowVar = classic.addEventListener('click', () => {
        html.setAttribute('data-page-style', 'classic');
        localStorage.setItem("menoclassic", true);
        localStorage.removeItem("menoregular");
        localStorage.removeItem("menomodern");
    });
    /* Classic page style End */

    /* modern page style Start */
    let modernVar = modern.addEventListener('click', () => {
        html.setAttribute('data-page-style', 'modern');
        localStorage.setItem("menomodern", true);
        localStorage.removeItem("menoregular");
        localStorage.removeItem("menoclassic");
    });
    /* modern page style End */

    /* Header-Position Styles Start */
    let fixedHeaderVar = fixedHeaderBtn.addEventListener('click', () => {
        html.setAttribute('data-header-position', 'fixed');
        localStorage.setItem("menoheaderfixed", true);
        localStorage.removeItem("menoheaderscrollable");
    });

    let scrollHeaderVar = scrollHeaderBtn.addEventListener('click', () => {
        html.setAttribute('data-header-position', 'scrollable');
        localStorage.setItem("menoheaderscrollable", true);
        localStorage.removeItem("menoheaderfixed");
    });
    /* Header-Position Styles End */

    /* Menu-Position Styles Start */
    let fixedMenuVar = fixedMenuBtn.addEventListener('click', () => {
        html.setAttribute('data-menu-position', 'fixed');
        localStorage.setItem("menomenufixed", true);
        localStorage.removeItem("menomenuscrollable");
    });

    let scrollMenuVar = scrollMenuBtn.addEventListener('click', () => {
        html.setAttribute('data-menu-position', 'scrollable');
        localStorage.setItem("menomenuscrollable", true);
        localStorage.removeItem("menomenufixed");
    });
    /* Menu-Position Styles End */

    /* Default Sidemenu Start */
    let defaultVar = defaultBtn.addEventListener('click', () => {
        html.setAttribute('data-vertical-style', 'default');
        html.setAttribute('data-nav-layout', 'vertical')
        toggleSidemenu();
        localStorage.removeItem("menoverticalstyles");
        document.querySelectorAll(".main-menu>li.open").forEach((ele) => {
            if (!ele.classList.contains('active')) {
                ele.classList.remove('open')
                ele.querySelector('ul').style.display = 'none'
            }
        })
    });
    /* Default Sidemenu End */

    /* Closed Sidemenu Start */
    let closedVar = closedBtn.addEventListener('click', () => {
        closedSidemenuFn();
        localStorage.setItem("menoverticalstyles", 'closed');
        document.querySelectorAll(".main-menu>li.open").forEach((ele) => {
            if (!ele.classList.contains('active')) {
                ele.classList.remove('open')
                ele.querySelector('ul').style.display = 'none'
            }
        })
    });
    /* Closed Sidemenu End */

    /* Hover Submenu Start */
    let detachedVar = detachedBtn.addEventListener('click', () => {
        detachedFn();
        localStorage.setItem("menoverticalstyles", 'detached');
    });
    /* Hover Submenu End */

    /* Icon Text Sidemenu Start */
    let iconTextVar = iconTextBtn.addEventListener('click', () => {
        iconTextFn();
        localStorage.setItem("menoverticalstyles", 'icontext');
    });
    /* Icon Text Sidemenu End */

    /* Icon Overlay Sidemenu Start */
    let overlayVar = overlayBtn.addEventListener('click', () => {
        iconOverayFn();
        localStorage.setItem("menoverticalstyles", 'overlay');
        document.querySelectorAll(".main-menu>li.open").forEach((ele) => {
            if (!ele.classList.contains('active')) {
                ele.classList.remove('open')
                ele.querySelector('ul').style.display = 'none'
            }
        })
    });
    /* Icon Overlay Sidemenu End */

    /* doublemenu Sidemenu Start */
    let doubleVar = doubleBtn.addEventListener('click', () => {
        doubletFn();
        localStorage.setItem("menoverticalstyles", 'doublemenu');
    });
    /* doublemenu Sidemenu End */

    /* Menu Click Sidemenu Start */
    let menuClickVar = menuClickBtn.addEventListener('click', () => {
        html.removeAttribute('data-vertical-style');
        menuClickFn();
        localStorage.setItem("menonavstyles", 'menu-click');
        localStorage.removeItem("menoverticalstyles");
        document.querySelectorAll(".main-menu>li.open").forEach((ele) => {
            if (!ele.classList.contains('active')) {
                ele.classList.remove('open')
                ele.querySelector('ul').style.display = 'none'
            }
        })
        if (document.querySelector("html").getAttribute("data-nav-layout") == 'horizontal') {
            document.querySelector(".main-menu").style.marginLeft = "0px"
            document.querySelector(".main-menu").style.marginRight = "0px"
            ResizeMenu()
        }
    });
    /* Menu Click Sidemenu End */

    /* Menu Hover Sidemenu Start */
    let menuhoverVar = menuHoverBtn.addEventListener('click', () => {
        html.removeAttribute('data-vertical-style');
        menuhoverFn();
        localStorage.setItem("menonavstyles", 'menu-hover');
        localStorage.removeItem("menoverticalstyles");

        if (document.querySelector("html").getAttribute("data-nav-layout") == 'horizontal') {
            document.querySelector(".main-menu").style.marginLeft = "0px"
            document.querySelector(".main-menu").style.marginRight = "0px"
            ResizeMenu()
        }
    });
    /* Menu Hover Sidemenu End */

    /* icon Click Sidemenu Start */
    let iconClickVar = iconClickBtn.addEventListener('click', () => {
        html.removeAttribute('data-vertical-style');
        iconClickFn();
        localStorage.setItem("menonavstyles", 'icon-click');
        localStorage.removeItem("menoverticalstyles");

        if (document.querySelector("html").getAttribute("data-nav-layout") == 'horizontal') {
            document.querySelector(".main-menu").style.marginLeft = "0px"
            document.querySelector(".main-menu").style.marginRight = "0px"
            ResizeMenu()
            document.querySelector("#slide-left").classList.add("d-none")
        }
        document.querySelectorAll(".main-menu>li.open").forEach((ele) => {
            if (!ele.classList.contains('active')) {
                ele.classList.remove('open')
                ele.querySelector('ul').style.display = 'none'
            }
        })
    });
    /* icon Click Sidemenu End */

    /* icon hover Sidemenu Start */
    let iconhoverVar = iconHoverBtn.addEventListener('click', () => {
        html.removeAttribute('data-vertical-style');
        iconHoverFn();
        localStorage.setItem("menonavstyles", 'icon-hover');
        localStorage.removeItem("menoverticalstyles");

        if (document.querySelector("html").getAttribute("data-nav-layout") == 'horizontal') {
            document.querySelector(".main-menu").style.marginLeft = "0px"
            document.querySelector(".main-menu").style.marginRight = "0px"
            ResizeMenu()
            document.querySelector("#slide-left").classList.add("d-none")
        }
    });
    /* icon hover Sidemenu End */

    /* Sidemenu start*/
    let verticalVar = verticalBtn.addEventListener('click', () => {
        let mainContent = document.querySelector('.main-content');
        // local storage
        localStorage.removeItem("menolayout");
        localStorage.setItem("menoverticalstyles", 'default');
        verticalFn();
        setNavActive();
        mainContent.removeEventListener('click', clearNavDropdown);

        //
        document.querySelector(".main-menu").style.marginLeft = "0px"
        document.querySelector(".main-menu").style.marginRight = "0px"

        document.querySelectorAll(".slide").forEach((element) => {
            if (
                element.classList.contains("open") &&
                !element.classList.contains("active")
            ) {
                element.querySelector("ul").style.display = "none";
            }
        });
    });
    /* Sidemenu end */

    /* horizontal start*/
    let horiVar = horiBtn.addEventListener('click', () => {
        let mainContent = document.querySelector('.main-content');
        html.removeAttribute('data-vertical-style');
        //    local storage
        localStorage.setItem("menolayout", 'horizontal');
        localStorage.removeItem("menoverticalstyles");

        if (html.getAttribute('data-nav-layout') === 'horizontal') {
            if (html.getAttribute('data-theme-mode') === 'light') {
                html.setAttribute('data-header-styles', 'light');
            } else if (html.getAttribute('data-theme-mode') === 'dark') {
                html.setAttribute('data-header-styles', 'dark');
            }
        }
        horizontalClickFn();
        clearNavDropdown();
        mainContent.addEventListener('click', clearNavDropdown);
    });
    /* horizontal end*/

    /* rtl start */
    let rtlVar = rtlBtn.addEventListener('click', () => {
        localStorage.setItem("menortl", true);
        localStorage.removeItem("menoltr");
        rtlFn();
        if (document.querySelector(".noUi-target")) {
            console.log("working");
            document.querySelectorAll(".noUi-origin").forEach((e) => {
                e.classList.add("transform-none");
            });
        }
    });
    /* rtl end */

    /* ltr start */
    let ltrVar = ltrBtn.addEventListener('click', () => {
        //    local storage
        localStorage.setItem("menoltr", true);
        localStorage.removeItem("menortl");
        ltrFn();
        if (document.querySelector(".noUi-target")) {
            document.querySelectorAll(".noUi-origin").forEach((e) => {
                e.classList.remove("transform-none");
            });
        }
    });
    /* ltr end */

    // reset all start
    let resetVar = ResetAll.addEventListener('click', () => {
        ResetAllFn();
        setNavActive();
        document.querySelector("html").setAttribute("data-menu-styles", "light");
        document.querySelector("html").setAttribute("data-width", "fullwidth");
        document.querySelector('#switcher-menu-light').checked = true;
        document.querySelectorAll(".slide").forEach((element) => {
            if (
                element.classList.contains("open") &&
                !element.classList.contains("active")
            ) {
                element.querySelector("ul").style.display = "none";
            }
        });
    })
    // reset all end

    /* loader start */
    loaderEnable.onclick = () => {
        document.querySelector("html").setAttribute("loader", "enable");
        localStorage.setItem("loaderEnable", "true")
    }

    loaderDisable.onclick = () => {
        document.querySelector("html").setAttribute("loader", "disable");
        localStorage.setItem("loaderEnable", "false")
    }
    /* loader end */
}

function ltrFn() {
    let html = document.querySelector('html')
    if (!document.querySelector("#style").href.includes('bootstrap.min.css')) {
        document.querySelector("#style")?.setAttribute("href", "assets/libs/bootstrap/css/bootstrap.min.css");
    }
    html.setAttribute("dir", "ltr");
    document.querySelector('#switcher-ltr').checked = true;
    checkOptions();
}

function rtlFn() {
    let html = document.querySelector('html');
    html.setAttribute("dir", "rtl");
    document.querySelector("#style")?.setAttribute("href", "assets/libs/bootstrap/css/bootstrap.rtl.min.css");
    checkOptions();
}

function lightFn() {
    let html = document.querySelector('html');
    html.setAttribute('data-theme-mode', 'light');
    html.setAttribute('data-header-styles', 'light');
    html.setAttribute('data-menu-styles', 'light');
    if (!localStorage.getItem('primaryRGB')) {
        html.setAttribute('style', '')
    }
    document.querySelector('#switcher-light-theme').checked = true;
    document.querySelector('#switcher-menu-light').checked = true;
    document.querySelector('#switcher-header-light').checked = true;
    localStorage.removeItem("menodarktheme");
    localStorage.removeItem("menobgColor");
    localStorage.removeItem("menoheaderbg");
    localStorage.removeItem("menobgwhite");
    localStorage.removeItem("menomenubg");
    localStorage.removeItem("menomenubg");
    checkOptions();
    html.style.removeProperty('--body-bg-rgb');
    html.style.removeProperty('--body-bg-rgb2');
    html.style.removeProperty("--light-rgb");
    html.style.removeProperty("--form-control-bg");
    html.style.removeProperty("--gray-3");
    html.style.removeProperty("--input-border");

    document.querySelector("#switcher-background4").checked = false
    document.querySelector("#switcher-background3").checked = false
    document.querySelector("#switcher-background2").checked = false
    document.querySelector("#switcher-background1").checked = false
    document.querySelector("#switcher-background").checked = false
    document.querySelector('#switcher-menu-light').checked = true;
    document.querySelector('#switcher-header-light').checked = true;

}

function darkFn() {
    let html = document.querySelector('html');
    html.setAttribute('data-theme-mode', 'dark');
    html.setAttribute('data-header-styles', 'dark');
    html.setAttribute('data-menu-styles', 'dark');
    if (!localStorage.getItem('primaryRGB')) {
        html.setAttribute('style', '')
    }
    document.querySelector('#switcher-menu-dark').checked = true;
    document.querySelector('#switcher-header-dark').checked = true;
    document.querySelector('html').style.removeProperty('--body-bg-rgb');
    document.querySelector('html').style.removeProperty('--body-bg-rgb2');
    document.querySelector('html').style.removeProperty('--light-rgb');
    document.querySelector('html').style.removeProperty('--form-control-bg');
    document.querySelector('html').style.removeProperty('--gray-3');
    document.querySelector('html').style.removeProperty('--input-border');
    localStorage.setItem("menodarktheme", true);
    localStorage.removeItem("menolighttheme");
    localStorage.removeItem("bodyBgRGB");
    localStorage.removeItem("menobgColor");
    localStorage.removeItem("menoheaderbg");
    localStorage.removeItem("menobgwhite");
    localStorage.removeItem("menomenubg");
    checkOptions();

    document.querySelector("#switcher-background4").checked = false
    document.querySelector("#switcher-background3").checked = false
    document.querySelector("#switcher-background2").checked = false
    document.querySelector("#switcher-background1").checked = false
    document.querySelector("#switcher-background").checked = false
    document.querySelector('#switcher-menu-dark').checked = true;
    document.querySelector('#switcher-header-dark').checked = true;
}

function verticalFn() {
    let html = document.querySelector('html');
    html.setAttribute('data-nav-layout', 'vertical');
    html.setAttribute('data-vertical-style', 'overlay');
    html.removeAttribute('data-nav-style');
    localStorage.removeItem('menonavstyles');
    html.removeAttribute('data-toggled');
    document.querySelector('#switcher-vertical').checked = true;
    document.querySelector('#switcher-menu-click').checked = false;
    document.querySelector('#switcher-menu-hover').checked = false;
    document.querySelector('#switcher-icon-click').checked = false;
    document.querySelector('#switcher-icon-hover').checked = false;
    checkOptions();
}

function horizontalClickFn() {
    document.querySelector('#switcher-horizontal').checked = true;
    document.querySelector('#switcher-menu-click').checked = true;
    localStorage.setItem("menonavstyles", 'menu-click');
    let html = document.querySelector('html');
    html.setAttribute('data-nav-layout', 'horizontal');
    html.removeAttribute('data-vertical-style');
    if (!html.getAttribute('data-nav-style')) {
        html.setAttribute('data-nav-style', 'menu-click');
    }
    if (html.getAttribute('data-nav-layout') === 'horizontal' && !localStorage.menoHeader) { 
        if (html.getAttribute('data-theme-mode') === 'light') {
            html.setAttribute('data-header-styles', 'light');
        } else if (html.getAttribute('data-theme-mode') === 'dark') {
            html.setAttribute('data-header-styles', 'dark');
        }
    }
    if (!localStorage.menoMenu && !localStorage.bodylightRGB) {
        html.setAttribute("data-menu-styles", "light")
        document.querySelector('#switcher-menu-light').checked = true;
        checkOptions();
    }
    checkOptions();
    checkHoriMenu();
}


function ResetAllFn() {
    let html = document.querySelector('html');
    if (localStorage.getItem("menolayout") == "horizontal") {
        document.querySelector(".main-menu").style.display = "block"
    }
    checkOptions();

    // clearing localstorage
    localStorage.clear();

    // reseting to light
    lightFn();

    //To reset the light-rgb
    document.querySelector('html').removeAttribute("style")

    // clearing attibutes
    // removing header, menu, pageStyle & boxed
    html.removeAttribute('data-nav-style');
    html.removeAttribute('data-menu-position');
    html.removeAttribute('data-header-position');
    html.removeAttribute('data-page-style');

    // removing theme styles
    html.removeAttribute('data-bg-img');

    // clear primary & bg color
    html.style.removeProperty(`--primary-rgb`);
    html.style.removeProperty(`--body-bg-rgb`);

    // reseting to ltr
    ltrFn();

    // reseting to vertical
    verticalFn();
    mainContent.removeEventListener('click', clearNavDropdown);

    // reseting page style
    document.querySelector('#switcher-classic').checked = false;
    document.querySelector('#switcher-modern').checked = false;
    document.querySelector('#switcher-regular').checked = true;

    // reseting layout width styles
    document.querySelector('#switcher-default-width').checked = false;
    document.querySelector('#switcher-full-width').checked = true;
    document.querySelector('#switcher-boxed').checked = false;

    // reseting menu position styles
    document.querySelector('#switcher-menu-fixed').checked = true;
    document.querySelector('#switcher-menu-scroll').checked = false;

    // reseting header position styles
    document.querySelector('#switcher-header-fixed').checked = true;
    document.querySelector('#switcher-header-scroll').checked = false;

    // reseting sidemenu layout styles
    document.querySelector('#switcher-default-menu').checked = true;
    document.querySelector('#switcher-closed-menu').checked = false;
    document.querySelector('#switcher-icontext-menu').checked = false;
    document.querySelector('#switcher-icon-overlay').checked = false;
    document.querySelector('#switcher-detached').checked = false;
    document.querySelector('#switcher-double-menu').checked = false;

    // resetting theme primary
    document.querySelector("#switcher-primary").checked = false
    document.querySelector("#switcher-primary1").checked = false
    document.querySelector("#switcher-primary2").checked = false
    document.querySelector("#switcher-primary3").checked = false
    document.querySelector("#switcher-primary4").checked = false

    // resetting theme background
    document.querySelector("#switcher-background").checked = false
    document.querySelector("#switcher-background1").checked = false
    document.querySelector("#switcher-background2").checked = false
    document.querySelector("#switcher-background3").checked = false
    document.querySelector("#switcher-background4").checked = false

    // to reset horizontal menu scroll
    document.querySelector(".main-menu").style.marginLeft = "0px"
    document.querySelector(".main-menu").style.marginRight = "0px"
}

function checkOptions() {

    // dark
    if (localStorage.getItem('menodarktheme')) {
        document.querySelector('#switcher-dark-theme').checked = true;
    }

    // horizontal
    if (localStorage.getItem('menolayout') === "horizontal") {
        document.querySelector('#switcher-horizontal').checked = true;
        document.querySelector('#switcher-menu-click').checked = true;
    }
    else {
        document.querySelector('#switcher-vertical').checked = true;
    }

    //RTL
    if (localStorage.getItem('menortl')) {
        document.querySelector('#switcher-rtl').checked = true;
    }
    else {
        document.querySelector('#switcher-ltr').checked = true;
    }

    // light header
    if (localStorage.getItem('menoHeader') === "light") {
        document.querySelector('#switcher-header-light').checked = true;
    }

    // color header
    if (localStorage.getItem('menoHeader') === "color") {
        document.querySelector('#switcher-header-primary').checked = true;
    }

    // gradient header
    if (localStorage.getItem('menoHeader') === "gradient") {
        document.querySelector('#switcher-header-gradient').checked = true;
    }

    // dark header
    if (localStorage.getItem('menoHeader') === "dark") {
        document.querySelector('#switcher-header-dark').checked = true;
    }
    // transparent header
    if (localStorage.getItem('menoHeader') === "transparent") {
        document.querySelector('#switcher-header-transparent').checked = true;
    }

    // light menu
    if (localStorage.getItem('menoMenu') === 'light') {
        document.querySelector('#switcher-menu-light').checked = true;
    }

    // color menu
    if (localStorage.getItem('menoMenu') === 'color') {
        document.querySelector('#switcher-menu-primary').checked = true;
    }

    // gradient menu
    if (localStorage.getItem('menoMenu') === 'gradient') {
        document.querySelector('#switcher-menu-gradient').checked = true;
    }

    // dark menu
    if (localStorage.getItem('menoMenu') === 'dark') {
        document.querySelector('#switcher-menu-dark').checked = true;
    }
    // transparent menu
    if (localStorage.getItem('menoMenu') === 'transparent') {
        document.querySelector('#switcher-menu-transparent').checked = true;
    }

    //default width
    if (localStorage.getItem('menodefaultwidth')) {
        document.querySelector('#switcher-default-width').checked = true;
    }

    //full width
    if (localStorage.getItem('menofullwidth')) {
        document.querySelector('#switcher-full-width').checked = true;
    }

    //boxed
    if (localStorage.getItem('menoboxed')) {
        document.querySelector('#switcher-boxed').checked = true;
    }

    //scrollable
    if (localStorage.getItem('menoheaderscrollable')) {
        document.querySelector('#switcher-header-scroll').checked = true;
    }
    if (localStorage.getItem('menomenuscrollable')) {
        document.querySelector('#switcher-menu-scroll').checked = true;
    }

    //fixed
    if (localStorage.getItem('menoheaderfixed')) {
        document.querySelector('#switcher-header-fixed').checked = true;
    }
    if (localStorage.getItem('menomenufixed')) {
        document.querySelector('#switcher-menu-fixed').checked = true;
    }

    //classic
    if (localStorage.getItem('menoclassic')) {
        document.querySelector('#switcher-classic').checked = true;
    }

    //modern
    if (localStorage.getItem('menomodern')) {
        document.querySelector('#switcher-modern').checked = true;
    }

    // sidemenu layout style
    if (localStorage.menoverticalstyles) {
        let verticalStyles = localStorage.getItem('menoverticalstyles');
        switch (verticalStyles) {
            case 'default':
                document.querySelector('#switcher-default-menu').checked = true;
                break;
            case 'closed':
                document.querySelector('#switcher-closed-menu').checked = true;
                break;
            case 'icontext':
                document.querySelector('#switcher-icontext-menu').checked = true;
                break;
            case 'overlay':
                document.querySelector('#switcher-icon-overlay').checked = true;
                break;
            case 'detached':
                document.querySelector('#switcher-detached').checked = true;
                break;
            case 'doublemenu':
                document.querySelector('#switcher-double-menu').checked = true;
                break;
            default:
                document.querySelector('#switcher-default-menu').checked = true;
                break;
        }
    }
    // navigation menu style
    if (localStorage.menonavstyles) {
        let navStyles = localStorage.getItem('menonavstyles');
        switch (navStyles) {
            case 'menu-click':
                document.querySelector('#switcher-menu-click').checked = true;
                break;
            case 'menu-hover':
                document.querySelector('#switcher-menu-hover').checked = true;
                break;
            case 'icon-click':
                document.querySelector('#switcher-icon-click').checked = true;
                break;
            case 'icon-hover':
                document.querySelector('#switcher-icon-hover').checked = true;
                break;
        }
    }

    // loader
    if (localStorage.loaderEnable != "true") {
        document.querySelector("#switcher-loader-disable").checked = true
    }
}

function localStorageBackup2() {
    if (localStorage.bodyBgRGB || localStorage.bodylightRGB) {
        document.querySelector('#switcher-dark-theme').checked = true;
        document.querySelector('#switcher-menu-dark').checked = true;
        document.querySelector('#switcher-header-dark').checked = true;
    }

    if (localStorage.bodyBgRGB && localStorage.bodylightRGB) {
        if (localStorage.bodyBgRGB == "59, 32, 110") {
            document.querySelector("#switcher-background").checked = true
        }
        if (localStorage.bodyBgRGB == "4, 59, 103") {
            document.querySelector("#switcher-background1").checked = true
        }
        if (localStorage.bodyBgRGB == "95, 4, 103") {
            document.querySelector("#switcher-background2").checked = true
        }
        if (localStorage.bodyBgRGB == "1, 58, 21") {
            document.querySelector("#switcher-background3").checked = true
        }
        if (localStorage.bodyBgRGB == "83, 51, 4") {
            document.querySelector("#switcher-background4").checked = true
        }
    }

    if (localStorage.primaryRGB) {
        if (localStorage.primaryRGB == "119, 60, 211") {
            document.querySelector("#switcher-primary").checked = true
        }
        if (localStorage.primaryRGB == "28, 121, 196") {
            document.querySelector("#switcher-primary1").checked = true
        }
        if (localStorage.primaryRGB == "163, 33, 201") {
            document.querySelector("#switcher-primary2").checked = true
        }
        if (localStorage.primaryRGB == "29, 174, 87") {
            document.querySelector("#switcher-primary3").checked = true
        }
        if (localStorage.primaryRGB == "174, 115, 29") {
            document.querySelector("#switcher-primary4").checked = true
        }
    }

    if (localStorage.loaderEnable == "true") {
        document.querySelector("#switcher-loader-enable").checked = true
    }
}



