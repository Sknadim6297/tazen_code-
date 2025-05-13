/* Total Customers Chart */
let options2 = {
    series: [{
        data: [0, 68, 18, 78]
    }],
    chart: {
        height: 40,
        width: 100,
        type: 'area',
        fontFamily: 'Poppins, Arial, sans-serif',
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
        curve: 'straight'
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
    colors: ["rgba(175 ,109, 237, 1)"],
    stroke: {
        width: [1.5],
    },
    fill: {
        type: 'gradient',
        gradient: {
            opacityFrom: 0.0,
            opacityTo: 0,
            stops: [0, 95]
        }
    },
};
const chart2 = new ApexCharts(document.querySelector("#total-customers"), options2);
chart2.render();
/* Total Customers Chart */

/* Conversion Ratio Chart */
let options3 = {
    series: [{
        data: [0, 68, 18, 78]
    }],
    chart: {
        height: 40,
        width: 100,
        type: 'area',
        fontFamily: 'Poppins, Arial, sans-serif',
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
        curve: 'straight'
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
    stroke: {
        width: [1.5],
    },
    fill: {
        type: 'gradient',
        gradient: {
            gradientToColors: ["var(--primary-color)"],
            opacityFrom: 0.6,
            opacityTo: 0,
            stops: [0, 95]
        }
    },
};
const chart3 = new ApexCharts(document.querySelector("#conversion-ratio"), options3);
chart3.render();
/* Conversion Ratio Chart */

/*total-leads */
let options4 = {
    series: [{
        data: [0, 68, 18, 78]
    }],
    chart: {
        height: 40,
        width: 100,
        type: 'area',
        fontFamily: 'Poppins, Arial, sans-serif',
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
        curve: 'straight'
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
    colors: ["rgba(40 ,215 ,133, 1)"],
    stroke: {
        width: [1.5],
    },
    fill: {
        type: 'gradient',
        gradient: {
            opacityFrom: 0.0,
            opacityTo: 0,
            stops: [0, 95]
        }
    },
};
const chart4 = new ApexCharts(document.querySelector("#total-leads"), options4);
chart4.render();
/*total-leads */

/*total-deals */
var options = {
    series: [{
        data: [0, 68, 18, 78]
    }],
    chart: {
        height: 40,
        width: 100,
        type: 'area',
        fontFamily: 'Poppins, Arial, sans-serif',
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
        curve: 'straight'
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
    colors: ["rgba(241 ,113 ,177, 1)"],
    stroke: {
        width: [1.5],
    },
    fill: {
        type: 'gradient',
        gradient: {
            opacityFrom: 0.0,
            opacityTo: 0,
            stops: [0, 95]
        }
    },
};
var chart = new ApexCharts(document.querySelector("#total-deals"), options);
chart.render();
/*total-deals */

/* Revenue Analytics */
var options = {
    series: [{
        name: "Profit",
        type: "column",
        data: [33, 21, 32, 37, 23, 32, 47, 31, 54, 32, 20, 38]
    }, {
        name: "Revenue",
        type: "area",
        data: [44, 55, 41, 42, 22, 43, 21, 35, 56, 27, 43, 27]
    }, {
        name: "Income",
        type: "line",
        data: [30, 25, 36, 30, 45, 35, 64, 51, 59, 36, 39, 51]
    }],
    chart: {
        height: 342,
        type: "line",
        stacked: !1,
        toolbar: {
            show: false
        },
        zoom: {
            enabled: false
        }
    },
    stroke: {
        width: [0, 0, 2.5],
        dashArray: [0, 0, 4],
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
    yaxis: {
        max: 75
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
    colors: ['var(--primary-color)', "rgba(var(--success-rgb), 0.09)",'rgba(var(--pink-rgb), 1)'],
    tooltip: {
        theme: "dark",
    },
};
var chart = new ApexCharts(document.querySelector("#revenue-analytics"), options);
chart.render();
/* Revenue Analytics */

/* Active Customers */
var options = {
    series: [{
        name: 'Active customers',
        data: [44, 42, 57, 86, 58, 55, 70],
    }, {
        name: 'new customers',
        data: [34, 22, 37, 56, 21, 35, 60],
    }],
    chart: {
        type: 'bar',
        height: 260,
        stacked: true,
        toolbar: {
            show: false,
        }
    },
    grid: {
        borderColor: '#f1f1f1',
        strokeDashArray: 3
    },
    colors: ["var(--primary-color)", "rgba(var(--secondary-rgb), 1)"],
    plotOptions: {
        bar: {
            colors: {
                ranges: [{
                    from: -100,
                    to: -46,
                    color: '#ebeff5'
                }, {
                    from: -45,
                    to: 0,
                    color: '#ebeff5'
                }]
            },
            columnWidth: '25%',
            borderRadius: 2,
        }
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        show: true,
        width: 2,
        colors: undefined,
    },
    legend: {
        show: true,
        position: 'top',
        markers: {
            size: 4,
            shape: "circle"
        }
    },
    yaxis: {
        title: {
            style: {
                color: '#adb5be',
                fontSize: '13px',
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
        type: 'week',
        categories: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
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
    }
};
var chart = new ApexCharts(document.querySelector("#active-customers"), options);
chart.render();
/* Active Customers */