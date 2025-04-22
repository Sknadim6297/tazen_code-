
function updateTimer() {
    future = Date.parse("Dec 19, 2025 11:30:00");
    now = new Date();
    diff = future - now;

    days = Math.floor(diff / (1000 * 60 * 60 * 24));
    hours = Math.floor(diff / (1000 * 60 * 60));
    mins = Math.floor(diff / (1000 * 60));
    secs = Math.floor(diff / 1000);

    d = days;
    h = hours - days * 24;
    m = mins - hours * 60;
    s = secs - mins * 60;

    document.getElementById("timer")
        .innerHTML =
        '<div><div class="border border-primary coming-soon-custom border-opacity-10 rounded p-3 px-4 bg-primary-transparent"><p class="mb-2">Days</p><h4 class="mb-0 text-default fw-semibold">' + d + '</h4></div></div>' +
        '<div><div class="border border-secondary coming-soon-custom border-opacity-10 rounded p-3 px-4 bg-secondary-transparent"><p class="mb-2">Hours</p><h4 class="mb-0 text-default fw-semibold">' + h + '</h4></div></div>' +
        '<div><div class="border border-success coming-soon-custom border-opacity-10 rounded p-3 px-4 bg-success-transparent"><p class="mb-2">Minutes</p><h4 class="mb-0 text-default fw-semibold">' + m + '</h4></div></div>' +
        '<div><div class="border border-pink coming-soon-custom border-opacity-10 rounded p-3 px-4 bg-pink-transparent"><p class="mb-2">Seconds</p><h4 class="mb-0 text-default fw-semibold">' + s + '</h4></div></div>'
}
setInterval('updateTimer()', 1000);


/* anime js */
var pathEls = document.querySelectorAll('path');
for (var i = 0; i < pathEls.length; i++) {
  var pathEl = pathEls[i];
  var offset = anime.setDashoffset(pathEl);
  pathEl.setAttribute('stroke-dashoffset', offset);
  anime({
    targets: pathEl,
    strokeDashoffset: [offset, 0],
    duration: anime.random(1000, 3000),
    delay: anime.random(0, 2000),
    loop: true,
    direction: 'alternate',
    easing: 'easeInOutSine',
    autoplay: true
  });
}
/* anime js */