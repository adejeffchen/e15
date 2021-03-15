var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: agesRange,
        datasets: [{
            label: 'Annual Expense Forecast',
            //backgroundColor: 'rgb(255,255,255)',
            fill: false,
            borderColor: 'rgb(2, 117, 216)',
            data: expenseForecast
        }, {
            label: 'Total Liquid Assets',
            //backgroundColor: 'rgb(255,255,255)',
            fill: false,
            borderColor: 'rgb(92, 184, 92)',
            data: investmentForecast
        }]
    },
    options: {
        scales: {
            xAxes: [{
                scaleLabel: {
                    display: true,
                    labelString: 'Age'
                }
            }],
            yAxes: [{
                ticks: {
                    // Include a dollar sign in the ticks
                    callback: function (value, index, values) {
                        return '$' + value;
                    }
                }
            }]
        }
    }
});