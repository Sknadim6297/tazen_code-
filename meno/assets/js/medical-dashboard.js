(function () {
    "use strict";

    /* patients stats */
    var options = {
        chart: {
          height: 320,
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
          curve: "smooth",
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
            name: "Last year",
            data: [65, 22, 38, 54, 82, 91, 60, 88, 125, 170, 120, 130],
            type: "bar",
          },
          {
            name: "This Year",
            data: [42, 98, 56, 120, 63, 81, 112, 38, 92, 105, 68, 48],
            type: "bar",
          },
        ],
        colors: ["var(--primary-color)", "rgba(var(--secondary-rgb), 1)"],
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
        plotOptions: {
            bar: {
                columnWidth: "40%",
                borderRadius: 4,
            }
        },
        xaxis: {
          type: "day",
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
            style: {
              colors: "#8c9097",
              fontSize: "11px",
              fontWeight: 600,
              cssClass: "apexcharts-xaxis-label",
            },
          },
        },
      };
    var chart = new ApexCharts(document.querySelector("#patients-stats"), options);
    chart.render();
    /* patients stats */

  /* Patients Overview */
  var options = {
      series: [
          {
              name: "Male",
              data: [80, 50, 30, 40, 100, 20, 80],
          },
          {
              name: "Female",
              data: [20, 100, 60, 50, 50, 80, 33],
          },
      ],
      chart: {
          height: 240,
          type: "radar",
          toolbar: {
              show: false,
          },
      },
      colors: ["rgba(var(--secondary-rgb), 0.1)", "var(--primary01)"],
      stroke: {
          width: 1.5,
          colors: ["rgba(var(--secondary-rgb), 1)", "var(--primary-color)"],
      },
      fill: {
          opacity: 0.1,
      },
      markers: {
          size: 0,
      },
      legend: {
          show: false,
          offsetX: 0,
          offsetY: 0,
          fontSize: "12px",
          markers: {
              width: 6,
              height: 6,
              strokeWidth: 0,
              strokeColor: "#fff",
              fillColors: undefined,
              radius: 5,
              customHTML: undefined,
              onClick: undefined,
              offsetX: 0,
              offsetY: 0,
          },
      },
      xaxis: {
          categories: ["Cardio", "Pediatrics", "Ortho", "Neuro", "Psychiatry", "Radio", "Others"],
          axisBorder: { show: false },
          labels: {
            style: {
              fontSize: '11px',
            }
          }
      },
      yaxis: {
          axisBorder: { show: false },
      },
      grid: {
          padding: {
              bottom: -25
          }
      },
  };
  var chart = new ApexCharts(document.querySelector("#patients-overview"), options);
  chart.render();
  /* Patients Overview */


})();