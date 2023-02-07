<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header" style="display: flex; justify-content: space-between;">
        <h2><i class="ion-ios-paper">&nbsp;Journal</i></h2>
        <div id='JournalSummaryGridGrpBtn' class='groupJournalBtn hide'>
            <a id='JournalSummaryGridGrpJournalBtn' class="modalOpenJournal btn btn-success" href="javascript:void(0)" onclick="getGroupJournalModal();"><i class="ion-ios-paper-outline"></i>&nbsp;Group Journal</a>
            <a class="badge badge-danger" href="javascript:void(0)" rel="JournalSummaryGrid" onclick="clearfilterJournalSummary(this);"><i class="ion-reply-all"></i>&nbsp;Clear</a>
            <input id="JournalSummaryGridGrpValue_view" type="text" class='form-control colorGreen' value='' style="margin-top:10px;">
        </div>
        <h6 style="color: lightgreen;">Shown as GMT<?php echo $_SESSION['GMT']?></h6>
        
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="JournalSummaryGrid">
            <thead>                   
              <th class="sect1_td">Tickets</th>
              <th class="sect1_td">Open Date</th>
              <th class="sect1_td">Close Date</th>
              <th class="sect1_td">Symbol</th>
              <th class="sect1_td">Type</th>
              <th class="sect1_td">Lots</th>
              <th class="sect1_td">Outcome</th>
              <th class="sect1_td">Journal</th>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <hr />
      <div class="card-footer">
        <div class="col-sm-12 pl-0 display-flex">
          <div class="col-sm-3 pl-0">
            <div class="form-group">
              <label>Start date</label>
              <input type="text" class="form-control datepicker" id="journal_start_date">
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label>End date</label>
              <input type="text" class="form-control datepicker" id="journal_end_date">
            </div>
          </div>
          <div class="col-sm-3 item-align-center">
            <button class="btn btn-info" onclick="getAccountSummaryJournalFilter()">Search</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
​
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header" style="display: flex; justify-content: space-between;">
        <h2><i class="ion-calculator">&nbsp;Account History</i></h2>
        <h6 style="color: lightgreen;">Shown as GMT<?php echo $_SESSION['GMT']?></h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="account_summary_history">
            <thead>                                 
              <th class="sect1_td">Open D/T</th>
              <th class="sect1_td">Close D/T</th>
              <th class="sect1_td">Ticket</th>
              <th class="sect1_td">Symbol</th>
              <th class="sect1_td">Type</th>
              <th class="sect1_td">Entry</th>
              <th class="sect1_td">SL Price</th>
              <th class="sect1_td">TP Price</th>
              <th class="sect1_td">Commission</th>
              <th class="sect1_td">Swap</th>
              <th class="sect1_td">Exit Price</th>
              <th class="sect1_td">Profit</th>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url('assets/js/page/account_summary.js')?>"></script>