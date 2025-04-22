(function () {
    "use strict";

    /* overall-attendance */
    var options = {
        chart: {
            height: 216,
            type: "radialBar",
        },
        series: [72, 84],
        colors: ["var(--primary-color)", "rgba(var(--secondary-rgb), 1)"],
        plotOptions: {
            radialBar: {
                hollow: {
                    margin: 0,
                    size: "60%",
                    background: "#fff",
                },
                dataLabels: {
                    name: {
                        offsetY: -10,
                        color: "#4b9bfa",
                        fontSize: "16px",
                        show: false,
                    },
                    value: {
                        offsetY: 10,
                        color: "#4b9bfa",
                        fontSize: "22px",
                        show: true,
                    },
                    total: {
                        show: true,
                        label: 'Total',
                    }
                },
            },
        },
        stroke: {
            lineCap: "round",
        },
    };
    var chart1 = new ApexCharts(document.querySelector("#overall-attendance"), options);
    chart1.render();
    /* overall-attendance */

    /* attendance overview */
    var options = {
        series: [{
            name: 'Boys',
            data: [44, 42, 57, 86, 58, 55, 70],
        }, {
            type: 'area',
            name: 'Girls',
            data: [-34, -22, -37, -56, -21, -35, -60],
        }],
        chart: {
            type: 'area',
            height: 290,
            toolbar: {
                show: false
            }
        },
        stroke: {
            width: [2,2],
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
                      color: 'var(--primary02)',
                      opacity: 1
                    },
                    {
                      offset: 60,
                      color: 'var(--primary02)',
                      opacity: 0.1
                    }
                  ],[
                    {
                      offset: 0,
                      color: 'rgba(var(--secondary-rgb), 0.2)',
                      opacity: 1
                    },
                    {
                      offset: 60,
                      color: 'rgba(var(--secondary-rgb), 0.2)',
                      opacity: 0.1
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
        colors: ["var(--primary09)", "rgba(175 ,109, 237, 0.9)"],
        dataLabels: {
            enabled: false,
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
        yaxis: {
            title: {
                text: 'Attendance',
                style: {
                    color: '	#adb5be',
                    fontSize: '14px',
                    fontFamily: 'Montserrat',
                    fontWeight: 500,
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
            type: 'week',
            categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
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
          enabled: true,
          theme: "dark",
        }
    };
    var chart = new ApexCharts(document.querySelector("#attendance-overview"), options);
    chart.render();
    /* attendance overview */

    /* earnings report */
    var options = {
        series: [{
            name: 'Received Payments',
            type: "column",
            data: [23, 11, 22, 35, 17, 28, 22, 37, 21, 44, 22, 30]
        }, {
            name: 'Pending Payments',
            type: "area",
            data: [30, 25, 36, 30, 45, 35, 64, 51, 59, 36, 39, 51]
        }],
        chart: {
            fontFamily: 'Montserrat',
            height: 290,
            type: 'line',
            stacked: !1,
            toolbar: {
                show: !1
            }
        },
        grid: {
            borderColor: '#f2f6f7',
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
        dataLabels: {
            enabled: false
        },
        legend: {
            position: 'top'
        },
        colors: ["var(--primary-color)", "rgba(var(--secondary-rgb), 0.2)"],
        stroke: {
            width: [1.5, 2],
            curve: ['straight', 'straight'],
            dashArray:[0, 4]
        },
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        legend: {
            show: true,
            position: 'top'
        },
        plotOptions: {
            bar: {
                columnWidth: "20%",
                borderRadius: 2
            }
        },
        tooltip: {
          enabled: true,
          theme: "dark",
        }
    };
    var chart1 = new ApexCharts(document.querySelector("#school-earnings"), options);
    chart1.render();
    /* earnings report */

})();