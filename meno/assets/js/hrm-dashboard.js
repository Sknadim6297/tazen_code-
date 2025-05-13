(function () {
  'use strict';

  /* preformance category */
  var options = {  
    series: [{
      name: 'Development',
      data: [100, 95, 25, 77, 90, 45, 55, 68, 75, 25, 95, 110],
      type: 'bar',
    }, {
      name: 'Management',
      data: [45, 85, 50, 80, 95, 50, 90, 78, 100, 125, 130, 70],
      type: 'area',
    }, {
      name: 'Designing',
      data: [30, 120, 60, 80, 60, 80, 40, 75, 50, 85, 60, 65],
      type: 'line',
    }],
    chart: {
      height: 450,
      type: 'line',
      toolbar: {
        show: false,
      },
      zoom: {
        enabled: false,
      },
      background: 'none',
      fill: "#fff",
      dropShadow: {
        enabled: true,
        enabledOnSeries: undefined,
        top: 10,
        left: 0,
        blur: 0,
        color: 'var(--primary-color)',
        opacity: 0.05
      },
    },
    plotOptions: {
      bar: {
        borderRadius: 2,
        columnWidth: '20%',
      }
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
    colors: ["var(--primary-color)", "rgba(var(--secondary-rgb), 1)", "rgba(var(--pink-rgb), 1)"],
    background: 'transparent',
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth',
      width: 2,
      dashArray: [0, 0, 6]
    },
    dataLabels: {
      enabled: false,
    },
    legend: {
      show: true,
      position: 'top',
      markers: {
        width: 8,
        height: 8,
      }
    },
    xaxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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
    fill: {
      type: ['solid', 'gradient', 'solid'],
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.4,
        type: "vertical",
        opacityTo: 0.1,
        stops: [0, 90, 100],
        colorStops: [
          [
            {
              offset: 100,
              color: 'var(--primary-color)',
              opacity: 1
            }
          ],
          [
              {
                  offset: 0,
                  color: "rgba(var(--secondary-rgb), 0.3)",
                  opacity: 1
              },
              {
                  offset: 75,
                  color: "rgba(var(--secondary-rgb), 0.05)",
                  opacity: 0.5
              },
              {
                  offset: 100,
                  color: 'rgba(var(--secondary-rgb), 0.05)',
                  opacity: 0.1
              }
          ],
          [
              {
                  offset: 100,
                  color: 'rgba(var(--pink-rgb), 1)',
                  opacity: 1
              }
          ],
        ]
      }
    },
    tooltip: {
      x: {
        format: 'dd/MM/yy HH:mm'
      },
    },
  };
  var chart = new ApexCharts(document.querySelector("#preformance-category"), options);
  chart.render();
  /* preformance category */
})();

/* Source Overview */
var options = {
  series: [{
    name: 'Linked In',
    data: [80, 50, 30, 40, 100, 20, 40],
  }, {
    name: 'Twitter',
    data: [20, 30, 40, 90, 20, 90, 35],
  }, {
    name: 'Chrome',
    data: [40, 76, 78, 13, 43, 10, 80],
  }],
  chart: {
    height: 256,
    type: 'radar',
    toolbar: {
      show: false,
    }
  },
  title: {
    align: 'left',
    style: {
      fontSize: '13px',
      fontWeight: 'bold',
      color: '#8c9097'
    },
  },
  colors: ["var(--primary09)", "rgba(var(--secondary-rgb), 0.9)", "rgba(var(--success-rgb), 0.9)"],
  stroke: {
    width: 1
  },
  fill: {
    opacity: 0.05
  },
  markers: {
    size: 0
  },
  legend: {
    show: true,
    fontSize: "12px",
    position: 'top',
    horizontalAlign: 'center',
    fontFamily: "Montserrat",
    fontWeight: 500,
    offsetX: 0,
    offsetY: -5,
    height: 50,
    labels: {
      colors: '#9ba5b7',
    },
    markers: {
      width: 7,
      height: 7,
      strokeWidth: 0,
      strokeColor: '#fff',
      fillColors: undefined,
      radius: 7,
      offsetX: 0,
      offsetY: 0
    },
  },
  xaxis: {
    categories: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
  },
  yaxis: {
    tickAmount: 7,
    labels: {
      formatter: function (val, i) {
        if (i % 5 === 0) {
          return val
        }
      }
    }
  }
};

// Ensure the element exists in your HTML before rendering
var chart = new ApexCharts(document.querySelector("#source-overview"), options);
chart.render();

/* Source Overview */