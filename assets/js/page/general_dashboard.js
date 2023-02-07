"use strict";
var strength_chart;
//Get Symbols Dashboard Filter
function getSymbolsChart_filter(filterType) {

  $.ajax({
    url: "getSymbolChartsFilter",
    method: "POST",
    data: {
      account_id: _account_id,
      filter_type: filterType,
      period: $('#period').val(),
      //symbols: symbols,
    },
    success: function (response) {

      var data = [];
      response = JSON.parse(response);
      
      if (response["status"] == "success") {
        data = response["data"];

      var xValues = [];
      var yValues = [];

      var xPLValues = [];
      var yPLValues = [];
      var barColors = [];

      data.map((d) => {
        xValues.push(d.Symbol);
        yValues.push(d.Strength);
        if(d.Strength > 0) {
          barColors.push("#0046bf")
        }
        else {
          barColors.push("#fe0000");
        }
      });

      data.map((d) => { 
        xPLValues.push(d.Symbol);
        yPLValues.push(d.Profit);
      });

    if(strength_chart)
      strength_chart.destroy();

      strength_chart = new Chart("strength_chart", {
        type: "bar",
        data: {
          labels: xValues,
          datasets: [{
            backgroundColor: barColors,
            data: yValues,
            borderSkipped: false
          }]
        },
        options: {
          legend: { display: false },

        }
      });
      // strength_chart.data.labels = xValues;
      // strength_chart.data.datasets[0].data = yValues;
      // console.log(strength_chart.data.datasets[0]);
      // strength_chart.data.datasets[0].backgroundColor = barColors;

      // strength_chart.update();

      var profit_chart = new Chart("profit_chart", {
        type: "bar",
        data: {
          labels: xPLValues,
          datasets: [{
            backgroundColor: barColors,
            data: yPLValues,
            borderSkipped: false
          }]
        },
        options: {
          legend: { display: false },

        }
      });
      } else {
        // notifyme.showNotification(response["status"], response["message"]);
      }
    },
  });
}
//Get Symbols Dashboard
function get_symbol_chart() {
  var filter_type = 1;
  $.ajax({
    url: "getSymbolCharts",
    method: "POST",
    data: {
      account_id: _account_id,
      filter_type: filter_type,
      // period: $('#period').val(),
      //symbols: symbols,
    },
    success: function (response) {
      var data = [];
      response = JSON.parse(response);
      console.log(response);
      if (response["status"] == "success") {
        data = response['data'];
        var xValues = [];
        var yValues = [];

        var xPLValues = [];
        var yPLValues = [];
        var barColors = [];
        data.map((d) => { 
          xValues.push(d.Symbol);
          yValues.push(d.Strength);
          if(d.Strength > 0) {
            barColors.push("#0046bf")
          }
          else {
            barColors.push("#fe0000");
          }
        });

        data.map((d) => { 
          xPLValues.push(d.Symbol);
          yPLValues.push(d.Profit);
        });


        var strength_chart = new Chart("strength_chart", {
          type: "bar",
          data: {
            labels: xValues,
            datasets: [{
              backgroundColor: barColors,
              data: yValues,
              borderSkipped: false
            }]
          },
          options: {
            legend: { display: false },

          }
        });

        var profit_chart = new Chart("profit_chart", {
          type: "bar",
          data: {
            labels: xPLValues,
            datasets: [{
              backgroundColor: barColors,
              data: yPLValues,
              borderSkipped: false
            }]
          },
          options: {
            legend: { display: false },

          }
        });
      } else {
        // notifyme.showNotification(response["status"], response["message"]);
      }
    },
  });
}

//Get Total Trade Summary Data
function get_Total_TradeSummary() {
  
  $.ajax({
    url: BASE_URL + "dashboard/getTotalTradeSummary",
    method: "POST",
    data: {
      account_id: _account_id
      // start_date: startDate,
      // end_date: endDate,
      // filter_type: filterType,
      // symbols: symbols,
    },
    success: function (response) {
      response = JSON.parse(response);
      if (response["status"] == "success") {
        var data = response["data"];
        $("#spanTotalTrades").text(data[0][0].TotalTrades);
        $("#spanTotalTrade").text(data[0][0].TotalTrades);
        $("#spanTotalBuyTrades").text(data[0][0].TotalBuyTrades);
        $("#spanTotalSellTrades").text(data[0][0].TotalSellTrades);
        $("#spanTotalWins").text(data[0][0].TotalWins);
        $("#spanTotalWin").text(data[0][0].TotalWins);
        $("#spanTotalBuyWins").text(data[0][0].TotalBuyWins);
        $("#spanTotalSellWins").text(data[0][0].TotalSellWins);
        $("#spanTotalLooses").text(data[0][0].TotalLooses);
        $("#spanTotalBuyLooses").text(data[0][0].TotalBuyLooses);
        $("#spanTotalSellLooses").text(data[0][0].TotalSellLooses);

        var xValues = ["Wins", "Losses"];
        var yValues = [data[0][0].TotalWins,data[0][0].TotalLooses];
        var barColors = [
          "#0046bf",
          "#fe0000",
          "#2b5797",
          "#e8c3b9",
          "#1e7145"
        ];

        var win_rate_chart = new Chart("general_win_rate_pie_chart", {
          type: "doughnut",
          data: {
            labels: xValues,
            datasets: [{
              backgroundColor: barColors,
              data: yValues
            }]
          },
          options: {
            legend: {
              display: true,
              labels: {
                  fontSize: 20
              }
            }
          }
        });
        $('.win_rate_chart').html("Win Rate "+(Math.round(data[0][0].TotalWins / data[0][0].TotalTrades * 100) )+"% From "+parseInt(data[0][0].TotalTrades))
        var buysellratio = (data[0][0].TotalSellTrades>0) ? (data[0][0].TotalBuyTrades / data[0][0].TotalSellTrades).toFixed(2) : 0;
        $('.buy_sell_chart').html("Buy-Sell Ratio "+buysellratio )

        $('.chart24heading').html("Wins "+data[0][0].TotalWins )
        $('.chart25heading').html("Losses "+data[0][0].TotalLooses )
        
        var buywinratio = (data[0][0].TotalBuyTrades>0) ? Math.round(data[0][0].TotalBuyWins / data[0][0].TotalBuyTrades * 100) : 0;
        $('.buy_win_rate_chart').html("Buy Win-Rate "+buywinratio + '%')
        
        var sellwinratio = (data[0][0].TotalSellTrades>0) ? Math.round(data[0][0].TotalSellWins / data[0][0].TotalSellTrades * 100) : 0;
        $('.sell_win_rate_chart').html("Sell Win-Rate "+sellwinratio+ '%' )

        var xValues = ["Buy "+data[0][0].TotalBuyTrades, "Sell "+data[0][0].TotalSellTrades];
        var yValues = [data[0][0].TotalBuyTrades, data[0][0].TotalSellTrades];
        var barColors = [
          "#0046bf",
          "#fe0000",
          "#2b5797",
          "#e8c3b9",
          "#1e7145"
        ];

        var buy_sell_chart = new Chart("general_buy_sell_chart", {
          type: "doughnut",
          data: {
            labels: xValues,
            datasets: [{
              backgroundColor: barColors,
              data: yValues
            }]
          },
          options: {
            legend: {
              display: true,
              labels: {
                  fontSize: 20
              }
            }
          }
        });


        var xValues = ["Buy "+data[0][0].TotalBuyWins, "Sell "+data[0][0].TotalSellWins];
        var yValues = [data[0][0].TotalBuyWins, data[0][0].TotalSellWins];
        var barColors = [
          "#0046bf",
          "#fe0000",
          "#2b5797",
          "#e8c3b9",
          "#1e7145"
        ];

        var win_chart = new Chart("general_wins_chart", {
          type: "doughnut",
          data: {
            labels: xValues,
            datasets: [{
              backgroundColor: barColors,
              data: yValues
            }]
          },
          options: {
            legend: {
              display: true,
              labels: {
                  fontSize: 20
              }
            }
          }
        });


        var xValues = ["Buy "+data[0][0].TotalBuyLooses, "Sell "+data[0][0].TotalSellLooses];
        var yValues = [data[0][0].TotalBuyLooses, data[0][0].TotalSellLooses];
        var barColors = [
          "#0046bf",
          "#fe0000",
          "#2b5797",
          "#e8c3b9",
          "#1e7145"
        ];

        var loss_chart = new Chart("general_losses_chart", {
          type: "doughnut",
          data: {
            labels: xValues,
            datasets: [{
              backgroundColor: barColors,
              data: yValues
            }]
          },
          options: {
            legend: {
              display: true,
              labels: {
                  fontSize: 20
              }
            }
          }
        });

        var xValues = ["Win "+data[0][0].TotalBuyWins, "Losses "+data[0][0].TotalBuyLooses];
        var yValues = [data[0][0].TotalBuyWins, data[0][0].TotalBuyLooses];
        var barColors = [
          "#0046bf",
          "#fe0000",
          "#2b5797",
          "#e8c3b9",
          "#1e7145"
        ];

        var buy_rate_chart = new Chart("general_buy_win_rate_chart", {
          type: "doughnut",
          data: {
            labels: xValues,
            datasets: [{
              backgroundColor: barColors,
              data: yValues
            }]
          },
          options: {
            legend: {
              display: true,
              labels: {
                  fontSize: 20
              }
            }
          }
        });


        var xValues = ["Win "+data[0][0].TotalSellWins, "Losses "+data[0][0].TotalSellLooses];
        var yValues = [data[0][0].TotalSellWins, data[0][0].TotalSellLooses];
        var barColors = [
          "#0046bf",
          "#fe0000",
          "#2b5797",
          "#e8c3b9",
          "#1e7145"
        ];

        var sell_rate_chart = new Chart("general_sell_win_rate_chart", {
          type: "doughnut",
          data: {
            labels: xValues,
            datasets: [{
              backgroundColor: barColors,
              data: yValues
            }]
          },
          options: {
            legend: {
              display: true,
              labels: {
                  fontSize: 20
              }
            }
          }
        });
        function drawChart() {
          // Win Rate 
          var c_WinRate = (data[0][0].TotalTrades>0) ? Math.round(data[0][0].TotalWins / data.TotalTrades * 100) : 0;
          var WinRatePie = _pie({
            element : 'totalWinRate',
            title : 'Win Rate',
            value : c_WinRate + '% <small>from</small> ' + data.TotalTrades,
            left : {
                title : 'Wins',
                value : data.TotalWins,
              }, 
            right : {
                title : 'Losses',
                value : data.TotalLooses,
              }
            });

          // Buy-Sell Ratio
          var c_BySellRatioPie = (data[0][0].TotalSellTrades>0) ? (data[0][0].TotalBuyTrades / data[0][0].TotalSellTrades).toFixed(2) : 0;
          var BySellRatioPie = _pie({
            element : 'totalBuySellRatio',
            title : 'Buy-Sell Ratio',
            value : c_BySellRatioPie,
            left : {
                title : 'Buy',
                value : data[0][0].TotalBuyTrades,
              }, 
            right : {
                title : 'Sell',
                value : data[0][0].TotalSellTrades,
              }
            });
            
          // Wins
          var WinsPie = _pie({
            element : 'totalWins',
            title : 'Wins',
            value : data.TotalWins,
            left : {
                title : 'Buy',
                value : data.TotalBuyWins,
              }, 
            right : {
                title : 'Sell',
                value : data.TotalSellWins,
              }
            });
            
          // Losses
          var LosesPie = _pie({
            element : 'totalLoses',
            title : 'Losses',
            value : data.TotalLooses,
            left : {
                title : 'Buy',
                value : data.TotalBuyLooses,
              }, 
            right : {
                title : 'Sell',
                value : data.TotalSellLooses,
              }
            });
  
          // Buy Win-Rate
          var c_LosesPie = (data.TotalBuyTrades>0) ? Math.round(data.TotalBuyWins / data.TotalBuyTrades * 100) : 0;
          var LosesPie = _pie({
            element : 'totalBuyWinRate',
            title : 'Buy Win-Rate',
            value :  c_LosesPie + '%',
            left : {
                title : 'Wins',
                value : data.TotalBuyWins,
              }, 
            right : {
                title : 'Losses',
                value : data.TotalBuyLooses,
              }
            });

          // Sell Win-Rate
          var c_SellWinRate = (data.TotalSellTrades>0) ? Math.round(data.TotalSellWins / data.TotalSellTrades * 100) : 0;
          var SellWinRate = _pie({
            element : 'totalSellWinRate',
            title : 'Sell Win-Rate',
            value :  c_SellWinRate + '%',
            left : {
                title : 'Wins',
                value : data.TotalSellWins,
              }, 
            right : {
                title : 'Losses',
                value : data.TotalSellLooses,
              }
            });            
        }
      } else {
        notifyme.showNotification(response["status"], response["message"]);
      }
    },
  });
}

function getTotalTradeSummary_filter(filterType) {
  $.ajax({
    url: BASE_URL + "dashboard/getTotalTradeSummaryFilter",
    method: "POST",
    data: {
      action: "getTotalTradeSummaryFilter",
      account_id: _account_id,
      filter_type: filterType,
      period: $('#period1').val(),
      // symbols: symbols,
    },
    success: function (response) {
      response = JSON.parse(response);
      if (response["status"] == "success") {
        var data = response["data"];
        $("#spanTotalTrades").text(data[0][0].TotalTrades);
        $("#spanTotalTrade").text(data[0][0].TotalTrades);
        $("#spanTotalBuyTrades").text(data[0][0].TotalBuyTrades);
        $("#spanTotalSellTrades").text(data[0][0].TotalSellTrades);
        $("#spanTotalWins").text(data[0][0].TotalWins);
        $("#spanTotalWin").text(data[0][0].TotalWins);
        $("#spanTotalBuyWins").text(data[0][0].TotalBuyWins);
        $("#spanTotalSellWins").text(data[0][0].TotalSellWins);
        $("#spanTotalLooses").text(data[0][0].TotalLooses);
        $("#spanTotalBuyLooses").text(data[0][0].TotalBuyLooses);
        $("#spanTotalSellLooses").text(data[0][0].TotalSellLooses);

        var xValues = ["Wins", "Losses"];
        var yValues = [data[0][0].TotalWins,data[0][0].TotalLooses];
        var barColors = [
          "#0046bf",
          "#fe0000",
          "#2b5797",
          "#e8c3b9",
          "#1e7145"
        ];

        var win_rate_chart = new Chart("general_win_rate_pie_chart", {
          type: "doughnut",
          data: {
            labels: xValues,
            datasets: [{
              backgroundColor: barColors,
              data: yValues
            }]
          },
          options: {
            legend: {
              display: true,
              labels: {
                  fontSize: 20
              }
            }
          }
        });
        $('.win_rate_chart').html("Win Rate "+(Math.round(data[0][0].TotalWins / data[0][0].TotalTrades * 100) )+"% From "+parseInt(data[0][0].TotalTrades))
        var buysellratio = (data[0][0].TotalSellTrades>0) ? (data[0][0].TotalBuyTrades / data[0][0].TotalSellTrades).toFixed(2) : 0;
        $('.buy_sell_chart').html("Buy-Sell Ratio "+buysellratio )

        $('.chart24heading').html("Wins "+data[0][0].TotalWins )
        $('.chart25heading').html("Losses "+data[0][0].TotalLooses )
        
        var buywinratio = (data[0][0].TotalBuyTrades>0) ? Math.round(data[0][0].TotalBuyWins / data[0][0].TotalBuyTrades * 100) : 0;
        $('.buy_win_rate_chart').html("Buy Win-Rate "+buywinratio + '%')
        
        var sellwinratio = (data[0][0].TotalSellTrades>0) ? Math.round(data[0][0].TotalSellWins / data[0][0].TotalSellTrades * 100) : 0;
        $('.sell_win_rate_chart').html("Sell Win-Rate "+sellwinratio+ '%' )

        var xValues = ["Buy "+data[0][0].TotalBuyTrades, "Sell "+data[0][0].TotalSellTrades];
        var yValues = [data[0][0].TotalBuyTrades, data[0][0].TotalSellTrades];
        var barColors = [
          "#0046bf",
          "#fe0000",
          "#2b5797",
          "#e8c3b9",
          "#1e7145"
        ];

        var buy_sell_chart = new Chart("general_buy_sell_chart", {
          type: "doughnut",
          data: {
            labels: xValues,
            datasets: [{
              backgroundColor: barColors,
              data: yValues
            }]
          },
          options: {
            legend: {
              display: true,
              labels: {
                  fontSize: 20
              }
            }
          }
        });


        var xValues = ["Buy "+data[0][0].TotalBuyWins, "Sell "+data[0][0].TotalSellWins];
        var yValues = [data[0][0].TotalBuyWins, data[0][0].TotalSellWins];
        var barColors = [
          "#0046bf",
          "#fe0000",
          "#2b5797",
          "#e8c3b9",
          "#1e7145"
        ];

        var win_chart = new Chart("general_wins_chart", {
          type: "doughnut",
          data: {
            labels: xValues,
            datasets: [{
              backgroundColor: barColors,
              data: yValues
            }]
          },
          options: {
            legend: {
              display: true,
              labels: {
                  fontSize: 20
              }
            }
          }
        });


        var xValues = ["Buy "+data[0][0].TotalBuyLooses, "Sell "+data[0][0].TotalSellLooses];
        var yValues = [data[0][0].TotalBuyLooses, data[0][0].TotalSellLooses];
        var barColors = [
          "#0046bf",
          "#fe0000",
          "#2b5797",
          "#e8c3b9",
          "#1e7145"
        ];

        var loss_chart = new Chart("general_losses_chart", {
          type: "doughnut",
          data: {
            labels: xValues,
            datasets: [{
              backgroundColor: barColors,
              data: yValues
            }]
          },
          options: {
            legend: {
              display: true,
              labels: {
                  fontSize: 20
              }
            }
          }
        });

        var xValues = ["Win "+data[0][0].TotalBuyWins, "Losses "+data[0][0].TotalBuyLooses];
        var yValues = [data[0][0].TotalBuyWins, data[0][0].TotalBuyLooses];
        var barColors = [
          "#0046bf",
          "#fe0000",
          "#2b5797",
          "#e8c3b9",
          "#1e7145"
        ];

        var buy_rate_chart = new Chart("general_buy_win_rate_chart", {
          type: "doughnut",
          data: {
            labels: xValues,
            datasets: [{
              backgroundColor: barColors,
              data: yValues
            }]
          },
          options: {
            legend: {
              display: true,
              labels: {
                  fontSize: 20
              }
            }
          }
        });


        var xValues = ["Win "+data[0][0].TotalSellWins, "Losses "+data[0][0].TotalSellLooses];
        var yValues = [data[0][0].TotalSellWins, data[0][0].TotalSellLooses];
        var barColors = [
          "#0046bf",
          "#fe0000",
          "#2b5797",
          "#e8c3b9",
          "#1e7145"
        ];

        var sell_rate_chart = new Chart("general_sell_win_rate_chart", {
          type: "doughnut",
          data: {
            labels: xValues,
            datasets: [{
              backgroundColor: barColors,
              data: yValues
            }]
          },
          options: {
            legend: {
              display: true,
              labels: {
                  fontSize: 20
              }
            }
          }
        });
        function drawChart() {
          // Win Rate 
          var c_WinRate = (data[0][0].TotalTrades>0) ? Math.round(data[0][0].TotalWins / data.TotalTrades * 100) : 0;
          var WinRatePie = _pie({
            element : 'totalWinRate',
            title : 'Win Rate',
            value : c_WinRate + '% <small>from</small> ' + data.TotalTrades,
            left : {
                title : 'Wins',
                value : data.TotalWins,
              }, 
            right : {
                title : 'Losses',
                value : data.TotalLooses,
              }
            });

          // Buy-Sell Ratio
          var c_BySellRatioPie = (data[0][0].TotalSellTrades>0) ? (data[0][0].TotalBuyTrades / data[0][0].TotalSellTrades).toFixed(2) : 0;
          var BySellRatioPie = _pie({
            element : 'totalBuySellRatio',
            title : 'Buy-Sell Ratio',
            value : c_BySellRatioPie,
            left : {
                title : 'Buy',
                value : data[0][0].TotalBuyTrades,
              }, 
            right : {
                title : 'Sell',
                value : data[0][0].TotalSellTrades,
              }
            });
            
          // Wins
          var WinsPie = _pie({
            element : 'totalWins',
            title : 'Wins',
            value : data.TotalWins,
            left : {
                title : 'Buy',
                value : data.TotalBuyWins,
              }, 
            right : {
                title : 'Sell',
                value : data.TotalSellWins,
              }
            });
            
          // Losses
          var LosesPie = _pie({
            element : 'totalLoses',
            title : 'Losses',
            value : data.TotalLooses,
            left : {
                title : 'Buy',
                value : data.TotalBuyLooses,
              }, 
            right : {
                title : 'Sell',
                value : data.TotalSellLooses,
              }
            });
  
          // Buy Win-Rate
          var c_LosesPie = (data.TotalBuyTrades>0) ? Math.round(data.TotalBuyWins / data.TotalBuyTrades * 100) : 0;
          var LosesPie = _pie({
            element : 'totalBuyWinRate',
            title : 'Buy Win-Rate',
            value :  c_LosesPie + '%',
            left : {
                title : 'Wins',
                value : data.TotalBuyWins,
              }, 
            right : {
                title : 'Losses',
                value : data.TotalBuyLooses,
              }
            });

          // Sell Win-Rate
          var c_SellWinRate = (data.TotalSellTrades>0) ? Math.round(data.TotalSellWins / data.TotalSellTrades * 100) : 0;
          var SellWinRate = _pie({
            element : 'totalSellWinRate',
            title : 'Sell Win-Rate',
            value :  c_SellWinRate + '%',
            left : {
                title : 'Wins',
                value : data.TotalSellWins,
              }, 
            right : {
                title : 'Losses',
                value : data.TotalSellLooses,
              }
            });            
        }
      } else {
        // notifyme.showNotification(response["status"], response["message"]);
      }
    },
  });
}

//Get Performance Growth
function getPerformanceGrowth() {
  $.ajax({
    url: "getPerformanceGrowth",
    method: "POST",
    data: {
      account_id: _account_id,
    },
    success: function (response) {
      response = JSON.parse(response);
      if (response["status"] == "success") {
        var data = [];
        data = response["data"][0];
        var xValues = [];
        var yValues = [];

        var xCValues = [];
        var yCValues = [];

        var barColors = [
          "#0046bf",
          "#fe0000",
          "#2b5797",
          "#e8c3b9",
          "#1e7145"
        ];

        console.log(data);
        if(data != undefined) {

          data.map((d) => {
            if(d.months == undefined ) {
              d.months = "";
            }
            xValues.push(d.months);
            yValues.push(Number(d.profit).toFixed(2));
          });
      
          data.map((d) => { 
            if(d.months == undefined ) {
              d.months = "";
            }
            xCValues.push(d.months);
            yCValues.push(Number(d.cash).toFixed(2));
          });
        }
        else {
          var xValues = [];
          var yValues = [];

          var xCValues = [];
          var yCValues = [];
        }

        var label = "%";
        var general_percentage_chart = new Chart("general_percentage_chart", {
          type: "bar",
          
          data: {
            labels: xValues,
            datasets: [{
              backgroundColor: barColors,
              data: yValues,
              // borderSkipped: false
            }]
          },
          options: {
            tooltips: {
              enabled: true
            },
            hover: {
              animationDuration: 1
            },
            animation: {
              duration: 1,
              onComplete: function () {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;
                ctx.textAlign = 'center';
                ctx.fillStyle = "rgba(0, 0, 0, 1)";
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function (dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function (bar, index) {
                    var data = dataset.data[index];
                    ctx.fillText(data+"%", bar._model.x, bar._model.y - 5);

                  });
                });
              }
            }

          }
        });
      var label1 = "Cash"
      var general_amount_chart = new Chart("general_amount_chart", {
        type: "bar",
        data: {
          labels: xCValues,
          datasets: [{
            backgroundColor: barColors,
            data: yCValues,
            borderSkipped: false
          }]
        },
        marker: {
          visible: true,
          shape:'Diamond',
        },
        options: {
            tooltips: {
              enabled: true
            },
            hover: {
              animationDuration: 1
            },
            animation: {
              duration: 1,
              onComplete: function () {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;
                ctx.textAlign = 'center';
                ctx.fillStyle = "rgba(0, 0, 0, 1)";
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function (dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function (bar, index) {
                    var data = dataset.data[index];
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);

                  });
                });
              }
            }

          }
      });       
        
      } else {
        notifyme.showNotification(response["status"], response["message"]);
      }
    },
  });
}

function getAccountSummary() {
  $.ajax({
    url: "getAccountSummary",
    method: "POST",
    data: {
      action: "getAccountSummary",
      account_id: _account_id,
    },
    success: function (response) {
      response = JSON.parse(response);
      if (response["status"] == "success") {
        var data = [];
        var diff = "";
        data = response["data"];
        const plPerc = ( (data[0][0].currentbalance - data[0][0].deposit) /data[0][0].deposit)*100;

        $("#timeOfUpload").text(moment(new Date(data[0][0].datetimeeaattached), "MMMM Do YYYY, h:mm:ss a"));
        $("#timeOfLastTrade").text(moment(new Date(data[0][0].datetimelastclosetrade), "MMMM Do YYYY, h:mm:ss a"));

        $("#spanAccountName").text(data[0][0].acctname);
        $("#spanAccountId").text(data[0][0].accountid);

        var att = ((diff = (data[0][0].basegmt - data[0][0].gmt)) !=0) ? ("&nbsp;&nbsp;&nbsp;<small class='colorGreen'>Shown as: GMT " + ((data[0][0].gmt>=0) ? '+'+ data[0][0].gmt : data[0][0].gmt) + '</small>') : '';
        $("#spanBaseGMT").html('GMT ' + ((data[0][0].basegmt>=0) ? '+' : '') + data[0][0].basegmt + att);
        $("#spanCurrentPL").text(Number(data[0][0].currentprofitloss).toFixed(2));
        $("#spanCurrentPLPerc").text(Number(plPerc).toFixed(2) + ' %');
        $("#spanDeposit").text(Number(data[0][0].deposit).toFixed(2));
        $("#spanWithdrawal").text(Number(data[0][0].withdrawal).toFixed(2));

        $("#spanCurrentBalance").text(Number(data[0][0].currentbalance).toFixed(2));
        $("#spanCurrentEquity").text(Number(data[0][0].currentequity).toFixed(2));
        $("#spanCurrency").text(data[0][0].accountcurrency);
        $("#spanDemoLive").text(data[0][0].DemoLive);
        $("#spanMetaTrader").text(data[0][0].MT4MT5);
        $("#spanBroker").text(data[0][0].broker);
        $("#spanCurrentLeverage").text(data[0][0].currentleverage);
        $("#spanCurrentFreeMargin").text(data[0][0].currentfreemargin);

        $("#spanConsecutiveWin").text(data[0][0].consecutivewin);
        $("#spanConsecutiveLoss").text(data[0][0].consecutiveloss);
        $("#spanOrderCancelled").text(data[0][0].consecutiveloss);
        $("#spanLargestProfitTrade").text(Number(data[0][0].largestprofittrade).toFixed(2));

        $("#alptTicket").text(data[0][0].OrderNumber);
        $("#alptSymbol").text(data[0][0].Symbol);
        $("#alptLots").text(data[0][0].OrderSize);

        $("#alptTicketLt").text(data[0][0].lOrderNumber);
        $("#alptSymbolLt").text(data[0][0].lSymbol);
        $("#alptLotsLt").text(data[0][0].lOrderSize);

        $("#spanLargestLossTrade").text(Number(data[0][0].largestlosstrade).toFixed(2));
        $("#spanTotalLotStraded").text(Number(data[0][0].totallotstraded).toFixed(2));
        $("#spanAverageLotStraded").text(Number(data[0][0].averagelotstraded).toFixed(2));
        $("#spanTotalCommissionAmount").text(Number(data[0][0].totalcommissionamount).toFixed(2));
        $("#spanTotalSwapAmount").text(Number(data[0][0].totalswapamount).toFixed(2));
        if(avaTradeTime == undefined) {
          var avaTradeTime = "00:00:00"; }
        else{
          var avaTradeTime = (data[0][0].AvgTradeTime).slice(0, 8);
        }
        $("#general_insight_list tbody").append(
          `<tr>
            <td class="sect_td2">${avaTradeTime}</td>
            <td class="sect_td2">${Number(data[0][0].consecutivewin)}</td>
            <td class="sect_td2">${Number(data[0][0].consecutiveloss)}</td>
            <td class="sect_td2">${Number(data[0][0].averagelotstraded).toFixed(2)}</td>
            <td class="sect_td2"><div class="col-md-12 dChartCpT tooltipM"><span id="spanLargestProfitTrade" >${Number(data[0][0].largestprofittrade).toFixed(2)}</span><div id="spanLargestProfitTradeTooltip"><ul><li><b>Ticket</b> : <span id="alptTicket">${data[0][0].OrderNumber}</span></li><li><b>Symbol</b> : <span id="alptTicket">${data[0][0].Symbol}</span></li></ul></div></div></td>
            <td class="sect_td2"><div class="col-md-12 dChartCpT tooltipM"><span id="spanLargestProfitTrade" >${Number(data[0][0].largestlosstrade).toFixed(2)}</span><div id="spanLargestProfitTradeTooltip"><ul><li><b>Ticket</b> : <span id="alptTicket">${data[0][0].lOrderNumber}</span></li><li><b>Symbol</b> : <span id="alptTicket">${data[0][0].lSymbol}</span></li></ul></div></div></td>
           </tr>`
        );

        $("#rTime").text(moment(data[0][0].AvgTradeTime, "HH:mm:ss").format("HH:mm:ss"));
      } else {
        notifyme.showNotification(response["status"], response["message"]);
      }
    },
  });
}

$('#accounts').change(function(){
  $('#reload').trigger("click");
});

$('#reload').click(
  function reload() {
    window.location = BASE_URL + 'dashboard/general?ac=' + $('#accounts').val();
  }
);

$(document).ready(function(){
  get_symbol_chart();
  get_Total_TradeSummary();
  getPerformanceGrowth();
  getAccountSummary();
});