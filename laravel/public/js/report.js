
var chartOptions = {
    scales: {
        yAxes: [{
            scaleLabel: { display: true },
            ticks: {
                beginAtZero: false,
                callback: function (value, index, values) {
                    // return value.toLocaleString()+'%';
                    return value.toLocaleString();
                },
                fontSize: 16,
            },
            stacked: true
        }],
        // xAxes: [{
        //     type: 'time',
        //     scaleLabel: { display: true },
        //     ticks: {
        //         beginAtZero: false,
        //         callback: function (value, index, values) {
        //             // return value.toLocaleString()+'%';
        //             return value.toLocaleString();
        //         },
        //         fontSize: 16,
        //     }
        // }]
    },
    title: {
        display: true,
        text: $("ul#reportTab li a.active").text(),
        fontSize: 20,
        fontFamily: "Microsoft JhengHei",
    },
    tooltips: {
        displayColors: false,
        titleFontSize: 16,
        titleFontFamily: "Microsoft JhengHei",
        bodyFontSize: 16,
        bodyFontFamily: "Microsoft JhengHei",
        hover: { mode: 'point' },
        callbacks: {
            label: function (tooltipItem, data) {
                const dataset = data.datasets[tooltipItem.datasetIndex];
                // console.log(dataset)
                // 計算總和
                // const sum = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
                //   return previousValue + currentValue;
                // });
                const currentValue = dataset.data[tooltipItem.index];
                const { y, x, course } = currentValue
                // console.log(currentValue)
                // return " " + data.labels[tooltipItem.index] + ":" + currentValue  + "%";
                // return " " + data.labels[tooltipItem.index] + ":" + currentValue  + "%";
                return [x, '', `${course}: ${y}`];
            },
            title: function (tooltipItem, data) {
                return;
            }
        }
    },
    legend: {
        display: true,
        position: 'top',
        labels: {
            padding: 20,
            boxWidth: 80,
            fontSize: 18,
            fontColor: 'black',
            fontFamily: 'Microsoft JhengHei',
        }
    }
};
