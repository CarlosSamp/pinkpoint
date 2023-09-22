var charts = parseInt(jQuery('#countCharts').text());

var i;
var labelsArray = [];
var objectsArray = [];
var colorsArray = [];

while ( i < charts) {

var id = 'barChart'+[i];
var ctx = document.getElementById(id).getContext('2d');
var labelsString = jQuery('#labels'+[i]).text();
labelsArray.push(labelsString.split(","));

var dataset = jQuery('#data'+[i]).text();

objectsArray.push(dataset.split(","));

var colors = jQuery('#colors'+[i]).text();

colorsArray.push(colors.split(";"));

var myChart = new Chart(ctx, {

	type: 'bar',
	data: {
		labels: labelsArray[i],
		datasets:[{
        label: "",
        data: objectsArray[i],
        fill: true,
        backgroundColor: colorsArray[i],
        borderColor: colorsArray[i],
        borderWidth: 1
        }]

	},
	options: {
        defaultColor: "rgba(255,0,0,0.1)",
		responsive: true,
		maintainAspectRatio: false,
        scales: {
			xAxes: [{
                ticks: {
                    min: 0,
                    stepSize: 1,
                    fontSize: 14,
                    fontColor: '#000'
                },
                gridLines: {
                    drawOnChartArea: false
                },
                barPercentage: 0.9,
                categoryPercentage: 1.0
            }],
			yAxes: [{
                gridLines: {
                    color: '#999',
                    drawOnChartArea: true
                },
                ticks: {
                    beginAtZero: true,
                    stepSize: 1
                },

                barPercentage: 1.0,
                categoryPercentage: 1.0
            }]
		},
		legend: {
            display: false,
            color: '#000',
			labels: {
				fontSize: 14,
				fontColor: '#000'
			}
		},
		tickMarkLength: 10,
		drawTicks: false,
		layout: {
			padding: {
				left: 40,
				right: 20,
				top: 0,
				bottom: 5
			}
		}
	}


});
i++;
console.log(myChart);
}
