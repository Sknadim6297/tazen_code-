(function () {
    "use strict";
      /* Visitors Report */
  var options = {
    series: [
      {
        name: "This Week",
        data: [25, 50, 30, 55, 20, 45, 30],
        type: 'column',
      },
      {
        name: "Last Week",
        data: [35, 25, 40, 30, 45, 35, 60],
        type: 'line',
      }
    ],
    chart: {
      height: 245,
      type: 'line',
      toolbar: {
        show: false
      },
      zoom: {
        enabled: false,
      },
      dropShadow: {
        enabled: true,
        enabledOnSeries: undefined,
        top: 7,
        left: 0,
        blur: 1,
        color: ["transparent", "rgb(255, 90, 41)"],
        opacity: 0.05,
      },
    },
    plotOptions: {
      bar: {
        columnWidth: '35%',
        borderRadius: [2],
      }
    },
    colors: ['var(--primary-color)', 'rgb(255, 90, 41)'],
    dataLabels: {
      enabled: false,
    },
    stroke: {
      curve: 'smooth',
      width: 2,
      dashArray: [0, 0],
    },
    grid: {
      borderColor: "#f1f1f1",
      strokeDashArray: 2,
      xaxis: {
        lines: {
          show: true
        }
      },
      yaxis: {
        lines: {
          show: false
        }
      }
    },
    yaxis: {
      show: false,
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      }
    },
    xaxis: {
      categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      show: false,
      axisBorder: {
        show: false,
        color: 'rgba(119, 119, 142, 0.05)',
        offsetX: 0,
        offsetY: 0,
      },
      axisTicks: {
        show: false,
        borderType: 'solid',
        color: 'rgba(119, 119, 142, 0.05)',
        width: 6,
        offsetX: 0,
        offsetY: 0
      },
      labels: {
        rotate: -90,
      }
    },
    legend: {
      show: true,
      position: "bottom",
      offsetX: 0,
      offsetY: 8,
      markers: {
        size: 4,
        strokeWidth: 0,
        strokeColor: '#fff',
        fillColors: undefined,
        radius: 5,
        customHTML: undefined,
        onClick: undefined,
        offsetX: 0,
        offsetY: 0
      },
    },
  };
  var chart = new ApexCharts(document.querySelector("#visitors-report"), options);
  chart.render();
  /* Visitors Report */

})();