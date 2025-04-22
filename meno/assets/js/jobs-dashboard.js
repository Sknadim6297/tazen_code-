(function () {
    "use strict";

    /* application statistics */
    var options = {
        series: [{
            name: "Total Applications",
            type: "column",
            data: [54, 47, 38, 32, 21, 37, 23, 31, 32, 33, 20, 30]
        }, {
            name: "Total Applicants",
            type: "area",
            data: [41, 43, 27, 22, 44, 35, 56, 43, 55, 27, 42, 21]
        }, {
            name: "Total Recruited",
            type: "column",
            data: [64, 51, 36, 51, 59, 35, 25, 39, 45, 30, 30, 36]
        }],
        chart: {
            height: 334,
            type: "line",
            stacked: false,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        stroke: {
            width: [0, 2, 1.5],
            dashArray: [0, 0, 5],
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
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
                columnWidth: "27%",
                borderRadius: 3
            }
        },
        fill: {
          type: ["solid",'gradient', 'solid'],
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
                      color: 'var(--primary02)',
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
                          color: 'rgba(var(--success-rgb), 0.2)',
                          opacity: 0.1
                      }
                  ],
              ]
          }
      },
        legend: {
            position: "top",
            markers: {
                size: 4,
                strokeWidth: 0,
                strokeColor: '#fff',
                fillColors: undefined,
                radius: 5,
                customHTML: undefined,
                onClick: undefined,
                offsetX: 0,
                offsetY: 0
              },
        },
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        markers: {
            size: 0
        },
        colors: ["var(--primary-color)", "rgba(var(--secondary-rgb), 1)", "rgba(var(--success-rgb), 1)"]
    };
    var chart = new ApexCharts(document.querySelector("#application-statistics"), options);
    chart.render();
    /* application statistics */


    /* Candidates Chart */
    var options = {
        series: [1754, 1234],
        labels: ["Female", "Male"],
        chart: {
            height: 248,
            type: 'donut'
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
                            offsetY: -4
                        },
                        value: {
                            show: true,
                            fontSize: '18px',
                            color: undefined,
                            offsetY: 8,
                            formatter: function (val) {
                                return val + "%"
                            }
                        },
                        total: {
                            show: true,
                            showAlways: true,
                            label: 'Total',
                            fontSize: '22px',
                            fontWeight: 600,
                            color: '#495057',
                        }

                    }
                }
            }
        },
        colors: ["var(--primary-color)", "rgba(var(--secondary-rgb), 1)"],

    };
    var chart = new ApexCharts(document.querySelector("#candidates-chart"), options);
    chart.render();
    /* job statistics */

    /* recruitment summary */
    var options = {
        series: [{
          name: 'Last Week',
          data: [44, 42, 57, 86, 58, 55, 70],
        }, {
          name: 'This Week',
          data: [34, 22, 47, 56, 21, 35, 60],
        }
        ],
        chart: {
          type: 'bar',
          height: 262,
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
            columnWidth: '45%',
            borderRadius: 1,
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
          position: "top",
          markers: {
            size: 4,
            strokeWidth: 0,
            strokeColor: '#fff',
            fillColors: undefined,
            radius: 5,
            customHTML: undefined,
            onClick: undefined,
            offsetX: 0,
            offsetY: 0
          },
        },
      };
    var chart = new ApexCharts(document.querySelector("#recruitment-summary"), options);
    chart.render();
    /* recruitment summary */

})();