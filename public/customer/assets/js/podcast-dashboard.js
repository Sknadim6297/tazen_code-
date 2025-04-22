(function () {
    "use strict";

    var options = {
        series: [{
            name: 'Hours',
            data: [40, 35, 66, 28, 38, 55, 45]
        }],
        chart: {
            height: 206,
            fontFamily: 'Poppins, Arial, sans-serif',
            type: 'line',
            toolbar: {
                show: false
            }
        },
        grid: {
            show: false,
            borderColor: '#f2f6f7',
        },
        dataLabels: {
            enabled: false
        },
        legend: {
            position: 'top',
            fontSize: '13px',
        },
        colors: ["var(--primary08)"],
        stroke: {
            width: [2],
            curve: 'smooth',
        },
        plotOptions: {
            bar: {
                columnWidth: "30%",
                borderRadius: 3,
				colors: {
					ranges: [{
						from: 41,
						to: 100,
						color: 'rgba(175 ,109, 237, 0.8)'
					}, {
						from: 0,
						to: 40,
						color: 'var(--primary08)'
					}]
				},
            }
        },
        tooltip: {
          enabled: true,
          theme: "dark",
        },
        labels: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
    };
    var chart3 = new ApexCharts(document.querySelector("#podcast-activity"), options);
    chart3.render();

})()
