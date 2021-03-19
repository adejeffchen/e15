var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: agesRange,
        datasets: [{
            label: 'Annual Expense Forecast',
            fill: false,
            borderColor: 'rgb(2, 117, 216)',
            data: expenseForecast
        }, {
            label: 'Total Liquid Assets',
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