(function () {
    "use strict";

    /* project statistics */
    var options = {
        series: [
          {
            name: "Active Projects",
            data: [56, 58, 38, 50, 64, 45, 55, 32, 15, 63, 51, 86],
            type: "area",
          },
          {
            name: "Pending Projects",
            data: [48, 29, 50, 69, 20, 59, 52, 12, 48, 28, 17, 98],
            type: "line",
          }, {
            name: 'Completed Projects',
            data: [32, 15, 63, 51, 36, 62, 99, 42, 78, 76, 32, 120]
          }
        ],
        chart: {
          type: "line",
          height: 340,
          toolbar: {
            show: false
          },
          zoom: {
            enabled: false
          },
          dropShadow: {
            enabled: true,
            enabledOnSeries: undefined,
            top: 7,
            left: 0,
            blur: 1,
            color: ["var(--primary-color)", "var(--primary02)", "rgba(var(--secondary-rgb), 1)"],
            opacity: 0.05,
          },
        },
        colors: [
          "var(--primary-color)",
          "var(--primary02)", "rgba(var(--secondary-rgb), 1)"
        ],
        dataLabels: {
          enabled: false,
        },
        legend: {
          show: true,
          position: "top",
          offsetX: 0,
          offsetY: 8,
          markers: {
            size: 4,
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
          curve: 'smooth',
          width: [1.5, 1.5, 1.5],
          lineCap: 'round',
          dashArray: [0, 4, 0],
        },
        fill: {
          type: ['gradient', 'solid'],
          gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.4,
            opacityTo: 0.1,
            stops: [0, 90, 100],
            colorStops: [
              [
                {
                  offset: 0,
                  color: "var(--primary01)",
                  opacity: 0.1
                },
                {
                  offset: 75,
                  color: "var(--primary01)",
                  opacity: 1
                },
                {
                  offset: 100,
                  color: 'var(--primary02)',
                  opacity: 1
                }
              ],
              [
                {
                  offset: 0,
                  color: 'rgba(var(--secondary-rgb), 1)',
                  opacity: 1
                },
                {
                  offset: 75,
                  color: 'rgba(var(--secondary-rgb), 1)',
                  opacity: 1
                },
                {
                  offset: 100,
                  color: 'rgba(var(--secondary-rgb), 1)',
                  opacity: 1
                }
              ],
            ]
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
      };
    var chart = new ApexCharts(document.querySelector("#project-statistics"), options);
    chart.render();
    /* project statistics */

    /* project cards */
    var options = {
        series: [
          {
            data: [35, 25, 37, 47, 42, 15, 47, 75, 65, 19, 44, 50],
          },
        ],
        chart: {
          type: "bar",
          width: 100,
          height: 50,
          sparkline: {
            enabled: true,
          },
        },
        plotOptions: {
          bar: {
            columnWidth: "60%",
          },
        },
        stroke: {
          curve: "smooth",
          width: "1",
        },
        labels:[1,2,3,4,5,6,7,8,9,10,11,12],
        colors: ["var(--primary-color)"],
        tooltip: {
          fixed: {
            enabled: false,
          },
          x: {
            show: false,
          },
          y: {
            title: {
              formatter: function (seriesName) {
                return "";
              },
            },
          },
        },
      };
      var chart2 = new ApexCharts(document.querySelector("#Projects-1"), options);
      chart2.render();
    var options = {
        series: [
          {
            data: [35, 25, 37, 47, 42, 15, 47, 75, 65, 19, 44, 50],
          },
        ],
        chart: {
          type: "bar",
          width: 100,
          height: 50,
          sparkline: {
            enabled: true,
          },
        },
        plotOptions: {
          bar: {
            columnWidth: "60%",
          },
        },
        stroke: {
          curve: "smooth",
          width: "1",
        },
        labels:[1,2,3,4,5,6,7,8,9,10,11,12],
        colors: ["rgb(175 ,109, 237)"],
        tooltip: {
          fixed: {
            enabled: false,
          },
          x: {
            show: false,
          },
          y: {
            title: {
              formatter: function (seriesName) {
                return "";
              },
            },
          },
        },
      };
      var chart = new ApexCharts(document.querySelector("#Projects-2"), options);
      chart.render();
    var options = {
        series: [
          {
            data: [35, 25, 37, 47, 42, 15, 47, 75, 65, 19, 44, 50],
          },
        ],
        chart: {
          type: "bar",
          width: 100,
          height: 50,
          sparkline: {
            enabled: true,
          },
        },
        plotOptions: {
          bar: {
            columnWidth: "60%",
          },
        },
        stroke: {
          curve: "smooth",
          width: "1",
        },
        labels:[1,2,3,4,5,6,7,8,9,10,11,12],
        colors: ["rgb(40 ,215 ,133)"],
        tooltip: {
          fixed: {
            enabled: false,
          },
          x: {
            show: false,
          },
          y: {
            title: {
              formatter: function (seriesName) {
                return "";
              },
            },
          },
        },
      };
      var chart = new ApexCharts(document.querySelector("#Projects-3"), options);
      chart.render();
    var options = {
        series: [
          {
            data: [35, 25, 37, 47, 42, 15, 47, 75, 65, 19, 44, 50],
          },
        ],
        chart: {
          type: "bar",
          width: 100,
          height: 50,
          sparkline: {
            enabled: true,
          },
        },
        plotOptions: {
          bar: {
            columnWidth: "60%",
          },
        },
        stroke: {
          curve: "smooth",
          width: "1",
        },
        labels:[1,2,3,4,5,6,7,8,9,10,11,12],
        colors: ["rgb(241 ,113 ,177)"],
        tooltip: {
          fixed: {
            enabled: false,
          },
          x: {
            show: false,
          },
          y: {
            title: {
              formatter: function (seriesName) {
                return "";
              },
            },
          },
        },
      };
      var chart = new ApexCharts(document.querySelector("#Projects-4"), options);
      chart.render();
    /* project cards */

    /* yearly revenue */
    var options = {
        series: [{
            data: [462, 451, 350, 530, 470, 500, 485],
            name: 'Revenue',
        }],
        chart: {
            type: 'bar',
            height: 373,
            toolbar: {
                show: false
            },
        },
        plotOptions: {
            bar: {
                barHeight: '30%',
                borderRadius: 2,
                horizontal: true,
                colors: {
                    ranges: [{
                        from: 0,
                        to: 500,
                        color: 'rgba(var(--secondary-rgb), 0.6)'
                    },
                    {
                        from: 501,
                        to: Infinity,
                        color: "var(--primary-color)"
                    }]
                },
            }
        },
        dataLabels: {
            enabled: false
        },
        grid: {
            borderColor: '#ffffff',
        },
        xaxis: {
            categories: [ '2017', '2018', '2019', '2020', '2021', '2022', '2023'],
            axisBorder: {
                show: true,
                color: '#c7cacd',
                offsetX: 0,
                offsetY: 0,
            },
            axisTicks: {
                show: true,
                borderType: 'solid',
                color: '#c7cacd',
                width: 6,
                offsetX: 0,
                offsetY: 0
            },
            labels: {
                rotate: -90
            }
        },
    };
    var chart = new ApexCharts(document.querySelector("#yearly-revenue"), options);
    chart.render();
    /* yearly revenue */

})();
/* Earnings Report1 */
var options6 = {
    series: [{
        name: 'Profit',
        data: [16, 11, 19, 15, 20, 13, 16, 25, 27, 42, 38, 32, 33, 20, 36, 48, 22, 37, 41, 33, 45, 57, 60, 58, 25, 13, 20, 28, 12, 24, 38, 23, 45, 36]
    }
    ],
    chart: {
        type: 'area',
        height: 140,
        stacked: true,
        sparkline: {
            enabled: true
        },
        dropShadow: {
            enabled: true,
            enabledOnSeries: undefined,
            top: 7,
            left: 1,
            blur: 3,
            color: '#000',
            opacity: 0.2
        },
    },
    grid: {
        borderColor: '#f2f6f7',
    },
    colors: ["rgba(175 ,109, 237,1)"],
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: 'smooth',
        width: 2,
    },
    legend: {
        show: false,
        position: 'top',
        fontFamily: "Montserrat",
    },
    fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.4,
            opacityTo: 0.1,
            stops: [0, 90, 100],
            colorStops: [
                [
                    {
                        offset: 0,
                        color: "rgba(175 ,109, 237,0.15)",
                        opacity: 1
                    },
                    {
                        offset: 75,
                        color: "rgba(175 ,109, 237,0.15)",
                        opacity: 1
                    },
                    {
                        offset: 100,
                        color: "rgba(175 ,109, 237,0.15)",
                        opacity: 1
                    }
                ]
            ]
        }
    },
    yaxis: {
        title: {
            style: {
                color: '#adb5be',
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
        type: 'month',
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'sep', 'oct', 'nov', 'dec'],
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
        labels: {
            rotate: -90
        }
    },
    tooltip: {
        enabled: false,
    }
};
var chart1 = new ApexCharts(document.querySelector("#earnings-report1"), options6);
chart1.render();
/* Earnings Report1 */
/* Earnings Report */
var options5 = {
    series: [{
        name: 'Profit',
        data: [14, 12, 17, 16, 18, 15, 18, 23, 28, 44, 40, 34, 34, 22, 37, 46, 21, 35, 40, 34, 46, 55, 62, 55, 23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 45, 35],
    },
    ],
    chart: {
        type: 'area',
        height: 100,
        stacked: true,
        sparkline: {
            enabled: true,
        }
    },
    grid: {
        borderColor: '#f2f6f7',
    },
    colors: ["rgba(255,255,255,0.4)"],
    plotOptions: {
        bar: {
            columnWidth: '40%'
        }
    },
    stroke: {
        curve: 'smooth',
        width: 2,
    },
    dataLabels: {
        enabled: false,
    },
    legend: {
        show: false,
        position: 'top',
    },
    yaxis: {
        title: {
            style: {
                color: '#adb5be',
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
        type: 'month',
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'sep', 'oct', 'nov', 'dec'],
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
        labels: {
            rotate: -90
        }
    },
    tooltip: {
        enabled: false,
    }
};
var chart1 = new ApexCharts(document.querySelector("#earnings-report"), options5);
chart1.render();
/* Earnings Report */

/* on going projects */
var total = {
    chart: {
        type: 'area',
        height: 80,
        sparkline: {
            enabled: true
        },
        dropShadow: {
            enabled: true,
            enabledOnSeries: undefined,
            top: 0,
            left: 0,
            blur: 1,
            color: '#fff',
            opacity: 0.05
        }
    },
    stroke: {
        show: true,
        curve: 'smooth',
        lineCap: 'butt',
        colors: undefined,
        width: 1.5,
        dashArray: 0,
    },
    fill: {
        gradient: {
            enabled: false
        }
    },
    series: [{
        name: 'Value',
        data: [47, 45, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46]
    }],
    yaxis: {
        min: 0,
        show: false
    },
    xaxis: {
        axisBorder: {
            show: false
        },
    },
    yaxis: {
        axisBorder: {
            show: false
        },
    },
    colors: ["rgba(var(--primary-rgb), 1)"],
    fill: {
        type: ['gradient'],
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.4,
            opacityTo: 0.1,
            stops: [0, 90, 100],
            colorStops: [
                [
                    {
                        offset: 0,
                        color: "rgba(var(--primary-rgb), 0.5)",
                        opacity: 1
                    },
                    {
                        offset: 75,
                        color: "rgba(var(--primary-rgb), 0.1)",
                        opacity: 0.5
                    },
                    {
                        offset: 100,
                        color: 'rgba(var(--primary-rgb), 0.2)',
                        opacity: 0.1
                    }
                ],
            ]
        }
    },
    tooltip: {
        enabled: false,
    }
}
var total = new ApexCharts(document.querySelector("#projects-ongoing"), total);
total.render();
/* on going projects */