<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?php echo $params['title']?></title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?php echo base_url('assets/modules/bootstrap/css/bootstrap.min.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/modules/fontawesome/css/all.min.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/modules/bootstrap-daterangepicker/daterangepicker.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/modules/datatables/datatables.min.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/modules/ionicons/css/ionicons.min.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/modules/fullcalendar/fullcalendar.min.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/photoswipe.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/photoswipe.default-skin.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/components.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css')?>">
  
  <script src="<?php echo base_url('assets/modules/jquery.min.js')?>"></script>
  <script src="<?php echo base_url('assets/modules/jquery-ui/jquery-ui.min.js')?>"></script>
  <script src="<?php echo base_url('assets/modules/popper.js')?>"></script>
  <script src="<?php echo base_url('assets/modules/tooltip.js')?>"></script>
  <script src="<?php echo base_url('assets/modules/bootstrap/js/bootstrap.min.js')?>"></script>
  <script src="<?php echo base_url('assets/modules/moment.min.js')?>"></script>
  <script src="<?php echo base_url('assets/modules/chart.min.js')?>"></script>
  <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe.min.js'></script>
  <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe-ui-default.min.js'></script>
  <script src="<?php echo base_url('assets/modules/datatables/datatables.min.js')?>"></script>
  <script src="<?php echo base_url('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')?>"></script>
  <script src="<?php echo base_url('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')?>"></script>
  <script src="<?php echo base_url('assets/modules/bootstrap-daterangepicker/daterangepicker.js')?>"></script>

  <script src="<?php echo base_url('assets/modules/fullcalendar/fullcalendar.min.js')?>"></script>
  <script src="<?php echo base_url('assets/modules/nicescroll/jquery.nicescroll.min.js')?>"></script>
  <!-- Page Specific JS File -->
  <script src="<?php echo base_url('assets/js/stisla.js')?>"></script>
  <script src="<?php echo base_url('assets/js/scripts.js')?>"></script>
  <script>
    var _profileGMT = "<?php echo $_SESSION['GMT']?>";
    var BASE_URL = "<?php echo base_url()?>";
    var _account_id = "<?php echo $_SESSION['account_id']?>";
    var _plan_id = "<?php echo $_SESSION['plan_id']?>";
    var _baseGMT = "<?php echo $_SESSION['GMT']?>";
    var _account_active = <?php echo $_SESSION['account_active']?>;
    var ajaxSubmit = function(e) {
      e.preventDefault();
      var formData = new FormData(this);
      var callback = $(this).attr('callback');
      var url = $(this).attr('action');
      $.ajax({
        url: BASE_URL + url,
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
          response = JSON.parse(response);
          if (response["status"] == "success") {
            if (callback!=undefined) {
              setTimeout(function () {
                eval(callback);
              }, 1000);
            }
          } else {
          }
        },
      });
    }
  </script>
</head>
<body>
  <div id="modalPaymentMethod" class="modal fade"  tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Select Payment Options</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="extraM_detail">
                <div class="table-responsive table-sales">
                <div class="already-plan-message">
                </div>
                    <table class="table">
                        <!-- <thead>
                    <tr>
                        <th class="text-white font-weight-bold text-center" scope="col">Stripe</th>
                <th class="text-white font-weight-bold text-center" scope="col">Payment Options</th>
                </tr>
                </thead> -->
                        <tbody>
                            <tr>
                                <td class="text-white text-center" scope="row">
                                    <div id="paypal-button-container" style="background:white;padding:10px;"></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
  <div class="modal fade" tabindex="-1" role="dialog" id="exampleModalCenter">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="modalUsernameForm" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id=""></h5>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="row" style="padding:30px">
                      <div class="col-12" style="display:flex">
                        <div class="col-2">
                          <img
                          alt="image"
                          width="100px"
                          height="auto"
                          src="<?php echo $_SESSION['avatar']?>"
                          class="rounded-circle author-box-picture"
                          />
                        <div class='ava-icon' onclick="$('#upload-ava').click();"><i class="material-icons">photo</i></div>
                        </div>
                        <div class="col-5" style="display:inline; margin:auto 10px auto 10px">

                        </div>
                        <div class="col-6">
                          <p style="font-size:16px; font-weight:bold; display: block; margin: 5px"><?=$_SESSION['email']?></p>
                          <p style="font-size:14px; display: block; margin: 5px"><?=$_SESSION['username']?></p>
                          <p style="font-size:14px; display: block; margin: 5px"><?=$_SESSION['email']?></p>
                        </div>
                      </div>
                    </div>
                    <div class="row" style="padding:20px">
                      <p>Choose Username</p>
                          <input type="text" class="form-control input-default " placeholder="Username" value="<?=$_SESSION['username']?>" name="username" id="username"> </div>
                      <div style="padding:20px">
                        <p>Date of Birth</p>
                        <div class="row">
                            <div class="col-sm-5">
                                <select class="default-select  form-control wide">
                                    <option>Day</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                    <option>11</option>
                                    <option>12</option>
                                    <option>13</option>
                                    <option>14</option>
                                    <option>15</option>
                                    <option>16</option>
                                    <option>17</option>
                                    <option>18</option>
                                    <option>19</option>
                                    <option>20</option>
                                    <option>21</option>
                                    <option>22</option>
                                    <option>23</option>
                                    <option>24</option>
                                    <option>25</option>
                                    <option>26</option>
                                    <option>27</option>
                                    <option>28</option>
                                    <option>29</option>
                                    <option>30</option>
                                    <option>31</option>
                                </select>
                            </div>
                            <div class="col mt-4 mt-sm-0">
                              <select class="default-select  form-control wide">
                                  <option>Month</option>
                                  <option>January</option>
                                  <option>February</option>
                                  <option>March</option>
                                  <option>April</option>
                                  <option>May</option>
                                  <option>June</option>
                                  <option>July</option>
                                  <option>August</option>
                                  <option>September</option>
                                  <option>October</option>
                                  <option>November</option>
                                  <option>December</option>
                              </select>
                            </div>
                            <div class="col mt-3 mt-sm-0">
                                <select class="default-select  form-control wide">
                                    <option>Year</option>
                                    <option value="2018">2022</option>
                                    <option value="2018">2021</option>
                                    <option value="2018">2020</option>
                                    <option value="2018">2019</option>
                                    <option value="2018">2018</option>
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                    <option value="2014">2014</option>
                                    <option value="2013">2013</option>
                                    <option value="2012">2012</option>
                                    <option value="2011">2011</option>
                                    <option value="2010">2010</option>
                                    <option value="2009">2009</option>
                                    <option value="2008">2008</option>
                                    <option value="2007">2007</option>
                                    <option value="2006">2006</option>
                                    <option value="2005">2005</option>
                                    <option value="2004">2004</option>
                                    <option value="2003">2003</option>
                                    <option value="2002">2002</option>
                                    <option value="2001">2001</option>
                                    <option value="2000">2000</option>
                                    <option value="1999">1999</option>
                                    <option value="1998">1998</option>
                                    <option value="1997">1997</option>
                                    <option value="1996">1996</option>
                                    <option value="1995">1995</option>
                                    <option value="1994">1994</option>
                                    <option value="1993">1993</option>
                                    <option value="1992">1992</option>
                                    <option value="1991">1991</option>
                                    <option value="1990">1990</option>
                                    <option value="1989">1989</option>
                                    <option value="1988">1988</option>
                                    <option value="1987">1987</option>
                                    <option value="1986">1986</option>
                                    <option value="1985">1985</option>
                                    <option value="1984">1984</option>
                                    <option value="1983">1983</option>
                                    <option value="1982">1982</option>
                                </select>
                            </div>
                        </div>
                      </div>


                </div>  
              </div>
            </div>
      
        </div>
        <div class="modal-footer">   
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>  
    </div>   
  </div>
</div> 
  <div class="modal fade" tabindex="-1" role="dialog" id="cal_modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="journal_edit_modal_title">Profit/Loss Calendar</h5>
        </div>
          <div class="month-cal-total-bal" id="total-profit" style="text-align: center; font-size: large; font-weight: 800; color: blue;"></div>
        <div class="modal-body">
          <div id="calendar_c" class="app-fullcalendar"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="cal_event_modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="journal_edit_modal_title">Profit/Loss Calendar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table id="tableCalTransactionData" class="table table-striped">
            <thead>
              <td class="sect-td">Ticket</td>
              <td class="sect-td">Symbol</td>
              <td class="sect-td">Type</td>
              <td class="sect-td">Lots</td>
              <td class="sect-td">Outcome</td>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="trade_journal_modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="journal_edit_modal_title">Trade Journal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" id="journalDetailsModalInsertUpdate">
              <input type="hidden" id="jHas" name="jHas" class="form-control" value="" />
              <input type="hidden" id="jTicket" name="jTicket" class="form-control" value="" />
              <input type="hidden" id="jEmail" name="jEmail" class="form-control" value="<?php echo $_SESSION['email'] ?>" />
              <input type="hidden" id="JournalSummaryGridGrpValue" name="JournalSummaryGridGrpValue" class="form-control" />
              <table class="table table-striped">
                <thead>
                  <td class="sect_td">Ticket</td>
                  <td class="sect_td">Symbol</td>
                  <td class="sect_td">Type</td>
                  <td class="sect_td">Lots</td>
                  <td class="sect_td">Outcome</td>
                </thead>
                <tbody id="jornalModalRows">
                </tbody>
              </table>
              <div class="textbox-wrapper row outcomes-section" style="">
                  <div class="col-md-6">
                    <h4>Duration</h4>
                    <ul class="list-group">
                        <li class="tradeoutcome-journal list-group-item d-flex justify-content-between align-items-center">Trade Outcome<span></span></li>
                        <li class="drawdown-journal list-group-item d-flex justify-content-between align-items-center">Draw Down <span></span></li>
                        <li class="floatingpoint-journal list-group-item d-flex justify-content-between align-items-center">Floating Point <span></span></li>
                    </ul>
                  </div>
                  <div class="col-md-6">
                    <h4>Duration</h4>
                    <ul class="list-group">
                        <li class="tradeoutcome-journal-time list-group-item d-flex justify-content-between align-items-center"></li>
                        <li class="drawdown-journal-time list-group-item d-flex justify-content-between align-items-center"></li>
                        <li class="floatingpoint-journal-time list-group-item d-flex justify-content-between align-items-center"></li>
                    </ul>
                  </div>
              </div>
              <div class="row fancygall">
                <div class="col-md-3">
                    <?php  $timeframeId = "TimeFrame1";
                        $timeframeTicket = "TimeFrame1";
                        include 'assets/templates/journal-main-modal/select-timeframe.php'; ?>
                </div>
                <div class="col-md-3">
                    <?php  $timeframeId = "TimeFrame2";
                        include 'assets/templates/journal-main-modal/select-timeframe.php'; ?>
                </div>
                <div class="col-md-3">
                    <?php  $timeframeId = "TimeFrame3";
                        include 'assets/templates/journal-main-modal/select-timeframe.php'; ?>
                </div>
                <div class="col-md-3">
                  <?php  $timeframeId = "TimeFrame4";
                    $tmclass="timeframe-wrap-hide";
                    include 'assets/templates/journal-main-modal/select-timeframe.php'; ?>
                </div>
                <div class="col-md-3">
                  <?php  $timeframeId = "TimeFrame5";
                    include 'assets/templates/journal-main-modal/select-timeframe.php'; ?>
                </div>
              </div>

              <div class="textbox-wrapper row">
                <div class="col-md-8">
                    <ul class="navbar-nav navbar-right">
                        <li>
                          <?php include 'assets/templates/journal-main-modal/used-textbox.php'; ?>
                        </li>
                        
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="navbar-nav navbar-right">
                        <li>
                        <?php include 'assets/templates/journal-main-modal/used.php'; ?>
                        </li>
                        
                    </ul>
                </div>
                
            </div>

            <div class="textbox-wrapper row">
                <div class="col-md-8">
                    <ul class="navbar-nav navbar-right">
                        <li>
                        <?php include 'assets/templates/journal-main-modal/entry-textbox.php'; ?>
                        </li>
                        
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="navbar-nav navbar-right">
                        
                        <li>
                        <?php include 'assets/templates/journal-main-modal/entry.php'; ?>
                        </li>
                        
                    </ul>
                </div>
                
            </div>

            <div class="textbox-wrapper row">
                <div class="col-md-8">
                    <ul class="navbar-nav navbar-right">
                        <li>
                        <?php include 'assets/templates/journal-main-modal/outcome-textbox.php'; ?>
                        </li>
                        
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="navbar-nav navbar-right">
                        
                        <li>
                        <?php include 'assets/templates/journal-main-modal/outcome.php'; ?>
                        </li>
                    </ul>
                </div>
                
            </div>

            <div class="textbox-wrapper row">
                
                <div class="col-md-12">
                    <ul class="navbar-nav navbar-right">
                        <li>
                        <?php include 'assets/templates/journal-main-modal/improve.php'; ?>
                        </li>
                    </ul>
                </div>
            </div>

            <br>

            <div class="modal-footer">
                <button type="button" class="btn btn-purple mr-3" data-dismiss="modal">Close</button>
                <input type="submit" value="Save" class="btn btn-primary" name="submits">
            </div>
            <?php include 'assets/templates/journal-main-modal/timeframe-forms-all.php'; ?>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="trade_journal_grouped_modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="journal_edit_modal_title">Trade Journal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table id="tableCalTransactionData" class="table table-striped">
            <thead>
              <td>Ticket</td>
              <td>Symbol</td>
              <td>Type</td>
              <td>Lots</td>
              <td>Outcome</td>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="best_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width:650px;">
      <div class="modal-header">
        <h5 class="modal-title" id="best_trade_modal_title">Best Hour Trade</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <!-- <span aria-hidden="true">&times;</span> -->
        </button>
      </div>
      <div class="modal-body">
        
        <div class="card-body">
          <div style="height: 400px; overflow-y:scroll;">
            <table id="tableNumberTradeOpen" class="table table-striped">
              <thead>
                <tr>
                  <th class="sect_td" scope="col">Ticket</th>
                  <th class="sect_td" scope="col">Symbol</th>
                  <th class="sect_td" scope="col">Type</th>
                  <th class="sect_td" scope="col">Lots</th>
                  <th class="sect_td" scope="col">Outcome</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modalTimezoneSession">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width:650px;">
      <div class="modal-header">
        <h5 class="modal-title" id="best_trade_modal_title">Best Hour Trade</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <!-- <span aria-hidden="true">&times;</span> -->
        </button>
      </div>
      <div class="modal-body">
        
        <div class="card-body">
          <div style="height: 400px; overflow-y:scroll;">
            <table id="tableNumberTradeOpen" class="table table-striped">
              <thead>
                <tr>
                  <th class="sect_td" scope="col">Ticket</th>
                  <th class="sect_td" scope="col">Symbol</th>
                  <th class="sect_td" scope="col">Type</th>
                  <th class="sect_td" scope="col">Lots</th>
                  <th class="sect_td" scope="col">Outcome</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="exampleModalCenter">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="modalUsernameForm" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id=""></h5>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="row" style="padding:30px">
                      <div class="col-12" style="display:flex">
                        <div class="col-1">
                          <img width="100%" style="border-radius:100px; background: #eee" onclick="$('#upload-ava').click();"/>
                        </div>
                        <div class="col-5" style="display:inline; margin:auto 10px auto 10px">
                          User Profile
                        </div>
                        <div class="col-7">
                          <p style="font-size:16px; font-weight:bold; display: block; margin: 5px"><?=$_SESSION['email']?></p>
                          <p style="font-size:14px; display: block; margin: 5px"><?=$_SESSION['username']?></p>
                          <p style="font-size:14px; display: block; margin: 5px"><?=$_SESSION['email']?></p>
                        </div>
                      </div>
                    </div>
                    <div class="row" style="padding:20px">
                      <p>Choose Username</p>
                          <input type="text" class="form-control input-default " placeholder="Username" value="<?=$_SESSION['username']?>" name="username" id="username"> </div>
                      <div style="padding:20px">
                        <p>Date of Birth</p>
                        <div class="row">
                            <div class="col-sm-5">
                                <select class="default-select  form-control wide">
                                    <option>Day</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                    <option>11</option>
                                    <option>12</option>
                                    <option>13</option>
                                    <option>14</option>
                                    <option>15</option>
                                    <option>16</option>
                                    <option>17</option>
                                    <option>18</option>
                                    <option>19</option>
                                    <option>20</option>
                                    <option>21</option>
                                    <option>22</option>
                                    <option>23</option>
                                    <option>24</option>
                                    <option>25</option>
                                    <option>26</option>
                                    <option>27</option>
                                    <option>28</option>
                                    <option>29</option>
                                    <option>30</option>
                                    <option>31</option>
                                </select>
                            </div>
                            <div class="col mt-4 mt-sm-0">
                              <select class="default-select  form-control wide">
                                  <option>Month</option>
                                  <option>January</option>
                                  <option>February</option>
                                  <option>March</option>
                                  <option>April</option>
                                  <option>May</option>
                                  <option>June</option>
                                  <option>July</option>
                                  <option>August</option>
                                  <option>September</option>
                                  <option>October</option>
                                  <option>November</option>
                                  <option>December</option>
                              </select>
                            </div>
                            <div class="col mt-3 mt-sm-0">
                                <select class="default-select  form-control wide">
                                    <option>Year</option>
                                    <option value="2018">2022</option>
                                    <option value="2018">2021</option>
                                    <option value="2018">2020</option>
                                    <option value="2018">2019</option>
                                    <option value="2018">2018</option>
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                    <option value="2014">2014</option>
                                    <option value="2013">2013</option>
                                    <option value="2012">2012</option>
                                    <option value="2011">2011</option>
                                    <option value="2010">2010</option>
                                    <option value="2009">2009</option>
                                    <option value="2008">2008</option>
                                    <option value="2007">2007</option>
                                    <option value="2006">2006</option>
                                    <option value="2005">2005</option>
                                    <option value="2004">2004</option>
                                    <option value="2003">2003</option>
                                    <option value="2002">2002</option>
                                    <option value="2001">2001</option>
                                    <option value="2000">2000</option>
                                    <option value="1999">1999</option>
                                    <option value="1998">1998</option>
                                    <option value="1997">1997</option>
                                    <option value="1996">1996</option>
                                    <option value="1995">1995</option>
                                    <option value="1994">1994</option>
                                    <option value="1993">1993</option>
                                    <option value="1992">1992</option>
                                    <option value="1991">1991</option>
                                    <option value="1990">1990</option>
                                    <option value="1989">1989</option>
                                    <option value="1988">1988</option>
                                    <option value="1987">1987</option>
                                    <option value="1986">1986</option>
                                    <option value="1985">1985</option>
                                    <option value="1984">1984</option>
                                    <option value="1983">1983</option>
                                    <option value="1982">1982</option>
                                </select>
                            </div>
                        </div>
                      </div>


                </div>  
              </div>
            </div>
      
        </div>
        <div class="modal-footer">   
          <button type="button" class="btn btn-purple" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>  
    </div>   
  </div>
</div> 
<!-- Modal Journal -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalOpenJournal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="account_edit_modal_title">Trade Journal</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="openJournal_detail">
                <form method="post" id="accountDetailsModalInsertUpdate">
                    <input type="hidden" id="jHas" name="jHas" class="form-control" value="" />
                    <input type="hidden" id="jTicket" name="jTicket" class="form-control" value="" />
                    <input type="hidden" id="jEmail" name="jEmail" class="form-control" value="<?php echo $_SESSION['email'] ?>" />

                    <table id="sectionTwoT1" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="sect_td">Ticket </th>
                                <th class="sect_td">Symbol </th>
                                <th class="sect_td">Type </th>
                                <th class="sect_td">Lots </th>
                                <th class="sect_td">Outcome </th>
                            </tr>
                        </thead>
                        <tbody id='accountModalRows'>
                        </tbody>
                    </table>

                    <div class="container mt-4 my-4">
                        <div class="textbox-wrapper row">
                            <div class="col-md-6">
                                <ul class="navbar-nav navbar-right">
                                    <li>
                                    <?php include 'assets/templates/journal-modal/used.php'; ?>
                                    </li>
                                    <li>
                                    <?php include 'assets/templates/journal-modal/entry.php'; ?>
                                    </li>
                                    <li>
                                    <?php include 'assets/templates/journal-modal/outcome.php'; ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="navbar-nav navbar-right">
                                    <li>
                                      <?php include 'assets/templates/journal-modal/improve.php'; ?>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <br>
                        <div class="row fancygall">
                            <div class="col-md-3">
                                <?php  $timeframeId = "TimeFrame11";
                                    include 'assets/templates/journal-modal/select-timeframe.php'; ?>
                            </div>
                            <div class="col-md-3">
                                <?php  $timeframeId = "TimeFrame21";
                                    include 'assets/templates/journal-modal/select-timeframe.php'; ?>
                            </div>
                            <div class="col-md-3">
                                <?php  $timeframeId = "TimeFrame31";
                                    include 'assets/templates/journal-modal/select-timeframe.php'; ?>
                            </div>
                            <div class="col-md-3">
                                <?php  $timeframeId = "TimeFrame41";
                                  
                                    include 'assets/templates/journal-modal/select-timeframe.php'; ?>
                            </div>
                              <div class="col-md-3">
                                <?php  $timeframeId = "TimeFrame51";
                                  include 'assets/templates/journal-modal/select-timeframe.php'; ?>
                              </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-purple mr-3" data-dismiss="modal">Close</button>
                            <input type="submit" id="submitaccount" value="Save" class="btn btn-primary" name="submits">
                        </div>
                        <?php include 'assets/templates/journal-modal/timeframe-forms-all.php'; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class='pswp' tabindex='-1' role='dialog' aria-hidden='true'>
  <div class='pswp__bg'></div>
  <div class='pswp__scroll-wrap'>
    <!-- Container that holds slides. PhotoSwipe keeps only 3 of them in the DOM to save memory. Don't modify these 3 pswp__item elements, data is added later on. --> 
    <div class='pswp__container'> 
      <div class='pswp__item'></div>
      <div class='pswp__item'></div>
      <div class='pswp__item'></div>
    </div>
    <div class='pswp__ui pswp__ui--hidden'> 
      <div class='pswp__top-bar'> 
        <div class='pswp__counter'></div>
        <span class='pswp__button pswp__button--close' title='Close (Esc)'></span> 
        <span class='pswp__button pswp__button--share' title='Share'></span> 
        <span class='pswp__button pswp__button--fs' title='Toggle fullscreen'></span> 
        <span class='pswp__button pswp__button--zoom' title='Zoom in/out'></span> 
        <div class='pswp__preloader'> <div class='pswp__preloader__icn'> 
          <div class='pswp__preloader__cut'> <div class='pswp__preloader__donut'></div>
        </div>
      </div>
    </div>
  </div>
  <div class='pswp__share-modal pswp__share-modal--hidden pswp__single-tap'> 
    <div class='pswp__share-tooltip'></div>
  </div>
  <span class='pswp__button pswp__button--arrow--left' title='Previous (arrow left)'> </span> 
  <span class='pswp__button pswp__button--arrow--right' title='Next (arrow right)'> </span> 
  <div class='pswp__caption'> 
    <div class='pswp__caption__center'></div>
  </div>
</div>
</div>
</div>

<!-- Modal Reason -->
<div id="reasonAdd" class="modal fade" >
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close btn-purple" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="reasonForm" class="inputt">
                <div class="modal-body" id="reasonDetail">
                    <div class="input-group my-3">
                        <!-- <input type="text" id="reasonValue" name="reasonValue" class="form-control reasonValue" required placeholder=""> -->
                        <textarea id="reasonValue" name="reasonValue" style="height: 100% !important;" class="form-control chart-wrapper reasonValue" rows="8" required placeholder=""></textarea>
                        <input type="hidden" id="reasonType" name="reasonType" class="form-control reasonType" value="" />
                        <input type="hidden" id="user_id" name="user_id" class="form-control" value="<?php echo $_SESSION["user_id"]; ?>" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mr-3" data-dismiss="modal">Close</button>
                    <input type="submit" name="reasonsave" id="reasonSave" value="Save" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>

  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
          <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250" style="width: 250px;">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
          </div>
        </form>
        <ul class="navbar-nav navbar-right">
          <div class="form-inline mr-auto">
            <div class="search-element">
              <?php if($_SESSION["usertype_id"] < 2) { ?>
                <select class="custom-select" id="accounts">
                  <?php foreach ($accounts as $key => $item): ?>
                    <option id="sel_user" style="color: black;" value="<?php echo $item->account_id ?>" 
                      <?php if($item->account_id == $_SESSION['account_id']) {?>
                        selected=""<?php }?>><?php echo $item->account_id?></option>  
                  <?php endforeach ?>
                </select>
              <?php } else { ?>
                  <a href="#" aria-label="Search" data-width="130" data-toggle="dropdown" class="form-control"><h5><?php echo $_SESSION['account_id']?></h5></a>
              <?php }?>
            </div>
          </div>
        </ul>
        <ul class="navbar-nav navbar-right">
          <a id="calendar" href="javascript:void(0)" onclick="modalCalendar()" class="nav-link notification-toggle nav-link-lg"><i class="ion-ios-calendar-outline"></i></a>
        </ul>
        <ul class="navbar-nav navbar-right">
          <a id="reload" href="#" class="nav-link notification-toggle nav-link-lg"><i class="ion-ios-refresh-outline"></i></a>
        </ul>
        <ul class="navbar-nav navbar-right">          
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="<?php echo $_SESSION['avatar']?>" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block"><?php echo $_SESSION['username']?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="<?php echo base_url('profile')?>" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
              <div class="dropdown-divider"></div>
              <a href="<?php echo base_url('dashboard/logout')?>" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand side-bar-logo">
            <a href="<?php echo base_url('dashboard')?>">Koena</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?php echo base_url('dashboard')?>">KN</a>
          </div>
          <ul class="sidebar-menu">
            <?php
              if($_SESSION["usertype_id"] < 2) { ?>
                <li data-selection="admin" class="nav-side-bar"><div class="sel-li"><a href="<?php echo base_url('dashboard/index') ?>"><i class="ion-lock-combination"></i>Admin Dashboard</a></div></li>
              <?php }
            ?>
            <li data-selection="general" class="nav-side-bar"><div class="sel-li"><a href="<?php echo base_url('dashboard/general') ?>"><i class="ion-ios-paper"></i>General Dashboard</a></div></li>
            <li data-selection="journal" class="nav-side-bar"><div class="sel-li"><a href="<?php echo base_url('summary/journal') ?>"><i class="ion-social-buffer"></i>Joural Summary</a></div></li>
            <li data-selection="account" class="nav-side-bar"><div class="sel-li"><a href="<?php echo base_url('summary/account') ?>"><i class="ion-social-chrome"></i>Account Summary</a></div></li>
            <li data-selection="profile" class="nav-side-bar"><div class="sel-li"><a href="<?php echo base_url('timezone') ?>"><i class="ion-transgender"></i>Session</a></div></li>
            <li data-selection="profile" class="nav-side-bar"><div class="sel-li"><a href="<?php echo base_url('profile') ?>"><i class="ion-transgender"></i>Profile</a></div></li>
            <li data-selection="plan" class="nav-side-bar"><div class="sel-li"><a href="<?php echo base_url('profile/plan') ?>"><i class="ion-calendar"></i>Plan</a></div></li>
          </ul>
       </aside>
       <script>
          var data_selection = <?php echo($params['selections'])?>;
          $('.nav-side-bar').each(function(){
            this.classList.remove('active');
            let sel = this.getAttribute('data-selection');
            if(data_selection.includes(sel))
              $(this).addClass('active')
          })
        </script>
      </div>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header" style="min-height: 5rem;"></div>
          <div class="section-body">
            <?php include ($page)?>                
          </div>
        </section>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2023 <div class="bullet"></div> Design By <a href="https://nauval.in/">Koena</a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div> 
<script src="<?php echo base_url('assets/js/page/layout.js')?>"></script>
</body>
</html>