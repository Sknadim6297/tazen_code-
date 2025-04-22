(function() {
    "use strict";

    var myElement1 = document.getElementById('files-main-nav');
    new SimpleBar(myElement1, { autoHide: true });

    var myElement3 = document.getElementById('filemanager-file-details');
    new SimpleBar(myElement3, { autoHide: true });

    var options = {
        series: [35, 34, 26, 29],
        labels: ["Media", "Downloads", "Apps", "Documents"],
        chart: {
            height: 220,
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
                startAngle: -90,
                endAngle: 90,
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
                            offsetY: 3,
                        },
                        value: {
                            show: true,
                            fontSize: '28px',
                            fontWeight: 600,
                            color: undefined,
                            offsetY: -35,
                            formatter: function (val) {
                                return val + "%"
                            },
                        },
                        total: {
                            show: true,
                            showAlways: true,
                            label: 'Used of 256 GB',
                            fontSize: '12px',
                            fontWeight: 400,
                        }

                    }
                }
            }
        },
        grid: {
            padding: {
                bottom: -100
            }
        },
        colors: ["var(--primary08)", "rgba(175 ,109, 237, 0.8)", "rgba(40 ,215 ,133, 0.8)", "rgb(241 ,113 ,177)"],
    };
    var chart = new ApexCharts(document.querySelector("#file-manager-storage"), options);
    chart.render();


})();