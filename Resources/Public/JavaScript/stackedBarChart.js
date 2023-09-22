var ctx = document.getElementById('chartStacked').getContext('2d');

var str = jQuery('#labels').text();
var labels = str.split(",");

var objectsString = jQuery('#data').text();
var objectsArray = objectsString.split(";")
var tempData = [];

for ( var i=0; i< objectsArray.length; i++ ) {
        tempData.push(JSON.parse(objectsArray[i]));
}
objectsArray = tempData;

// from here Snippets from Chart.js documentation https://www.chartjs.org/docs/latest/charts/bar.html
var myChart = new Chart(ctx, {

	type: 'horizontalBar',
	data: {
		labels: labels,
		datasets: objectsArray
	},
	options: {
		responsive: true,
		maintainAspectRatio: false,
		scales: {
			xAxes: [{
				stacked: true,
                ticks: {
                    min: 0,
                    stepSize: 1,
                    fontSize: 18,
                    fontColor: '#000'
                },
                gridLines: {
                    color: '#666'
                },
            }],
			yAxes: [{

				stacked: true,
                gridLines: {
                    drawOnChartArea: false
                },
                ticks: {
                    mirror: true,
                    padding: 50,
                    fontSize: 14,
                    fontColor: '#000'
                },

                categoryPercentage: 1.0
            }]
		},
        legend: {
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
                right: 0,
                top: 0,
                bottom: 0
            }
        }
	}


});
