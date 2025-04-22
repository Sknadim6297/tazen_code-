/* audience report */
// var options = {
//     series: [
//         {
//             name: "Male",
//             data: [29, 18, 26, 30, 23, 28, 23, 34]
//         },
//         {
//             name: "Female",
//             data: [23, 15, 21, 23, 18, 22, 18, 28]
//         },
//         {
//             name: "Others",
//             data: [18, 10, 15, 18, 12, 16, 12, 20]
//         }
//     ],
//     chart: {
//         height: 263,
//         type: 'area',
//         dropShadow: {
//             enabled: true,
//             color: '#000',
//             top: 18,
//             left: 0,
//             blur: 10,
//             opacity: 0.2
//         },
//         sparkline: {
//             enabled: true,
//         },
//         zoom: {
//             enabled: false
//         },
//     },
//     colors: ['rgba(255, 255, 255, 0.1)', 'rgba(255, 255, 255, 0.2)', 'rgba(255, 255, 255, 0.3)'],
//     dataLabels: {
//         enabled: false,
//     },
//     stroke: {
//         width: [0, 0, 0],
//         curve: 'smooth'
//     },
//     title: {
//         align: 'left',
//         style: {
//             fontSize: '13px',
//             fontWeight: 'bold',
//             color: '#8c9097'
//         },
//     },
//     fill: {
//         type: 'gradient',
//         gradient: {
//             shadeIntensity: 1,
//             opacityFrom: 0.4,
//             opacityTo: 0.1,
//             stops: [0, 90, 100],
//             colorStops: [
//                 [
//                     {
//                         offset: 0,
//                         color: "rgba(255, 255, 255, 0.1)",
//                         opacity: 1
//                     },
//                     {
//                         offset: 75,
//                         color: "rgba(255, 255, 255, 0.1)",
//                         opacity: 1
//                     },
//                     {
//                         offset: 100,
//                         color: "rgba(255, 255, 255, 0.1)",
//                         opacity: 1
//                     }
//                 ],
//                 [
//                     {
//                         offset: 0,
//                         color: "rgba(255, 255, 255, 0.2)",
//                         opacity: 1
//                     },
//                     {
//                         offset: 75,
//                         color: "rgba(255, 255, 255, 0.2)",
//                         opacity: 1
//                     },
//                     {
//                         offset: 100,
//                         color: "rgba(255, 255, 255, 0.2)",
//                         opacity: 1
//                     }
//                 ],
//                 [
//                     {
//                         offset: 0,
//                         color: "rgba(255, 255, 255, 0.3)",
//                         opacity: 1
//                     },
//                     {
//                         offset: 75,
//                         color: "rgba(255, 255, 255, 0.3)",
//                         opacity: 1
//                     },
//                     {
//                         offset: 100,
//                         color: "rgba(255, 255, 255, 0.3)",
//                         opacity: 1
//                     }
//                 ],
//             ]
//         }
//     },
//     grid: {
//         borderColor: 'transparent',
//         padding: {
//             top: 0,
//             right: 0,
//             bottom: 0,
//             left: 0
//         },
//     },
//     xaxis: {
//         title: {
//             fontSize: '13px',
//             fontWeight: 'bold',
//             style: {
//                 color: "#8c9097"
//             }
//         },
//         labels: {
//             show: true,
//             style: {
//                 colors: "#8c9097",
//                 fontSize: '11px',
//                 fontWeight: 600,
//                 cssClass: 'apexcharts-xaxis-label',
//             },
//             offsetX: -3,
//             offsetY: -20,
//         },
//     },
//     yaxis: {
//         title: {
//             fontSize: '13px',
//             fontWeight: 'bold',
//             style: {
//                 color: "#8c9097"
//             }
//         },
//         labels: {
//             show: false,
//             style: {
//                 colors: "#8c9097",
//                 fontSize: '11px',
//                 fontWeight: 600,
//                 cssClass: 'apexcharts-yaxis-label',
//             },
//             offsetX: 15,
//             offsetY: 0,
//         },
//     },
//     legend: {
//         position: 'top',
//         horizontalAlign: 'right',
//         offsetY: 100
//     },
//     tooltip: {
//         theme: "dark",
//     },
// };
// var chart = new ApexCharts(document.querySelector("#audience-report"), options);
// chart.render();
/* audience report */

/* Sales stats */
var options = {
    series: [ {
        name: "Sales",
        type: "bar",
        data: [46, 53, 43, 40, 24, 45, 19, 37, 54, 29, 41, 30]
    }, {
        name: "Revenue",
        type: "bar",
        data: [32, 28, 34, 32, 43, 37, 62, 50, 57, 38, 41, 53]
    }],
    chart: {
        height: 340,
        type: "line",
        stacked: true,
        toolbar: {
            show: !1
        },
        zoom: {
            enabled: false
        },
    },
    stroke: {
        width: [2, 2],
        show: true,
        curve: 'smooth',
        lineCap: 'butt',
    },
    grid: {
        borderColor: '#f1f1f1',
        strokeDashArray: 3
    },
    xaxis: {
        axisBorder: {
            color: 'rgba(119, 119, 142, 0.05)',
            offsetX: 0,
            offsetY: 0,
        },
        axisTicks: {
            color: 'rgba(119, 119, 142, 0.05)',
            width: 6,
            offsetX: 0,
            offsetY: 0
        },
    },
    plotOptions: {
        bar: {
            columnWidth: "20%",
            borderRadius: 3
        }
    },
    legend: {
        position: "top"
    },
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    markers: {
        size: 0
    },
    colors: ['var(--primary-color)','rgba(var(--secondary-rgb), 1)'],
    tooltip: {
        theme: "dark",
    },
};
var chart = new ApexCharts(document.querySelector("#esales-stats"), options);
chart.render();
/* Sales stats */

/* Monthly Target */
var options = {
    chart: {
        height: 251,
        type: "radialBar",
        sparkline: {
          enabled: true
        }
    },
    series: [75],
    colors: ["var(--primary-color)"],
    plotOptions: {
        radialBar: {
            hollow: {
                margin: 0,
                size: "70%",
                background: "#fff"
            },
            dataLabels: {
                name: {
                    offsetY: -10,
                    color: "#4b9bfa",
                    fontSize: "10px",
                    show: false
                },
                value: {
                    offsetY: 7,
                    color: "#4b9bfa",
                    fontSize: "23px",
                    show: true,
                    fontWeight: 600,
                    fontFamily: "Poppins",

                }
            }
        }
    }, grid: {
        padding: {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0
        },
    },
    stroke: {
        lineCap: "round"
    },
    labels: ["Monthly Target"]
};
var chart5 = new ApexCharts(document.querySelector("#monthly-target"), options);
chart5.render();
/* Monthly Target */

/* Sales Report */
  var options = {
    series: [{
        name: 'Online Sales',
        type: 'line',
        data: [32, 15, 63, 51, 36, 62, 99]
    }, {
        name: 'Store Sales',
        type: 'line',
        data: [56, 58, 38, 50, 64, 45, 55]
    }],
    chart: {
        height: 331,
        type: 'line',
        stacked: false,
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
            blur: 3,
            color: ["var(--primary-color)", "rgb(175 ,109, 237)", "rgb(40 ,215 ,133)"],
            opacity: 0.1
        },
    },
    colors: ["var(--primary-color)", "rgba(var(--secondary-rgb), 1)"],
    grid: {
        borderColor: '#f1f1f1',
        strokeDashArray: 3
    },
    stroke: {
        width: [2, 2, 2],
        curve: 'smooth',
    },
    plotOptions: {
        bar: {
            columnWidth: '30%',
            borderRadius: 5,
        }
    },
    labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
    markers: {
        size: 0,
    },
    legend: {
        show: true,
        position: 'top',
        fontFamily: "Montserrat",
        markers: {
            width: 10,
            height: 10,
        }
    },
    xaxis: {
        type: 'week',
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
    yaxis: {
        title: {
            style: {
                color: '#adb5be',
                fontSize: '14px',
                fontFamily: 'Mulish, sans-serif',
                fontWeight: 600,
                cssClass: 'apexcharts-yaxis-label',
            },
        },
    },
    tooltip: {
        shared: true,
        theme: "dark",
    }
};
var chart = new ApexCharts(document.querySelector("#sales-report"), options);
chart.render();
/* Sales Report */
