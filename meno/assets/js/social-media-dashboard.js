(function () {
    "use strict";

    /* youtube subscribers */
    let options2 = {
        series: [{
            data: [20, 14, 19, 10, 23, 20, 22, 9, 12]
        }],
        chart: {
            height: 30,
            width: 100,
            type: 'area',
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
                  ],
                ]
            }
        },
    };
    const chart2 = new ApexCharts(document.querySelector("#youtube-subscribers"), options2);
    chart2.render();
    /* youtube subscribers */

    /* twitter followers */
    var social2 = {
        chart: {
            type: 'area',
            height: 30,
            width: 100,
            sparkline: {
                enabled: true
            }
        },
        stroke: {
            width: [1.5],
        },
        series: [{
            name: 'Value',
            data: [20, 14, 20, 22, 9, 12, 19, 10, 25]
        }],
        yaxis: {
            min: 0,
            show: false,
            axisBorder: {
                show: false
            },
        },
        xaxis: {
            show: false,
            axisBorder: {
                show: false
            },
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
        colors: ["rgb(175 ,109, 237)"],
        fill: {
            type: 'gradient',
            gradient: {
                opacityFrom: 0.5,
                opacityTo: 0.2,
                stops: [0, 60]
            }
        }

    }
    var social2 = new ApexCharts(document.querySelector("#twitter-followers"), social2);
    social2.render();
    /* twitter followers */

    /* facebook followers */
    var social3 = {
        chart: {
            type: 'area',
            height: 30,
            width: 100,
            sparkline: {
                enabled: true
            }
        },
        stroke: {
            width: [1.5],
        },
        fill: {
            type: 'gradient',
            gradient: {
                opacityFrom: 0.9,
                opacityTo: 0.9,
                stops: [0, 98],
            }
        },
        series: [{
            name: 'Value',
            data: [20, 20, 22, 9, 14, 19, 10, 25, 12]
        }],
        yaxis: {
            min: 0,
            show: false,
            axisBorder: {
                show: false
            },
        },
        xaxis: {
            show: false,
            axisBorder: {
                show: false
            },
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
        colors: ["rgb(40 ,215 ,133)"],
        fill: {
            type: 'gradient',
            gradient: {
                opacityFrom: 0.5,
                opacityTo: 0.2,
                stops: [0, 60]
            }
        },

    }
    var social3 = new ApexCharts(document.querySelector("#facebook-followers"), social3);
    social3.render();
    /* facebook followers */

    /* instagram followers */
    var social4 = {
        chart: {
            type: 'area',
            height: 30,
            width: 100,
            sparkline: {
                enabled: true
            }
        },
        stroke: {
            width: [1.5],
        },
        fill: {
            type: 'gradient',
            gradient: {
                opacityFrom: 0.9,
                opacityTo: 0.9,
                stops: [0, 98],
            }
        },
        series: [{
            name: 'Value',
            data: [20, 20, 22, 9, 12, 14, 19, 10, 25]
        }],
        yaxis: {
            min: 0,
            show: false,
            axisBorder: {
                show: false
            },
        },
        xaxis: {
            show: false,
            axisBorder: {
                show: false
            },
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
        colors: ["rgb(241 ,113 ,177)"],
        fill: {
            type: 'gradient',
            gradient: {
                opacityFrom: 0.5,
                opacityTo: 0.2,
                stops: [0, 60]
            }
        },

    }
    var social4 = new ApexCharts(document.querySelector("#instagram-followers"), social4);
    social4.render();
    /* instagram followers */
    
    /* Audience Report */
    var options = {
        series: [
            {
                name: "Followers",
                data: [20, 38, 38, 72, 55, 63, 43, 76, 55, 80, 40, 80],
                // type: "column",
            }
        ],
        chart: {
            height: 267,
            type: "area",
            toolbar: {
                show: false,
            },
            zoom: {
                enabled: false,
            },
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
                      color: 'var(--primary08)',
                      opacity: 1
                    },
                    {
                      offset: 60,
                      color: 'var(--primary08)',
                      opacity: 0.1
                    }
                  ]
                ]
            }
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            position: "top",
            horizontalAlign: "center",
        },
        stroke: {
            curve: "smooth",
            width: ["2"],
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
        colors: ["var(--primary-color)"],
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
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ],
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
            labels: {
                rotate: -90,
            },
        },
    };
    var chart = new ApexCharts(document.querySelector("#audience-report"), options);
    chart.render();
    /* Audience Report */

    /* audience age metrics */
    var options = {
        series: [{
            data: [462, 451, 350, 530, 470, 500, 485],
            name: 'Total Audience',
        }],
        chart: {
            type: 'bar',
            height: 375,
            toolbar: {
                show: false
            },
        },
        plotOptions: {
            bar: {
                barHeight: '30%',
                borderRadius: 2,
                horizontal: true,
                distributed: true,
            }
        },
        legend: {
            show: false
        },
        dataLabels: {
            enabled: false,
        },
        grid: {
            borderColor: '#ffffff',
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
        colors: ["var(--primary08)", "rgba(175 ,109, 237, 0.8)", "rgba(40 ,215 ,133, 0.8)", "rgba(241 ,113 ,177, 0.8)", "rgba(12, 163, 231, 0.8)", "rgba(243, 157, 45, 0.8)", "rgba(254, 84, 84, 0.8)"],
        xaxis: {
            categories: ['10-20', '20-30', '30-40', '40-50', '50-60', '60-70', '70-80'],
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
        tooltip: {
            theme: "dark",
        }
    };
    var chart = new ApexCharts(document.querySelector("#audience-age-metrics"), options);
    chart.render();
    /* audience age metrics */

    /* audience reached */
    var options = {
        series: [17546, 11378],
        labels: ["Male", "Female"],
        chart: {
            height: 198,
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
        plotOptions: {
            pie: {
                offsetY: 10,
                expandOnClick: false,
                donut: {
                    size: '85%',
                    background: 'transparent',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '20px',
                            color: '#495057',
                            fontFamily: "Montserrat, sans-serif",
                            offsetY: -5
                        },
                        value: {
                            show: true,
                            fontSize: '22px',
                            color: undefined,
                            offsetY: 5,
                            fontWeight: 600,
                            fontFamily: "Montserrat, sans-serif",
                            formatter: function (val) {
                                return val + "%"
                            }
                        },
                        total: {
                            show: true,
                            showAlways: true,
                            label: 'Total Audience',
                            fontSize: '14px',
                            fontWeight: 400,
                            color: '#495057',
                        }
                    }
                }
            }
        },
        colors: ["var(--primary-color)", "rgba(175 ,109, 237, 1)"],
    };
    var chart = new ApexCharts(document.querySelector("#audience-reached"), options);
    chart.render();
    /* audience reached */

    /* Visitors By Country Map */
    var markers = [
        {
            name: "Usa",
            coords: [40.3, -101.38],
        },
        {
            name: "India",
            coords: [20.5937, 78.9629],
        },
        {
            name: "Vatican City",
            coords: [41.9, 12.45],
        },
        {
            name: "Canada",
            coords: [56.1304, -106.3468],
        },
        {
            name: "Mauritius",
            coords: [-20.2, 57.5],
        },
        {
            name: "Singapore",
            coords: [1.3, 103.8],
        },
        {
            name: "Palau",
            coords: [7.35, 134.46],
        },
        {
            name: "Maldives",
            coords: [3.2, 73.22],
        },
        {
            name: "São Tomé and Príncipe",
            coords: [0.33, 6.73],
        },
    ];
    var map = new jsVectorMap({
        map: "world_merc",
        selector: "#visitors-countries",
        markersSelectable: true,
        zoomOnScroll: false,
        zoomButtons: false,

        onMarkerSelected(index, isSelected, selectedMarkers) {
            console.log(index, isSelected, selectedMarkers);
        },

        // -------- Labels --------
        labels: {
            markers: {
                render: function (marker) {
                    return marker.name;
                },
            },
        },

        // -------- Marker and label style --------
        markers: markers,
        markerStyle: {
            hover: {
                stroke: "#DDD",
                strokeWidth: 3,
                fill: "#FFF",
            },
            selected: {
                fill: "#ff525d",
            },
        },
        regionStyle: {
            initial: {
                stroke: "var(--primary01)",
                strokeWidth: 1.5,
            }
        },
        markerLabelStyle: {
            initial: {
                fontFamily: "Poppins",
                fontSize: 13,
                fontWeight: 500,
                fill: "#35373e",
            },
        },
    });
    /* Visitors By Country Map */

    /* sessions by device */
    var options = {
        series: [
            {
                name: "Tablet",
                data: [[10, 35, 80]]
            },
            {
                name: "Mobile",
                data: [[22, 10, 80]]
            },
            {
                name: "Desktop",
                data: [[25, 25, 150]]
            },
        ],
        chart: {
            height: 364,
            type: "bubble",
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        grid: {
            borderColor: '#f3f3f3',
            strokeDashArray: 3
        },
        colors: ["var(--primary-color)", "rgb(175 ,109, 237)", "rgb(40 ,215 ,133)"],
        dataLabels: {
            enabled: false
        },
        legend: {
            show: true,
            fontSize: '13px',
            labels: {
                colors: '#959595',
            },
            markers: {
                width: 10,
                height: 10,
            },
        },
        xaxis: {
            min: 0,
            max: 50,
            labels: {
                show: false,
            },
            axisBorder: {
                show: false,
            },
        },
        yaxis: {
            max: 50,
            labels: {
                show: false,
            },
        },
        tooltip: {
            enabled: true,
            theme: "dark",
        }
    };
    var chart1 = new ApexCharts(document.querySelector("#sessions-device"), options);
    chart1.render();
    /* sessions by device */

})()