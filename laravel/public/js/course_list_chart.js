// Chart global Setting
Chart.defaults.global.defaultFontFamily = '微軟正黑體';

// 成交率
// 成交率data 圖表設定
// new setting
const turnover_rate_config = {
  type: 'pie',
  data: {
    labels: ["留單數", "付訂數", "完款數", "未留單數", "退費數", "追完款數"],
    datasets: [{
      backgroundColor: ["#F9A03F", "#1f69ad", "#26a34f", "#ddd", "#d41e1e", "#1fcfbd"],
      data: [order, deposit, chart_settle_original, count_check - order - deposit - chart_settle_original - chart_settle_new - refund, refund, chart_settle_new]
    }]
  },
  options: {
    title: {
      display: true,
      text: '成交率：' + rate_settle,
      fontSize: 24
    },
    // legend: false,
    legendCallback: function (chart) {

      const labels = chart.data.labels
      const datasets = chart.data.datasets[0]

      let template = `<ul>`
      const liElements = datasets.data.map((value, i) => {
        return `<li>
                  <span style="background-color:${datasets.backgroundColor[i]}"></span>
                  <span>${labels[i]} : ${value}</span>
                </li>`
      }).join('')

      template += `${liElements}</ul>`
      return template
    },
    tooltips: {
      titleFontSize: 16,
      bodyFontSize: 16,
      callbacks: {
        label: function (tooltipItem, data) {
          const dataset = data.datasets[tooltipItem.datasetIndex];
          // 計算總和
          // const sum = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
          //   return currentValue;
          // });
          const currentValue = dataset.data[tooltipItem.index];
          // const percent = Math.round(((currentValue / count_check) * 1000));
          const percent = ((currentValue / count_check) * 100).toFixed(2);
          // console.log(count_check);
          // return (dataset.data[2] == currentValue) ? data.labels[tooltipItem.index] + ":" + currentValue : " " + data.labels[tooltipItem.index] + ":" + currentValue + " (" + percent + " %)";
          return " " + data.labels[tooltipItem.index] + "：" + currentValue + " (" + percent + " %)";;
        }
      }
    },
  }
}

// old setting
// var turnover_rate_config2 = {
//   type: 'pie',
//   data: {
//     labels: ["追完款數", "完款數", "實到人數"],
//     datasets: [{
//       backgroundColor: ["#F9A03F", "#D45113", "#f24"],
//       data: [4, 3, 25]
//     }]
//   },
//   options: {
//     title: {
//       display: true,
//       text: '成交率: 0.12%',
//       fontSize: '20'
//     },
//     legend: {
//       display: false,
//       width: 300,
//       height: 300,
//       labels: {
//         generateLabels: function (chart) {
//           var data = chart.data;
//           if (data.labels.length && data.datasets.length) {
//             return data.labels.map(function (label, i) {
//               var ds = data.datasets[0];
//               var arc = chart.getDatasetMeta(0).data[i];
//               var custom = arc && arc.custom || {};
//               var getValueAtIndexOrDefault = Chart.helpers.getValueAtIndexOrDefault;
//               var arcOpts = chart.options.elements.arc;
//               var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
//               var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
//               var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);

//               var value = chart.config.data.datasets[chart.getDatasetMeta(0).data[i]._datasetIndex].data[chart.getDatasetMeta(0).data[i]._index];

//               return {
//                 text: label + " : " + value,
//                 fillStyle: fill,
//                 strokeStyle: stroke,
//                 lineWidth: bw,
//                 hidden: isNaN(ds.data[i]) || chart.getDatasetMeta(0).data[i].hidden,
//                 index: i
//               };
//             });
//           } else {
//             return [];
//           }
//         }
//       }
//     }
//   }
// }

// 設定
const ctx_turnover_rate = document.getElementById("pie_chart_turnover_rate").getContext('2d');
const pie_chart_turnover_rate = new Chart(ctx_turnover_rate, turnover_rate_config);

// 報到率
// new setting
var check_in_rate_config = {
  type: 'pie',
  data: {
    labels: ["實到人數", "未到人數", "取消人數"],
    datasets: [{
      backgroundColor: ["#26a34f", "#ddd", "#d41e1e"],
      data: [count_check, count_apply - count_check, count_cancel]
    }]
  },
  options: {
    title: {
      display: true,
      text: '報到率：' + rate_check,
      fontSize: 24
    },
    // legend: false,
    legendCallback: function (chart) {

      const labels = chart.data.labels
      const datasets = chart.data.datasets[0]

      let template = `<ul>`
      const liElements = datasets.data.map((value, i) => {
        return `<li>
                  <span style="background-color:${datasets.backgroundColor[i]}"></span>
                  <span>${labels[i]} : ${value}</span>
                </li>`
      }).join('')

      template += `${liElements}</ul>`
      return template
    },
    tooltips: {
      titleFontSize: 16,
      bodyFontSize: 16,
      callbacks: {
        label: function (tooltipItem, data) {
          const dataset = data.datasets[tooltipItem.datasetIndex];
          // 計算總和
          const sum = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
            return currentValue;
            //return previousValue + currentValue;
          });
          const currentValue = dataset.data[tooltipItem.index];
          //const percent = Math.round(((currentValue / sum) * 100));
          return " " + data.labels[tooltipItem.index] + ":" + currentValue
          //return " " + data.labels[tooltipItem.index] + ":" + currentValue + " (" + percent + " %)";;
        }
      }
    },
  }
}

// old setting
// var check_in_rate_config2 = {
//   type: 'pie',
//   data: {
//     labels: ["實到人數", "報名筆數"], // 實到、未到、取消 下方呈現 報名比數
//     datasets: [{
//       backgroundColor: ["#16F4D0", "#153B50"],
//       data: [25, 67]
//     }]
//   },
//   options: {
//     title: {
//       display: true,
//       text: '報到率: 41.6%',
//       fontSize: '24'
//     },
//     legend: {
//       display: false,
//       labels: {
//         generateLabels: function (chart) {
//           var data = chart.data;
//           if (data.labels.length && data.datasets.length) {
//             return data.labels.map(function (label, i) {
//               // var ds = data.datasets[0];
//               // var arc = chart.getDatasetMeta(0).data[i];
//               // var custom = arc && arc.custom || {};
//               // var getValueAtIndexOrDefault = Chart.helpers.getValueAtIndexOrDefault;
//               // var arcOpts = chart.options.elements.arc;
//               // var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
//               // var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
//               // var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);

//               var value = chart.config.data.datasets[chart.getDatasetMeta(0).data[i]._datasetIndex].data[chart.getDatasetMeta(0).data[i]._index];

//               return {
//                 text: label + " : " + value,
//                 // fillStyle: fill,
//                 // strokeStyle: stroke,
//                 // lineWidth: bw,
//                 // hidden: isNaN(ds.data[i]) || chart.getDatasetMeta(0).data[i].hidden,
//                 // index: i
//               };
//             });
//           } else {
//             return [];
//           }
//         }
//       }
//     }
//   }
// }

const ctx_pie_chart_check_in_rate = document.getElementById("pie-chart_check_in_rate").getContext('2d');
const pie_chart_check_in_rate = new Chart(ctx_pie_chart_check_in_rate, check_in_rate_config);

/*
$('#refresh').on('click', function (e) {
  // ajax 回來更新圖表
  turnover_rate_config.data.datasets[0].data = [60, 40]
  var rate_value = "20.5%"
  turnover_rate_config.options.title.text = `成交率: ${rate_value}`
  pie_chart_turnover_rate.update()
});
*/