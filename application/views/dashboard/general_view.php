<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-16">
    <div class="card" style="text-align: center;">
      <div class="card-header" style="justify-content: space-between;">
        <p><h4>Time of Upload</h4>(server time)<h3 id="timeOfUpload"></h3><h4>Time of Last Trade</h4>(server time)<h3 id="timeOfLastTrade"></h3></p>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-4 col-md-4 col-sm-16">
    <div class="card" style="text-align: center;">
      <div class="card-header">
        <div class="card-stats">
          <div class="card-stats-items" style="display: flex; justify-content: space-between;">
            <div class="card-stats-item">
              <div class="card-stats-item-count">Balance</div>
              <div class="card-stats-item-label" ><b id="spanCurrentBalance"></b></div>
            </div>
            <div class="card-stats-item">
              <div class="card-stats-item-count">Equity</div>
              <div class="card-stats-item-label"><b id="spanCurrentEquity"></b></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-4 col-sm-16">
    <div class="card">
      <div class="card-header">
        <div class="card-stats">
          <div class="card-stats-items" style="display: flex; justify-content: space-between;">
            <div class="card-stats-item">
              <div class="card-stats-item-count">Deposit</div>
              <div class="card-stats-item-label"><b id="spanDeposit"></b></div>
            </div>
            <div class="card-stats-item">
              <div class="card-stats-item-count">Withdrawal</div>
              <div class="card-stats-item-label"><b id="spanWithdrawal"></b></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-4 col-sm-16">
    <div class="card">
      <div class="card-header">
        <div class="card-stats">
          <div class="card-stats-items" style="display: flex; justify-content: space-between;">
            <div class="card-stats-item">
              <div class="card-stats-item-count">Profit/Loss</div>
              <div class="card-stats-item-label"><b id="spanCurrentPL"></b></div>
            </div>
            <div class="card-stats-item">
              <div class="card-stats-item-count" style="display: flex; width: 100%">PLPercentage</div>
              <div class="card-stats-item-label"><b id="spanCurrentPLPerc"></b></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row-chart">
  <div class="col-12 col-md-6 col-lg-8">
    <div class="card card-chart">
      <div class="card-header" style="display: flex; flex-direction: column; align-items: flex-start;">
        <h3><i class="ion-social-chrome"></i>&nbsp;Symbols</h3>
        <ul class="nav nav-pills" id="myTab3" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="strength1" data-toggle="tab" href="#strength" role="tab" aria-controls="strength" aria-selected="true">Strength</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="profit1" data-toggle="tab" href="#profit" role="tab" aria-controls="profit" aria-selected="false">Profit / Loss</a>
        </ul>
      </div>
      <div class="tab-content" id="myTabContent2">
        <div class="tab-pane fade show active" id="strength" role="tabpanel" aria-labelledby="strength1">
          <div class="card-body" >
            <canvas id="strength_chart"></canvas>
          </div>
        </div>
        <div class="tab-pane fade" id="profit" role="tabpanel" aria-labelledby="profit1">
          <div class="card-body" >
            <canvas id="profit_chart"></canvas>
          </div>
        </div>
      </div>
      <hr />
      <div class="card-footer">
        <button class="btn btn-primary btn-lg" rel='1' style="margin-left: 4px;" onclick='getSymbolsChart_filter(1);'>
          All
        </button>
        <button class="btn btn-primary btn-lg" rel='2' style="margin-left: 4px;" onclick='getSymbolsChart_filter(2);'>
          Today
        </button>
        <button class="btn btn-primary btn-lg" rel='3' style="margin-left: 4px;" onclick='getSymbolsChart_filter(3);'>
          This Week
        </button>
        <button class="btn btn-primary btn-lg" rel='4' style="margin-left: 4px;" onclick='getSymbolsChart_filter(4);'>
          This Month
        </button>
        <input type="text" onchange="getSymbolsChart_filter(5)" class="btn btn-primary btn-lg form-control daterange" rel='5' style="margin-left: 4px; width: 16rem;" id="period">
        <!-- <button class="btn btn-primary btn-lg" rel='0' style="margin-left: 4px;">
          Pairs
        </button> -->
      </div>
    </div>
  </div>
  <div class="col-12 col-md-1 col-lg-4" style="width:100%" >
    <div class="card card-chart">
      <div class="card-header">
        <h4 class="win_rate_chart"></h4>
      </div>
      <div class="card-body">
        <canvas id="general_win_rate_pie_chart"></canvas>
        <div>
          <div class="win-rate-chart">
            <p>Account Name</p>
            <p><b id="spanAccountName"></b></p>
          </div>
          <div class="win-rate-chart">
            <p>Account ID</p>
            <b id="spanAccountId"></b>
          </div>
          <div class="win-rate-chart">
            <p>MT4/MT5</p>
            <b id="spanMetaTrader"></b>
          </div>
          <div class="win-rate-chart">
            <p>Broker</p>
            <b id="spanBroker"></b>
          </div>
          <div class="win-rate-chart">
            <p>Leverage</p>
            <b id="spanCurrentLeverage"></b>
          </div>
          <div class="win-rate-chart">
            <p>Base GMT</p>
            <b id="spanBaseGMT"></b>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12 col-md-12 col-lg-12">
    <div class="card">

      <div class="card-header" style="display: flex; flex-direction: column; align-items: flex-start">
        <h3><i class="ion-social-chrome"></i>&nbsp;Insights</h3>
      </div>
      <div class="card-body">
        <div class="table-responsive" style="overflow: inherit;">
          <table class="table table-bordered table-striped verticle-middle table-responsive-sm" id="general_insight_list">
            <thead>                                 
              <th class="sect_td">Average Hold Time</th>
              <th class="sect_td">Consecutive Wins</th>
              <th class="sect_td">Consecutive Loss</th>
              <th class="sect_td">Average Lost Traded</th>
              <th class="sect_td">Largest Profit</th>
              <th class="sect_td">Largest Loss</th>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-12 col-md-10 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h3><i class="ion-social-chrome"></i>&nbsp;Doughnut Chart</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-md-6 col-lg-4" style="text-align: center;"><h3 class="buy_sell_chart" id="spanTotalSellTrades"></h3>
            <canvas id="general_buy_sell_chart"></canvas>
          </div>
          <div class="col-12 col-md-6 col-lg-4" style="text-align: center; justify-content: space-between;"><div style="display: inline-flex;"><h3>Win</h3>&nbsp;<h3 id="spanTotalWins"></h3></div>
            <canvas id="general_wins_chart"></canvas>
          </div>
          <div class="col-12 col-md-6 col-lg-4" style="text-align: center ;"><div style="display: inline-flex;"><h3>Losses</h3>&nbsp;<h3 id="spanTotalLooses"></h3></div>
            <canvas id="general_losses_chart"></canvas>
          </div>

	      <div class="col-12 col-md-6 col-lg-2" style="text-align: center;">
	      </div>
	      <div class="col-12 col-md-6 col-lg-4" style="text-align: center;"><h3 class="buy_win_rate_chart"></h3>
	        <canvas id="general_buy_win_rate_chart"></canvas>
	      </div>
	      <div class="col-12 col-md-6 col-lg-4" style="text-align: center;"><h3 class="sell_win_rate_chart"></h3>
	        <canvas id="general_sell_win_rate_chart"></canvas>
	      </div>
	      <div class="col-12 col-md-6 col-lg-2">
	      </div>
      	</div>
      <hr />
      <div class="card-footer">
        <button class="btn btn-primary btn-lg" rel='1' style="margin-left: 4px;" onclick='getTotalTradeSummary_filter(1);'>
          All
        </button>
        <button class="btn btn-primary btn-lg" rel='2' style="margin-left: 4px;" onclick='getTotalTradeSummary_filter(2);'>
          Today
        </button>
        <button class="btn btn-primary btn-lg" rel='3' style="margin-left: 4px;" onclick='getTotalTradeSummary_filter(3);'>
          This Week
        </button>
        <button class="btn btn-primary btn-lg" rel='4' style="margin-left: 4px;" onclick='getTotalTradeSummary_filter(4);'>
          This Month
        </button>
        <input type="text" onchange="getTotalTradeSummary_filter(5)" class="btn btn-primary btn-lg form-control daterange" rel='5' style="margin-left: 4px; width: 16rem;" id="period1">
        <!-- <button class="btn btn-primary btn-lg" rel='0' style="margin-left: 4px;">
          Pairs
        </button> -->
      </div>
    </div>
  </div>
  <div class="row">
  <div class="col-12 col-md-12 col-lg-125">
    <div class="card">

      <div class="card-header" style="display: flex; flex-direction: column; align-items: flex-start">
        <h3><i class="ion-social-chrome"></i>&nbsp;Performance Growth</h3>
        <ul class="nav nav-pills" id="myTab3" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="percentage1" data-toggle="tab" href="#percentage" role="tab" aria-controls="percentage" aria-selected="true">Percentage</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="amount1" data-toggle="tab" href="#amount" role="tab" aria-controls="amount" aria-selected="false">Amount In cash</a>
        </ul>
      </div>
      <div class="tab-content" id="myTabContent1">
        <div class="tab-pane fade" id="percentage" role="tabpanel">
          <div class="card-body" >
            <canvas id="general_percentage_chart"></canvas>
          </div>
        </div>
        <div class="tab-pane fade show active" id="amount" role="tabpanel">
          <div class="card-body" >
            <canvas id="general_amount_chart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</div>



<script src="<?php echo base_url('assets/js/page/general_dashboard.js')?>"></script>