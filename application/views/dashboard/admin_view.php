
<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-16">
    <div class="card" style="text-align: center;">
      <div class="card-header" style="justify-content: space-between;">
        <div class="card-statistic-1" style="width: 100%;">
          <div class="card-stats">
            <div class="card-stats-items">
              <div class="card-stats-item">
                <div class="card-stats-item-count">
                  <i class="ion-ios-person"></i>
                </div>
              </div>
              <div class="card-stats-item" style="width: 100%">
                <div class="card-stats-item-labels">Active Accounts</div>
              </div>
              <div class="card-stats-item">
                <div class="card-stats-item-count"><?php echo $params['data']['active_inactive_account'][0]->active_accounts ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="card-stats-item">
          <div class="card-stats-item-labels">Total number of active trading accounts.</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-16">
    <div class="card" style="text-align: center;">
      <div class="card-header" style="justify-content: space-between;">
        <div class="card-statistic-1" style="width: 100%;">
          <div class="card-stats">
            <div class="card-stats-items">
              <div class="card-stats-item">
                <div class="card-stats-item-count"><i class="ion-ios-people"></i></div>
              </div>
              <div class="card-stats-item" style="width: 100%;">
                <div class="card-stats-item-labels">Active Clients</div>
              </div>
              <div class="card-stats-item">
                <div class="card-stats-item-count"><?php echo $params['data']['active_inactive_client'][0]->active_clients ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="card-stats-item">
          <div class="card-stats-item-labels">Total number of active trading accounts.</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-16">
    <div class="card" style="text-align: center;">
      <div class="card-header" style="justify-content: space-between;">
        <div class="card-statistic-1" style="width: 100%;">
          <div class="card-stats">
            <div class="card-stats-items">
              <div class="card-stats-item">
                <div class="card-stats-item-count"><i class="fas fa-fire"></i></div>
              </div>
              <div class="card-stats-item" style="width: 100%;">
                <div class="card-stats-item-labels">Inactive Accounts</div>
              </div>
              <div class="card-stats-item">
                <div class="card-stats-item-count"><?php echo $params['data']['active_inactive_account'][0]->inactive_accounts ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="card-stats-item">
          <div class="card-stats-item-labels">Total number of active trading accounts.</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-16">
    <div class="card" style="text-align: center;">
      <div class="card-header" style="justify-content: space-between;">
        <div class="card-statistic-1" style="width: 100%;">
          <div class="card-stats">
            <div class="card-stats-items">
              <div class="card-stats-item">
                <div class="card-stats-item-count"><i class="ion-ios-people"></i></div>
              </div>
              <div class="card-stats-item" style="width: 100%;">
                <div class="card-stats-item-labels">Inactive Clients</div>
              </div>
              <div class="card-stats-item">
                <div class="card-stats-item-count"><?php echo $params['data']['active_inactive_client'][0]->inactive_clients ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="card-stats-item">
          <div class="card-stats-item-labels">Total number of active trading accounts.</div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3><i class="ion-navicon-round">&nbsp;List Of Clients And Their Status</i></h3>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="admin_dashboard_client_list">
            <thead>                                 
              <th class="sect1_td">Status</th>
              <th class="sect1_td">Avatar</th>
              <th class="sect1_td">Names</th>
              <th class="sect1_td">Email</th>
              <th class="sect1_td">Package</th>
              <th class="sect1_td">Start date</th>
              <th class="sect1_td">End date</th>
              <th class="sect1_td">Accounts</th>
              <th class="sect1_td">Amount</th>
              <th class="sect1_td">Action</th>
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
  <div class="col-lg-3 col-md-7 col-sm-16">
    <div class="card" style="text-align: center;">
      <div class="card-header" style="justify-content: space-between;">
        <div class="card-statistic-1" style="width: 100%;">
          <div class="card-stats">
            <div class="card-stats-items" style="display: flex; justify-content: space-between;">
              <div class="card-stats-item" style="display: inline-flex; width: 100%;">
                <div class="card-stats-item-count"><i class="ion-ios-person"></i></div>
                <div class="card-stats-item-labels" style="font-size: 0.8rem">Most Purchased package</div>
              </div>
              <div class="card-stats-item">
                <div class="card-stats-item-labels"><?php echo $params['data']['plan'][0]->most_purchased_package ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="card-stats-items">
          <div class="card-stats-item" style="width: 100%;">
            <div class="card-stats-item-labels">Name of most purchased package.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-7 col-sm-16">
    <div class="card" style="text-align: center;">
      <div class="card-header" style="justify-content: space-between;">
        <div class="card-statistic-1" style="width: 100%;">
          <div class="card-stats">
            <div class="card-stats-items">
              <div class="card-stats-item">
                <div class="card-stats-item-count"><i class="ion-ios-people"></i></div>
              </div>
              <div class="card-stats-item" style="width: 100%;">
                <div class="card-stats-item-labels">Most Preferred Package Period</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="card-stats-item">
          <div class="card-stats-item-labels" style="width: 100%;">Name of most preferred package period.</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-md-7 col-sm-16">
    <div class="card">
      <div class="card-header">
        <h4><i class="ion-navicon-round">&nbsp;Payments</i></h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="admin_dashboard_payments_list">
            <thead>                                 
              <th class="sect1_td">Payments Methods </th>
              <th class="sect1_td">Amounts</th>
            </thead>
            <tbody>
            <?php foreach ($params['data']['payment_data'] as $key => $item): ?>
              <tr>
                <td><?php echo $item->payment_method?></td>
                <td><?php echo $item->amount?></td>
              </tr>
            <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url('assets/js/page/admin_dashboard.js')?>"></script>