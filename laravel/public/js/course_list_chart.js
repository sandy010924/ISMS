  // 成交率
new Chart(document.getElementById("pie_chart_turnover_rate"), {
  type: 'pie',
  data: {
    labels: ["成交數", "未成交數 "], // 成交數、未成交數 下方呈現 食道人數
    datasets: [{
      backgroundColor: ["#F9A03F", "#D45113"],
      data: [3,25]
    }]
  },
  options: {
    title: {
      display: true,
      text: '成交率: 0.12%',
      fontSize: '26'
    },
    legend: {
      display: true,
      labels: {
        generateLabels: function (chart) {
            var data = chart.data;
            if (data.labels.length && data.datasets.length) {
                return data.labels.map(function (label, i) {
                    var ds = data.datasets[0];
                    var arc = chart.getDatasetMeta(0).data[i];
                    var custom = arc && arc.custom || {};
                    var getValueAtIndexOrDefault = Chart.helpers.getValueAtIndexOrDefault;
                    var arcOpts = chart.options.elements.arc;
                    var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
                    var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
                    var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);

                    var value = chart.config.data.datasets[chart.getDatasetMeta(0).data[i]._datasetIndex].data[chart.getDatasetMeta(0).data[i]._index];

                    return {
                        text: label + " : " + value,
                        fillStyle: fill,
                        strokeStyle: stroke,
                        lineWidth: bw,
                        hidden: isNaN(ds.data[i]) || chart.getDatasetMeta(0).data[i].hidden,
                        index: i
                    };
                });
            } else {
                return [];
            }
        }
      }
    }
  }
});

// 報到率
new Chart(document.getElementById("pie-chart_check_in_rate"), {
    type: 'pie',
    data: {
      labels: ["實到人數","未到人數", "取消人數"], // 實到、未到、取消 下方呈現 報名比數
      datasets: [{
        backgroundColor: ["#16F4D0","#429EA6","#153B50"],
        data: [25,7,67]
      }]
    },
    options: {
      title: {
        display: true,
        text: '報到率: 41.6%',
        fontSize: '26'
      },
      legend: {
        display: true,
        labels: {
          generateLabels: function (chart) {
              var data = chart.data;
              if (data.labels.length && data.datasets.length) {
                  return data.labels.map(function (label, i) {
                      var ds = data.datasets[0];
                      var arc = chart.getDatasetMeta(0).data[i];
                      var custom = arc && arc.custom || {};
                      var getValueAtIndexOrDefault = Chart.helpers.getValueAtIndexOrDefault;
                      var arcOpts = chart.options.elements.arc;
                      var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
                      var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
                      var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);

                      var value = chart.config.data.datasets[chart.getDatasetMeta(0).data[i]._datasetIndex].data[chart.getDatasetMeta(0).data[i]._index];

                      return {
                          text: label + " : " + value,
                          fillStyle: fill,
                          strokeStyle: stroke,
                          lineWidth: bw,
                          hidden: isNaN(ds.data[i]) || chart.getDatasetMeta(0).data[i].hidden,
                          index: i
                      };
                  });
              } else {
                  return [];
              }
          }
        }
      }
    }
});