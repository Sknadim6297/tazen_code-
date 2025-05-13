(function () {
  "use strict";
  /* students */
  var options = {
    series: [{
      data: [98, 110, 80, 145, 105, 112, 87, 148, 102]
    }],
    chart: {
      height: 55,
      type: 'area',
      fontFamily: 'Montserrat, sans-serif',
      foreColor: '#5d6162',
      zoom: {
        enabled: false
      },
      sparkline: {
        enabled: true
      }
    },
    tooltip: {
      enabled: true,
      theme: "dark",
      x: {
        show: false
      },
      y: {
        title: {
          formatter: function (seriesName) {
            return ''
          }
        }
      },
      marker: {
        show: false
      }
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth',
      width: [1.5],
    },
    fill: {
      type: 'gradient',
      gradient: {
        opacityFrom: 0.5,
        opacityTo: 0.2,
        stops: [0, 60],
        colorStops: [
          [
            {
              offset: 0,
              color: 'var(--primary01)',
              opacity: 1
            },
            {
              offset: 60,
              color: 'var(--primary01)',
              opacity: 1
            }
          ],
        ]
      },
    },
    title: {
      text: undefined,
    },
    grid: {
      borderColor: 'transparent',
    },
    xaxis: {
      crosshairs: {
        show: false,
      }
    },
    colors: ["var(--primary-color)"],
  };
  var chart1 = new ApexCharts(document.querySelector("#total-students"), options);
  chart1.render();
  /* students */

  /* Instructors */
  var options = {
    series: [{
      data: [98, 110, 80, 145, 105, 112, 87, 148, 102]
    }],
    chart: {
      height: 55,
      type: 'area',
      fontFamily: 'Montserrat, sans-serif',
      foreColor: '#5d6162',
      zoom: {
        enabled: false
      },
      sparkline: {
        enabled: true
      }
    },
    tooltip: {
      enabled: true,
      theme: "dark",
      x: {
        show: false
      },
      y: {
        title: {
          formatter: function (seriesName) {
            return ''
          }
        }
      },
      marker: {
        show: false
      }
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth',
      width: [1.5],
    },
    title: {
      text: undefined,
    },
    grid: {
      borderColor: 'transparent',
    },
    xaxis: {
      crosshairs: {
        show: false,
      }
    },
    colors: ["rgba(var(--secondary-rgb), 1)"],
    fill: {
      type: 'gradient',
      gradient: {
        opacityFrom: 0.5,
        opacityTo: 0.2,
        stops: [0, 60],
        colorStops: [
          [
            {
              offset: 0,
              color: 'rgba(var(--secondary-rgb), .1)',
              opacity: 1
            },
            {
              offset: 60,
              color: 'rgba(var(--secondary-rgb), .1)',
              opacity: 1
            }
          ],
        ]
      },
    },
  };
  var chart2 = new ApexCharts(document.querySelector("#instructors"), options);
  chart2.render();
  /* Instructors */

  /* Courses */
  var options = {
    series: [{
      data: [98, 110, 80, 145, 105, 112, 87, 148, 102]
    }],
    chart: {
      height: 55,
      type: 'area',
      fontFamily: 'Montserrat, sans-serif',
      foreColor: '#5d6162',
      zoom: {
        enabled: false
      },
      sparkline: {
        enabled: true
      }
    },
    tooltip: {
      enabled: true,
      theme: "dark",
      x: {
        show: false
      },
      y: {
        title: {
          formatter: function (seriesName) {
            return ''
          }
        }
      },
      marker: {
        show: false
      }
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth'
    },
    title: {
      text: undefined,
    },
    grid: {
      borderColor: 'transparent',
    },
    xaxis: {
      crosshairs: {
        show: false,
      }
    },
    colors: ["rgba(var(--success-rgb), 1)"],
    fill: {
      type: 'gradient',
      gradient: {
        opacityFrom: 0.5,
        opacityTo: 0.2,
        stops: [0, 60],
        colorStops: [
          [
            {
              offset: 0,
              color: 'rgba(var(--success-rgb), .1)',
              opacity: 1
            },
            {
              offset: 60,
              color: 'rgba(var(--success-rgb), .1)',
              opacity: 1
            }
          ],
        ]
      },
    },
    stroke: {
      width: [1.5],
    }
  };
  var chart3 = new ApexCharts(document.querySelector("#courses"), options);
  chart3.render();
  /* Courses */

  /* Revenue */
  var options = {
    series: [{
      data: [98, 110, 80, 145, 105, 112, 87, 148, 102]
    }],
    chart: {
      height: 55,
      type: 'area',
      fontFamily: 'Montserrat, sans-serif',
      foreColor: '#5d6162',
      zoom: {
        enabled: false
      },
      sparkline: {
        enabled: true
      }
    },
    tooltip: {
      enabled: true,
      theme: "dark",
      x: {
        show: false
      },
      y: {
        title: {
          formatter: function (seriesName) {
            return ''
          }
        }
      },
      marker: {
        show: false
      }
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth'
    },
    title: {
      text: undefined,
    },
    grid: {
      borderColor: 'transparent',
    },
    xaxis: {
      crosshairs: {
        show: false,
      }
    },
    colors: ["rgba(var(--pink-rgb), 1)"],
    stroke: {
      width: [1.5],
    },
    fill: {
      type: 'gradient',
      gradient: {
        opacityFrom: 0.5,
        opacityTo: 0.2,
        stops: [0, 60],
        colorStops: [
          [
            {
              offset: 0,
              color: 'rgba(var(--pink-rgb), 0.1)',
              opacity: 1
            },
            {
              offset: 60,
              color: 'rgba(var(--pink-rgb), 0.1)',
              opacity: 1
            }
          ],
        ]
      },
    },
  };
  var chart4 = new ApexCharts(document.querySelector("#courses-revenue"), options);
  chart4.render();
  /* Revenue */

  /* Revenue statistics */
  var options = {
    series: [
        {
            name: "Total Income",
            data: [100, 210, 180, 454, 454, 230, 230, 656, 656, 350, 350, 210],
        },
        {
            type: "bar",
            name: "Total Revenue",
            data: [200, 530, 110, 130, 480, 520, 780, 435, 475, 738, 454, 480],
        }
    ],
    chart: {
        type: "line",
        height: 375,
        toolbar: {
            show: false
        },
        zoom: {
            enabled: false
        },
        dropShadow: {
            enabled: false,
            enabledOnSeries: undefined,
            top: 0,
            left: 0,
            blur: 4,
            color: '#000',
            opacity: 0.3
        }
    },
    colors: [
        "var(--primary-color)",
        "rgba(var(--secondary-rgb), 1)",
    ],
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '37%',
        borderRadius: 1,
      },
    },
    dataLabels: {
        enabled: false,
    },
    legend: {
        show: true,
        position: "top",
        offsetX: 0,
        offsetY: 8,
        markers: {
            width: 5,
            height: 5,
            size: 5,
            shape: "circle",
            strokeWidth: 0,
            strokeColor: '#fff',
            fillColors: undefined,
            radius: 12,
            customHTML: undefined,
            onClick: undefined,
            offsetX: 0,
            offsetY: 0
        },
    },
    stroke: {
        curve: ['smooth', 'smooth'],
        width: [2, 2],
        lineCap: 'round',
    },
    grid: {
        borderColor: '#f1f1f1',
        strokeDashArray: 3
    },
    yaxis: {
        axisBorder: {
            show: true,
            color: "rgba(119, 119, 142, 0.05)",
            offsetX: 0,
            offsetY: 0,
        },
        axisTicks: {
            show: true,
            borderType: "solid",
            color: "rgba(119, 119, 142, 0.05)",
            width: 6,
            offsetX: 0,
            offsetY: 0,
        },
    },
    xaxis: {
        type: "month",
        categories: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "sep",
            "oct",
            "nov",
            "dec",
        ],
        axisBorder: {
            // show: false,
            color: "rgba(119, 119, 142, 0.05)",
            offsetX: 0,
            offsetY: 0,
        },
        axisTicks: {
            show: false,
            borderType: "solid",
            color: "rgba(119, 119, 142, 0.05)",
            width: 6,
            offsetX: 0,
            offsetY: 0,
        },
        labels: {
            rotate: -90,
        },
    },
  };
  var chart = new ApexCharts(document.querySelector("#courses-revenue-stat"), options);
  chart.render();
  /* Revenue statistics */

  /* course statistics */
  var options = {
    series: [{
      name: 'Completed',
      data: [44, 42, 57, 86, 58, 55, 70],
    }, {
      name: 'Ongoing',
      data: [34, 22, 47, 56, 21, 35, 60],
    }
    ],
    chart: {
      type: 'bar',
      stacked: true,
      height: 345,
    },
    grid: {
      show: true,
      borderColor: 'rgba(119, 119, 142, 0.1)',
      strokeDashArray: 4,
    },
    colors: ["var(--primary-color)", "rgba(var(--secondary-rgb), 1)"],
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '25%',
        borderRadius: 4,
      },
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      show: true,
      width: 2,
      colors: ['transparent']
    },
    states: {
      hover: {
        filter: {
          type: 'none'
        }
      }
    }, 
    yaxis: {
      title: {
        style: {
          color: '	#adb5be',
          fontSize: '14px',
          fontFamily: 'poppins, sans-serif',
          fontWeight: 600,
          cssClass: 'apexcharts-yaxis-label',
        },
      },
      labels: {
        formatter: function (y) {
          return y.toFixed(0) + "";
        }
      }
    },
    xaxis: {
      categories: ['Mon', 'Tue', 'Web', 'Thu', 'Fri', 'Sat', 'Sun'],
      axisBorder: {
        show: true,
        color: 'rgba(119, 119, 142, 0.05)',
        offsetX: 0,
        offsetY: 0,
      },
      axisTicks: {
        show: true,
        borderType: 'solid',
        color: 'rgba(119, 119, 142, 0.05)',
        width: 6,
        offsetX: 0,
        offsetY: 0
      },
    },
    fill: {
      opacity: 1
    },
    legend: {
      position: "top"
    },
  };
  var chart1 = new ApexCharts(document.querySelector("#course-statistics"), options);
  chart1.render();
  /* course statistics */

})();