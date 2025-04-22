(function () {
    'use strict';

    /* Total Sales */
    var spark1 = {
        chart: {
            type: 'area',
            height: 60,
            width: 120,
            sparkline: {
                enabled: true
            },
        },
        grid: {
            show: false,
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            },
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
            colors: undefined,
            width: 2,
            dashArray: 0,
            fill: {
                type: "gradient",
                gradient: {
                    type: "horizontal",
                    colorStops: [
                        [
                            {
                                offset: 0,
                                color: "var(--primary-color)",
                                opacity: 1
                            },
                            {
                                offset: 100,
                                color: "rgb(175 ,109, 237)",
                                opacity: 1
                            },
                        ]
                    ]
                }
            }
        },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                type: "horizontal",
                colorStops: [
                    [
                        {
                            offset: 0,
                            color: "rgb(175 ,109, 237)",
                            opacity: 0.03
                        },
                        {
                            offset: 90,
                            color: "var(--primary-color)",
                            opacity: 0.03
                        }
                    ]
                ]
            }
        },
        series: [{
            name: 'Value',
            data: [14, 38, 26, 44, 20, 65, 35, 40]
        }],
        yaxis: {
            min: 0,
            show: false
        },
        xaxis: {
            show: false,
            axisTicks: {
                show: false
            },
            axisBorder: {
                show: false
            }
        },
        yaxis: {
            axisBorder: {
                show: false
            },
        },
        colors: ['var(--primary-color)'],

    }
    var spark1 = new ApexCharts(document.querySelector("#chart-1"), spark1);
    spark1.render();
    /* Total Sales */

    /* Profit By Sale */
    var spark1 = {
        chart: {
            type: 'area',
            height: 60,
            width: 120,
            sparkline: {
                enabled: true
            },
        },
        grid: {
            show: false,
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            },
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
            colors: undefined,
            width: 2,
            dashArray: 0,
            fill: {
                type: "gradient",
                gradient: {
                    type: "horizontal",
                    colorStops: [
                        [
                            {
                                offset: 0,
                                color: "rgb(244, 167, 66)",
                                opacity: 1
                            },
                            {
                                offset: 100,
                                color: "rgb(187, 164, 44)",
                                opacity: 1
                            },
                        ]
                    ]
                }
            }
        },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                type: "horizontal",
                colorStops: [
                    [
                        {
                            offset: 0,
                            color: "rgb(244, 167, 66)",
                            opacity: 0.03
                        },
                        {
                            offset: 90,
                            color: "rgb(187, 164, 44)",
                            opacity: 0.03
                        }
                    ]
                ]
            }
        },
        series: [{
            name: 'Value',
            data: [14, 38, 26, 44, 20, 65, 35, 40]
        }],
        yaxis: {
            min: 0,
            show: false
        },
        xaxis: {
            show: false,
            axisTicks: {
                show: false
            },
            axisBorder: {
                show: false
            }
        },
        yaxis: {
            axisBorder: {
                show: false
            },
        },
        colors: ['var(--primary-color)'],

    }
    var spark1 = new ApexCharts(document.querySelector("#chart-2"), spark1);
    spark1.render();
    /* Profit By Sale */

    /* Total Revenue */
    var spark1 = {
        chart: {
            type: 'area',
            height: 60,
            width: 120,
            sparkline: {
                enabled: true
            },
        },
        grid: {
            show: false,
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            },
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
            colors: undefined,
            width: 2,
            dashArray: 0,
            fill: {
                type: "gradient",
                gradient: {
                    type: "horizontal",
                    colorStops: [
                        [
                            {
                                offset: 0,
                                color: "rgb(40 ,215 ,133)",
                                opacity: 1
                            },
                            {
                                offset: 100,
                                color: "rgb(0, 142, 203)",
                                opacity: 1
                            },
                        ]
                    ]
                }
            }
        },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                type: "horizontal",
                colorStops: [
                    [
                        {
                            offset: 0,
                            color: "rgb(40 ,215 ,133)",
                            opacity: 0.03
                        },
                        {
                            offset: 90,
                            color: "rgb(0, 142, 203)",
                            opacity: 0.03
                        }
                    ]
                ]
            }
        },
        series: [{
            name: 'Value',
            data: [14, 38, 26, 44, 20, 65, 35, 40]
        }],
        yaxis: {
            min: 0,
            show: false
        },
        xaxis: {
            show: false,
            axisTicks: {
                show: false
            },
            axisBorder: {
                show: false
            }
        },
        yaxis: {
            axisBorder: {
                show: false
            },
        },
        colors: ['var(--primary-color)'],

    }
    var spark1 = new ApexCharts(document.querySelector("#chart-3"), spark1);
    spark1.render();
    /* Total Revenue */

    /* Total Customers */
    var spark1 = {
        chart: {
            type: 'area',
            height: 60,
            width: 120,
            sparkline: {
                enabled: true
            },
        },
        grid: {
            show: false,
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            },
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
            colors: undefined,
            width: 2,
            dashArray: 0,
            fill: {
                type: "gradient",
                gradient: {
                    type: "horizontal",
                    colorStops: [
                        [
                            {
                                offset: 0,
                                color: "rgb(241 ,113 ,177)",
                                opacity: 1
                            },
                            {
                                offset: 100,
                                color: "rgb(245, 97, 130)",
                                opacity: 1
                            },
                        ]
                    ]
                }
            }
        },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                type: "horizontal",
                colorStops: [
                    [
                        {
                            offset: 0,
                            color: "rgb(241 ,113 ,177)",
                            opacity: 0.03
                        },
                        {
                            offset: 90,
                            color: "rgb(245, 97, 130)",
                            opacity: 0.03
                        }
                    ]
                ]
            }
        },
        series: [{
            name: 'Value',
            data: [14, 38, 26, 44, 20, 65, 35, 40]
        }],
        yaxis: {
            min: 0,
            show: false
        },
        xaxis: {
            show: false,
            axisTicks: {
                show: false
            },
            axisBorder: {
                show: false
            }
        },
        yaxis: {
            axisBorder: {
                show: false
            },
        },
        colors: ['var(--primary-color)'],

    }
    var spark1 = new ApexCharts(document.querySelector("#chart-4"), spark1);
    spark1.render();
    /* Total Customers */

    /* Sales Overview */
    var options = {
        chart: {
            height: 249,
            type: 'radialBar',
            responsive: 'true',
        },
        plotOptions: {
            radialBar: {
                startAngle: -135,
                endAngle: 135,
                hollow: {
                    margin: 0,
                    size: '68%',
                    background: '#fff',
                    image: undefined,
                    imageOffsetX: 0,
                    imageOffsetY: 0,
                    position: 'front',
                },

                dataLabels: {
                    show: true,
                    name: {
                        offsetY: -10,
                        show: true,
                        color: 'var(--text-muted)',
                        fontSize: '14px',
                        fontWeight: '400'
                    },
                    value: {
                        formatter: function (val) {
                            return parseInt(val);
                        },
                        color: '#111',
                        fontSize: '36px',
                        show: true,
                    }
                }
            }
        },
        colors: ["rgb(175 ,109, 237)", "var(--primary-color)"],
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'round',
            colors: "#fff",
            width: 0,
            dashArray: 0,
        },
        fill: {
            type: 'gradient',
            gradient: {
                type: 'horizontal',
                shadeIntensity: 0.5,
                gradientToColors: ['var(--primary-color)'],
                inverseColors: true,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 100]
            }
        },
        series: [85],
        labels: ["Total Sales"]
    };
    var chart1 = new ApexCharts(document.querySelector("#circlechart"), options);
    chart1.render();
    /* Sales Overview */

    /* Sales Revenue */
    var options = {
        series: [{
            name: 'sales',
            type: 'column',
            data: [200, 170, 250, 240, 220, 280, 170, 155, 130, 242],
        }, {
            name: 'revenue',
            type: 'line',
            data: [13, 15, 25, 17, 19, 22, 11, 10, 9, 22],
            dataLabels: {
                enabled: false,
            },
        }],
        chart: {
            height: 320,
            type: 'line',
            dropShadow: {
                enabled: true,
                enabledOnSeries: undefined,
                top: 0,
                left: 0,
                blur: 4,
                color: ["rgba(255,255,255,0)", "rgb(175 ,109, 237)"],
                opacity: 0.4,
            },
            toolbar: {
                show: false,
            },
            zoom: {
                enabled: false,
            }
        },
        dataLabels: {
            enabled: true,
            enabledOnSeries: [0],
            background: {
                enabled: false,
                foreColor: '#fff',
            },
            formatter: function (val) {
                return val + "%";
            },
            offsetY: -10,
            style: {
                fontSize: '12px',
                colors: ["#8c9097"]
            }
        },
        stroke: {
            curve: 'smooth',
            width: [0, 2],
        },
        plotOptions: {
            bar: {
                columnWidth: "40%",
                borderRadius: 3,
            }
        },

        colors: ["rgb(175 ,109, 237)", "rgb(40 ,215 ,133)"],
        fill: {
            type: "gradient",
            gradient: {
                shade: "dark",
                type: "vertical",
                shadeIntensity: 0,
                inverseColors: false,
                gradientToColors: ["var(--primary-color)"],
                opacityFrom: [0.9, 1],
                opacityTo: [0.9, 1],
                stops: [0, 90, 100]
            }
        },
        labels: ['1.1', '1.2', '1.3', '1.4', '1.5', '1.6', '1.7', '1.8', '1.9', '2.0'],
        yaxis: [{

        }, {
            opposite: true,
        }],
    };
    var chart = new ApexCharts(document.querySelector("#salerevenue"), options);
    chart.render();
    /* Sales Revenue */

    /* Total Sales */
    var spark1 = {
        chart: {
            type: 'line',
            height: 40,
            width: 200,
            sparkline: {
                enabled: true
            },
            dropShadow: {
                enabled: true,
                enabledOnSeries: undefined,
                top: 3,
                bottom: -50,
                left: 0,
                blur: 3,
                color: 'var(--primary-color)',
                opacity: 0.3
            }
        },
        grid: {
            show: false,
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            },
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
            colors: undefined,
            width: 1.9,
            dashArray: 0,
        },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                type: "vertical",
                colorStops: [
                    [
                        {
                            offset: 0,
                            color: "var(--primary-color)",
                            opacity: 1
                        },
                        {
                            offset: 90,
                            color: "var(--primary-color)",
                            opacity: 1
                        }
                    ]
                ]
            }
        },
        series: [{
            name: 'Value',
            data: [14, 20, 15, 25, 22, 35, 15, 30, 25]
        }],
        yaxis: {
            min: 0,
            show: false
        },
        xaxis: {
            show: false,
            axisTicks: {
                show: false
            },
            axisBorder: {
                show: false
            }
        },
        yaxis: {
            axisBorder: {
                show: false
            },
        },
        colors: ['var(--primary-color)'],
    }
    var spark1 = new ApexCharts(document.querySelector("#chart-5"), spark1);
    spark1.render();
    /* Total Sales */

    /* Total Sales */
    var spark1 = {
        chart: {
            type: 'line',
            height: 40,
            width: 200,
            sparkline: {
                enabled: true
            },
            dropShadow: {
                enabled: true,
                enabledOnSeries: undefined,
                top: 3,
                bottom: -50,
                left: 0,
                blur: 3,
                color: 'rgba(var(--secondary-rgb), 1)',
                opacity: 0.3
            }
        },
        grid: {
            show: false,
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            },
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
            colors: undefined,
            width: 1.9,
            dashArray: 0,
        },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                type: "vertical",
                colorStops: [
                    [
                        {
                            offset: 0,
                            color: "rgba(var(--secondary-rgb), 1)",
                            opacity: 1
                        },
                        {
                            offset: 90,
                            color: "rgba(var(--secondary-rgb), 1)",
                            opacity: 1
                        }
                    ]
                ]
            }
        },
        series: [{
            name: 'Value',
            data: [14, 20, 15, 25, 22, 35, 15, 30, 25]
        }],
        yaxis: {
            min: 0,
            show: false
        },
        xaxis: {
            show: false,
            axisTicks: {
                show: false
            },
            axisBorder: {
                show: false
            }
        },
        yaxis: {
            axisBorder: {
                show: false
            },
        },
        colors: ['rgba(var(--secondary-rgb), 1)'],
    }
    var spark1 = new ApexCharts(document.querySelector("#chart-6"), spark1);
    spark1.render();
    /* Total Sales */

    /* Total Sales */
    var spark1 = {
        chart: {
            type: 'line',
            height: 40,
            width: 200,
            sparkline: {
                enabled: true
            },
            dropShadow: {
                enabled: true,
                enabledOnSeries: undefined,
                top: 3,
                bottom: -50,
                left: 0,
                blur: 3,
                color: 'rgba(var(--success-rgb), 1)',
                opacity: 0.3
            }
        },
        grid: {
            show: false,
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            },
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
            colors: undefined,
            width: 1.9,
            dashArray: 0,
        },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                type: "vertical",
                colorStops: [
                    [
                        {
                            offset: 0,
                            color: "rgba(var(--success-rgb), 1)",
                            opacity: 1
                        },
                        {
                            offset: 90,
                            color: "rgba(var(--success-rgb), 1)",
                            opacity: 1
                        }
                    ]
                ]
            }
        },
        series: [{
            name: 'Value',
            data: [14, 20, 15, 25, 22, 35, 15, 30, 25]
        }],
        yaxis: {
            min: 0,
            show: false
        },
        xaxis: {
            show: false,
            axisTicks: {
                show: false
            },
            axisBorder: {
                show: false
            }
        },
        yaxis: {
            axisBorder: {
                show: false
            },
        },
        colors: ['rgba(var(--success-rgb), 1)'],
    }
    var spark1 = new ApexCharts(document.querySelector("#chart-7"), spark1);
    spark1.render();
    /* Total Sales */

    /* Total Sales */
    var spark1 = {
        chart: {
            type: 'line',
            height: 40,
            width: 200,
            sparkline: {
                enabled: true
            },
            dropShadow: {
                enabled: true,
                enabledOnSeries: undefined,
                top: 3,
                bottom: -50,
                left: 0,
                blur: 3,
                color: 'rgba(var(--pink-rgb), 1)',
                opacity: 0.3
            }
        },
        grid: {
            show: false,
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            },
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
            colors: undefined,
            width: 1.9,
            dashArray: 0,
        },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                type: "vertical",
                colorStops: [
                    [
                        {
                            offset: 0,
                            color: "rgba(var(--pink-rgb), 1)",
                            opacity: 1
                        },
                        {
                            offset: 90,
                            color: "rgba(var(--pink-rgb), 1)",
                            opacity: 1
                        }
                    ]
                ]
            }
        },
        series: [{
            name: 'Value',
            data: [14, 20, 15, 25, 22, 35, 15, 30, 25]
        }],
        yaxis: {
            min: 0,
            show: false
        },
        xaxis: {
            show: false,
            axisTicks: {
                show: false
            },
            axisBorder: {
                show: false
            }
        },
        yaxis: {
            axisBorder: {
                show: false
            },
        },
        colors: ['rgba(var(--pink-rgb), 1)'],
    }
    var spark1 = new ApexCharts(document.querySelector("#chart-8"), spark1);
    spark1.render();
    /* Total Sales */

    /* Total Sales */
    var spark1 = {
        chart: {
            type: 'line',
            height: 40,
            width: 200,
            sparkline: {
                enabled: true
            },
            dropShadow: {
                enabled: true,
                enabledOnSeries: undefined,
                top: 3,
                bottom: -50,
                left: 0,
                blur: 3,
                color: 'rgba(var(--warning-rgb), 1)',
                opacity: 0.3
            }
        },
        grid: {
            show: false,
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            },
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
            colors: undefined,
            width: 1.9,
            dashArray: 0,
        },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                type: "horizontal",
                colorStops: [
                    [
                        {
                            offset: 0,
                            color: "rgba(var(--warning-rgb), 1)",
                            opacity: 1
                        },
                        {
                            offset: 90,
                            color: "rgba(var(--warning-rgb), 1)",
                            opacity: 1
                        }
                    ]
                ]
            }
        },
        series: [{
            name: 'Value',
            data: [14, 20, 15, 25, 22, 35, 15, 30, 25]
        }],
        yaxis: {
            min: 0,
            show: false
        },
        xaxis: {
            show: false,
            axisTicks: {
                show: false
            },
            axisBorder: {
                show: false
            }
        },
        yaxis: {
            axisBorder: {
                show: false
            },
        },
        colors: ['rgba(var(--warning-rgb), 1)'],
    }
    var spark1 = new ApexCharts(document.querySelector("#chart-9"), spark1);
    spark1.render();
    /* Total Sales */

    var chart = {
        series: [
            {
                name: "This Week",
                data: [44, 42, 57, 86, 57, 42, 44],
            },
            {
                name: "Last Week",
                data: [-34, -22, -37, -56, -37, -22, -34],
            },
        ],
        chart: {
            toolbar: {
                show: false,
            },
            type: "bar",
            width: 100,
            height: 100,
            stacked: true,
        },
        colors: ["rgb(175 ,109, 237)", "var(--primary-color)"],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "35%",
            },
        },
        dataLabels: {
            enabled: false,
        },
        tooltip: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        grid: {
            borderColor: "rgba(0,0,0,0.1)",
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            }
        },
        xaxis: {
            axisBorder: {
                show: false,
            },
            labels: {
                show: false,
            }
        },
        yaxis: {
            tickAmount: 4,
            labels: {
                show: false,
            },
        },
    };
    var chart1 = new ApexCharts(document.querySelector("#chart-10"), chart);
    chart1.render();

    var chart = {
        series: [
            {
                name: "This Week",
                data: [86, 57, 44, 42, 44, 57, 86],
            },
            {
                name: "Last Week",
                data: [-56, -37, -34, -22, -34, -37, -56],
            },
        ],
        chart: {
            toolbar: {
                show: false,
            },
            type: "bar",
            width: 100,
            height: 100,
            stacked: true,
        },
        colors: ["rgb(175 ,109, 237)", "var(--primary-color)"],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "35%",
            },
        },
        dataLabels: {
            enabled: false,
        },
        tooltip: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        grid: {
            borderColor: "rgba(0,0,0,0.1)",
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            }
        },
        xaxis: {
            axisBorder: {
                show: false,
            },
            labels: {
                show: false,
            }
        },
        yaxis: {
            tickAmount: 4,
            labels: {
                show: false,
            },
        },
    };
    var chart1 = new ApexCharts(document.querySelector("#chart-11"), chart);
    chart1.render();

    var chart = {
        series: [
            {
                name: "This Week",
                data: [86, 57, 45, 40, 34, 30, 25],
            },
            {
                name: "Last Week",
                data: [-56, -37, -30, -24, -20, -18, -12],
            },
        ],
        chart: {
            toolbar: {
                show: false,
            },
            type: "bar",
            width: 100,
            height: 100,
            stacked: true,
        },
        colors: ["rgb(175 ,109, 237)", "var(--primary-color)"],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "35%",
            },
        },
        dataLabels: {
            enabled: false,
        },
        tooltip: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        grid: {
            borderColor: "rgba(0,0,0,0.1)",
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            }
        },
        xaxis: {
            axisBorder: {
                show: false,
            },
            labels: {
                show: false,
            }
        },
        yaxis: {
            tickAmount: 4,
            labels: {
                show: false,
            },
        },
    };
    var chart1 = new ApexCharts(document.querySelector("#chart-12"), chart);
    chart1.render();

    var chart = {
        series: [
            {
                name: "This Week",
                data: [44, 42, 57, 86, 57, 42, 44],
            },
            {
                name: "Last Week",
                data: [-34, -22, -37, -56, -37, -22, -34],
            },
        ],
        chart: {
            toolbar: {
                show: false,
            },
            type: "bar",
            width: 100,
            height: 100,
            stacked: true,
        },
        colors: ["rgb(175 ,109, 237)", "var(--primary-color)"],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "35%",
            },
        },
        tooltip: {
            enabled: false,
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        grid: {
            borderColor: "rgba(0,0,0,0.1)",
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            }
        },
        xaxis: {
            axisBorder: {
                show: false,
            },
            labels: {
                show: false,
            }
        },
        yaxis: {
            tickAmount: 4,
            labels: {
                show: false,
            },
        },
    };
    var chart1 = new ApexCharts(document.querySelector("#chart-13"), chart);
    chart1.render();

    var options = {
        series: [{
            name: "Sales Revenue",
            data: [20, 15, 38, 20, 24, 19, 53, 19, 21, 18, 36, 18, 60, 20]
        }],
        chart: {
            height: 321,
            type: 'line',
            zoom: {
                enabled: false
            },
            dropShadow: {
                enabled: true,
                enabledOnSeries: undefined,
                top: 2,
                left: 0,
                blur: 6,
                color: 'var(--primary-color)',
                opacity: 0.8
            },
            toolbar: { show: false }
        },
        dataLabels: {
            enabled: false
        },
        legend: {
            show: true,
            position: "top",
            offsetX: 0,
            offsetY: 8,
            markers: {
                width: 5,
                height: 5,
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
            width: '2',
        },
        grid: {
            borderColor: '#f5f4f4',
            strokeDashArray: 3
        },
        colors: ["var(--primary-color)"],
        yaxis: {
            labels: {
                formatter: function (y) {
                    return y.toFixed(0) + "";
                }
            }
        },
        xaxis: {
            type: 'week',
            categories: ['0.1', '0.2', '0.3', '0.4', '0.5', '0.6', '0.7', '0.8', '0.9', '1', '1.1', '1.2', '1.3', '1.4'],
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
    var chart = new ApexCharts(document.querySelector("#salerevenue1"), options);
    chart.render();

    var options = {
        series: [
            {
                name: "Sales",
                data: [15, 30, 22, 49, 32, 45, 30, 45, 65, 45, 25, 45],
            },
            {
                name: "Refunds",
                data: [-8, -40, -15, -32, -45, -30, -20, -35, -28, -43, -30, -40],
            }
        ],
        chart: {
            type: "area",
            height: 320,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            },
        },
        colors: [
            "rgb(88, 155, 255)",
            "rgb(175 ,109, 237)",
        ],
        markers: {
            size: 3,
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
            width: [2, 2],
            lineCap: 'round',
        },
        grid: {
            borderColor: "#edeef1",
            strokeDashArray: 2,
        },
        yaxis: {
            axisBorder: {
                show: true,
                color: "rgba(175 ,109, 237, 0.05)",
                offsetX: 0,
                offsetY: 0,
            },
            axisTicks: {
                show: true,
                borderType: "solid",
                color: "rgba(175 ,109, 237, 0.05)",
                width: 6,
                offsetX: 0,
                offsetY: 0,
            },
            // labels: {
            //     formatter: function (y) {
            //         return y.toFixed(0) + "";
            //     },
            // },
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
                show: false,
                color: "rgba(175 ,109, 237, 0.05)",
                offsetX: 0,
                offsetY: 0,
            },
            axisTicks: {
                show: false,
                borderType: "solid",
                color: "rgba(175 ,109, 237, 0.05)",
                width: 6,
                offsetX: 0,
                offsetY: 0,
            },
            labels: {
                rotate: -90,
            },
        },
    };
    var chart4 = new ApexCharts(document.querySelector("#salerevenue2"), options);
    chart4.render();

    var options = {
        series: [{
            name: 'Sales',
            data: [57, 36, 60, 57, 42, 44, 34, 64, 55, 36, 44, 42],
        },
        {
            type: 'bar',
            name: 'Revenue',
            data: [0, 34, 22, 37, 56, 56, 37, 22, 34, 25, 34, 42],
        }
        ],
        chart: {
            type: 'area',
            height: 350,
            toolbar: {
                show: false,
            },
            zoom: {
                enabled: false
            },
            dropShadow: {
                enabled: true,
                enabledOnSeries: undefined,
                top: 7,
                left: 1,
                blur: 3,
                color: ["#000", "#000"],
                opacity: 0.1
            },
        },
        grid: {
            show: false,
            borderColor: '#f2f6f7',
        },
        colors: ["rgba(var(--secondary-rgb), 1)", "var(--primary-color)"],
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
                            color: "rgba(var(--secondary-rgb), 0.05)",
                            opacity: 1
                        },
                        {
                            offset: 75,
                            color: "rgba(var(--secondary-rgb), 0.05)",
                            opacity: 1
                        },
                        {
                            offset: 100,
                            color: "rgba(var(--secondary-rgb), 0.05)",
                            opacity: 1
                        }
                    ],
                    [
                        {
                            offset: 0,
                            color: "var(--primary-color)",
                            opacity: 1
                        },
                        {
                            offset: 75,
                            color: "var(--primary-color)",
                            opacity: 1
                        },
                        {
                            offset: 100,
                            color: "var(--primary-color)",
                            opacity: 1
                        }
                    ]
                ]
            }
        },
        stroke: {
            curve: 'smooth',
            width: [1.5, 1.5],
            lineCap: 'round',
        },
        plotOptions: {
          bar: {
            columnWidth: "30%",
            borderRadius: 3
          },
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: true,
            position: "bottom",
            offsetX: 0,
            offsetY: 8,
            markers: {
                width: 8,
                height: 8,
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
        yaxis: {
            Show: true,
            labels: {
                show: true,
            },
            max: 70
        },
        xaxis: {
            show: false,
            type: 'day',
            categories: ['J', 'F', 'M', 'A', 'M', 'J', 'J', 'A', 'S', 'O', 'N', 'D'],
            axisBorder: {
                show: false,
                color: 'rgba(119, 119, 142, 0.05)',
                offsetX: 0,
                offsetY: 0,
            },
        }
    };
    var chart1 = new ApexCharts(document.querySelector("#top-sales"), options);
    chart1.render();

    var options = {
        series: [90, 80],
        chart: {
            height: 250,
            type: 'radialBar',
        },
        plotOptions: {
            radialBar: {
                startAngle: -180,
                endAngle: 180,
                hollow: {
                    margin: 20,
                    size: '60%',
                },
                dataLabels: {
                    name: {
                        fontSize: '25px',
                    },
                    value: {
                        fontSize: '16px',
                    },
                    total: {
                        show: true,
                        label: 'Total',
                        formatter: function (w) {
                            return 249
                        }
                    }
                }
            }
        },
        stroke: {
            dashArray: 6
        },
        colors: [
            "var(--primary-color)",
            "rgb(175 ,109, 237)",
        ],
        labels: ['Female', 'Male'],
    };
    var chart = new ApexCharts(document.querySelector("#activecustomers"), options);
    chart.render();

})();