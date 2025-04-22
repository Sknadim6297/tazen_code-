(function () {
  "use strict";

  /* Sales Revenue */
  var options = {
    chart: {
      height: 367,
      toolbar: {
        show: false,
      },
      zoom: {
        enabled: false,
      },
      dropShadow: {
        enabled: true,
        enabledOnSeries: undefined,
        top: 7,
        left: 0,
        blur: 1,
        color: ["var(--primary-color)", "var(--primary02)", "rgb(255, 90, 41)"],
        opacity: 0.05,
      },
    },
    grid: {
      show: true,
      borderColor: "rgba(119, 119, 142, 0.1)",
      strokeDashArray: 4,
    },
    dataLabels: {
      enabled: false,
    },
    stroke: {
      width: [1.5, 1.5],
      curve: "straight",
    },
    legend: {
      show: true,
      position: "top",
      horizontalAlign: "center",
      fontWeight: 600,
      fontSize: "11px",
      labels: {
        colors: "#74767c",
      },
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
    series: [
      {
        name:  "Sales",
        data: [5,15, 21,20,15,40,55,55, 55,30,45,100,85, 85,85,130,100,56, 131,140,195,140,140,140, 85,115,106,100,100,110, 129,140,137,135,140,145, 153,157,160,220,110,100,95, 90,90,105,92,105,120,122, 150,130,117, 108,120,127,150,],
        type: "area",
      },
      {
        name:"Marketing",
        data: [40,45, 47,49,52,50,80,86, 85,70,89,130,100, 110,110,180,130,106, 140,110,110,90,80,110, 135,145,120,110,110,120, 139,150,117,110,110,100, 123,137,110,110,130,140,135, 140,190,125,102,105,100,92, 108,120,127,150,130,117],
        type: "line",
      },
    ],
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
              color: 'rgb(255, 90, 41)',
              opacity: 1
            },
            {
              offset: 75,
              color: 'rgb(255, 90, 41)',
              opacity: 1
            },
            {
              offset: 100,
              color: 'rgb(255, 90, 41)',
              opacity: 1
            }
          ],
        ]
      }
    },
    colors: ["var(--primary-color)", "rgb(184 ,122 ,243)"],
    yaxis: {
      min:0,
      title: {
        style: {
          color: "#adb5be",
          fontSize: "14px",
          fontFamily: "poppins, sans-serif",
          fontWeight: 600,
          cssClass: "apexcharts-yaxis-label",
        },
      },
    },
    xaxis: {
      type: "day",
      categories: [
        "Jan",
        "",
        "",
        "",
        "",
        "Feb",
        "",
        "",
        "",
        "",
        "Mar",
        "",
        "",
        "",
        "",
        "Apr",
        "",
        "",
        "",
        "",
        "May",
        "",
        "",
        "",
        "",
        "Jun",
        "",
        "",
        "",
        "",
        "Jul",
        "",
        "",
        "",
        "",
        "Aug",
        "",
        "",
        "",
        "",
        "Sep",
        "",
        "",
        "",
        "",
        "Oct",
        "",
        "",
        "",
        "",
        "Nov",
        "",
        "",
        "",
        "",
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
        style: {
          colors: "#8c9097",
          fontSize: "11px",
          fontWeight: 600,
          cssClass: "apexcharts-xaxis-label",
        },
      },
    },
  };
  var chart = new ApexCharts(document.querySelector("#sales-revenue"), options);
  chart.render();
  /* Sales Revenue */

  /* Sales Summary */
  var options = {
    series: [14, 18, 17, 15, 12, 10],
    chart: {
        type: 'polarArea',
        height: 251,
        
    },
    stroke: {
        colors: ['#fff'],
    },
    fill: {
        opacity: 1
    },
  legend: {
    show: false,
        position: 'bottom',
        itemMargin: {
            horizontal: 5,
            vertical: 5
        },
        fontFamily: "Montserrat",
    },
    labels: ['Delivered','Cancelled','Pending','Returned', 'Shipped', 'Failed'],
    colors: ["var(--primary-color)", "rgba(175 ,109, 237,0.7)", "rgba(40 ,215 ,133,0.7)", "rgba(241 ,113 ,177,0.7)", "rgba(221 ,58, 82,0.7)", "rgba(253 ,126 ,20,0.7)"],
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 200,
                
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
  };
  var chart = new ApexCharts(document.querySelector("#sales-summary"), options);
  chart.render();
  /*Sales Summary */

  /* Visitors Device */   
  var options = {
    series: [
      {
        name: "This Week",
        data: [25, 50, 30, 55, ]
      },
      
    ],
    chart: {
    height: 300,
    type: 'bar',
    offsetY: -10
  },
  plotOptions: {
    
    bar: {
      startAngle: -135,
      endAngle: 135,
      columnWidth: "40%",

      dataLabels: {
        name: {
          fontSize: '16px',
          color: undefined,
          offsetY: 120
        },
        value: {
          offsetY: 76,
          fontSize: '22px',
          color: undefined,
          formatter: function (val) {
            return val + "%";
          }
        }
      }
    }
  },

  stroke: {
    dashArray: 4
  },
  labels: ['Mobile','Desktop','Laptop','Tablet'],
  colors: ["var(--primary-color)", "rgba(175 ,109, 237,0.7)", "rgba(40 ,215 ,133,0.7)", "rgba(241 ,113 ,177,0.7)", ],
  };
  var chart = new ApexCharts(document.querySelector("#visitors-device"), options);
  chart.render();
  /* Visitors Device */

  /* line-graph charts */
  var options2 = {
    series: [{
    data: [25, 39, 15, 89, 47, 70, 44]
  }],
    chart: {
    type: 'line',
    width: 100,
    height: 35,
    sparkline: {
      enabled: true
    }
  },
  stroke: {
    width: [1.5],
    show: true,
    curve: 'smooth',
    lineCap: 'butt',
  },
  colors:["rgb(88 ,155, 255)"],
  tooltip: {
    fixed: {
      enabled: false
    },
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
  }
  };
  var chart2 = new ApexCharts(document.querySelector("#line-graph1"), options2);
  chart2.render();

  var options2 = {
    series: [{
    data: [5, 20, 15, 29, 17, 40, 4]
  }],
    chart: {
    type: 'line',
    width: 100,
    height: 35,
    sparkline: {
      enabled: true
    }
  },
  stroke: {
    width: [1.5],
    show: true,
    curve: 'smooth',
    lineCap: 'butt',
  },
  colors:["rgb(175 ,109, 237)"],
  tooltip: {
    fixed: {
      enabled: false
    },
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
  }
  };
  var chart2 = new ApexCharts(document.querySelector("#line-graph2"), options2);
  chart2.render();

  var options2 = {
    series: [{
    data: [55,9, 55, 29, 87, 70, 64]
  }],
    chart: {
    type: 'line',
    width: 100,
    height: 35,
    sparkline: {
      enabled: true
    }
  },
  stroke: {
    width: [1.5],
    show: true,
    curve: 'smooth',
    lineCap: 'butt',
  },
  colors:["rgb(40 ,215 ,133)"],
  tooltip: {
    fixed: {
      enabled: false
    },
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
  }
  };
  var chart2 = new ApexCharts(document.querySelector("#line-graph3"), options2);
  chart2.render();

  var options2 = {
    series: [{
    data: [2, 39, 5, 49, 37, 70, 24]
  }],
    chart: {
    type: 'line',
    width: 100,
    height: 35,
    sparkline: {
      enabled: true
    }
  },
  stroke: {
    width: [1.5],
    show: true,
    curve: 'smooth',
    lineCap: 'butt',
  },
  colors:["rgb(241 ,113 ,177)"],
  tooltip: {
    fixed: {
      enabled: false
    },
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
  }
  };
  var chart2 = new ApexCharts(document.querySelector("#line-graph4"), options2);
  chart2.render();

  var options2 = {
    series: [{
    data: [25, 89, 15, 89, 47, 70, 44]
  }],
    chart: {
    type: 'line',
    width: 100,
    height: 35,
    sparkline: {
      enabled: true
    }
  },
  stroke: {
    width: [1.5],
    show: true,
    curve: 'smooth',
    lineCap: 'butt',
  },
  colors:["rgb(253 ,126 ,20)"],
  tooltip: {
    fixed: {
      enabled: false
    },
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
  }
  };
  var chart2 = new ApexCharts(document.querySelector("#line-graph5"), options2);
  chart2.render();
  /* line-graph charts */

  /* Orders Summary */
  var options = {
    series: [1754, 834,549,234 ],
    labels: ["male", "female", "others","Not mentioned"],
    chart: {
        height: 310,
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
      width: 2,
      dashArray: 0,
    },
    plotOptions: {
        pie: {
            startAngle: -90,
            endAngle: 90,
            offsetY: 10,
            expandOnClick: false,
            donut: {
              size: '75%',
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
        bottom: -100
      }
    },
    colors: ["var(--primary-color)", "rgb(175 ,109, 237)", "rgb(40 ,215 ,133)", "rgb(241 ,113 ,177)"],
  };
  var chart = new ApexCharts(document.querySelector("#orders-summary"), options);
  chart.render();
  /* Orders Summary */


})();