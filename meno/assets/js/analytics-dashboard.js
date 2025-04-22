(function () {
    'use strict';

    /* sessions overview */
    var options = {
        series: [{
            type: 'area',
            name: 'Page Views',
            data: [44, 55, 41, 67, 42, 35, 55, 34, 22, 66, 34, 56]
        }, {
            type: 'area',
            name: 'Clicks',
            data: [30, 25, 46, 28, 21, 45, 35, 64, 52, 59, 36, 39]
        }, {
            type: 'area',
            name: 'Actions',
            data: [23, 11, 22, 35, 17, 28, 22, 37, 21, 44, 22, 30]
        },],
        chart: {
            height: 345,
            type: 'area',
            toolbar: {
                show: false,
            },
            zoom: {
                enabled: false
            },
        },
        plotOptions: {
            bar: {
                borderRadius: 3,
                columnWidth: '15%',
            }
        },
        dataLabels: {
            enabled: false
        },
        legend: {
            position: 'top',
            fontFamily: "Montserrat",
        },
        colors: ["rgba(var(--success-rgb), 1)", "rgba(var(--primary-rgb), 1)", "rgba(var(--secondary-rgb), 1)"],
        stroke: {
            width: [0, 0, 1.8],
            curve: ['straight', 'straight', 'straight'],
            dashArray: [0, 0, 2]
        }, 
        grid: {
            borderColor: '#f1f1f1',
            strokeDashArray: 5
        },
        fill: {
            type: ['gradient','gradient','gradient'],
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.1,
                stops: [0, 90, 100],
                colorStops: [

                    [
                        {
                            offset: 0,
                            color: 'rgba(var(--success-rgb), 0.6)',
                            opacity: 0.5
                        },
                        {
                            offset: 85,
                            color: 'rgba(var(--success-rgb), 0.6)',
                            opacity: 0.1
                        },
                        {
                            offset: 100,
                            color: 'rgba(255, 255, 255, 0.1)',
                            opacity: 1
                        }
                    ],
                    [
                        {
                            offset: 0,
                            color: "var(--primary-color)",
                            opacity: 0.7
                        },
                        {
                            offset: 85,
                            color: "var(--primary-color)",
                            opacity: 0.7
                        },
                        {
                            offset: 100,
                            color: "var(--primary-color)",
                            opacity: 0.7
                        },
                    ],
                    [
                        {
                            offset: 0,
                            color: "rgba(var(--secondary-rgb), 1)",
                            opacity: 0.4
                        },
                        {
                            offset: 85,
                            color: "rgba(var(--secondary-rgb), 1)",
                            opacity: 0.4
                        },
                        {
                            offset: 100,
                            color: "rgba(var(--secondary-rgb), 1)",
                            opacity: 0.4
                        },
                    ],
                ]
            }
        },
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        tooltip: {
            shared: true,
            theme: "dark",
        }
    };
    var chart = new ApexCharts(document.querySelector("#sessions-insights"), options);
    chart.render();
    /* sessions overview */

    /* Sales By Region */
    var options1 = {
        chart: {
            height: 340,
            type: 'bar',
            toolbar: {
                show: false,
            },
            offsetY: 20,
            zoom: {
                enabled: false
            }
        },
        series: [{
            name: 'Total Visitors',
            data: [15, 130, 83, 80, 100],
        }],
        labels: ['Europe', 'Canada', 'US', 'Spain', 'Australia'],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '52%',
                borderRadius: 5
            }
        },
        dataLabels: {
            enabled: false,
        },
        colors: ["var(--primary-color)"],
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent'],
        },
        grid: {
            borderColor: '#f1f1f1',
            strokeDashArray: 5
        },
        markers: {
            size: 0, // Disable markers for bar chart
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val;
                }
            },
            theme: 'dark',
        },
        yaxis: {
            tickAmount: 7,
        },
        xaxis: {
            categories: ['Europe', 'Canada', 'US', 'Spain', 'Australia'],
        },
    };
    var chart = new ApexCharts(document.querySelector("#sales-region"), options1);
    chart.render();
    
    /* Sales By Region */

    /* Subscribers */
    var options = {
        series: [4784, 3743],
        labels: ["New", "Active"],
        chart: {
        height: 250,
        type: 'donut',
        },
        dataLabels: { 
        enabled: false,
        },

        legend: {
        show: false,
        },
        stroke: {
        show: true,
        curve: 'smooth',
        lineCap: 'round',
        colors: "#fff",
        width: 0,
        dashArray: 0,
        },
        stroke: {
        width: 2,
        },
        plotOptions: {
        pie: {
            startAngle: -90,
            endAngle: 90,
            offsetY: 10,
            expandOnClick: false,
            donut: {
            size: '80%',
            background: 'transparent',
            labels: {
                show: true,
                name: {
                show: true,
                fontSize: '20px',
                color: '#495057',
                fontFamily: "Montserrat, sans-serif",
                offsetY: -35
                },
                value: {
                show: true,
                fontSize: '22px',
                color: undefined,
                offsetY: -25,
                fontWeight: 600,
                fontFamily: "Montserrat, sans-serif",
                formatter: function (val) {
                    return val + "%"
                }
                },
                total: {
                show: true,
                showAlways: true,
                label: 'Total Visitors',
                fontSize: '14px',
                fontWeight: 400,
                color: '#495057',
                }
            }
            }
        }
        },
        grid: {
        padding: {
            bottom: -85
        }
        },
        colors: ["var(--primary-color)", "rgba(var(--secondary-rgb), 1)"],
    };
    var chart = new ApexCharts(document.querySelector("#subscribers"), options);
    chart.render();
    /* Subscribers */

})();