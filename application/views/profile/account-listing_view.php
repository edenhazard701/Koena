<div class="row">
  <div class="col-12 card" style="padding: 30px">
    <div class="row"><h3>User Profile</h3></div>
    <div class="row">
      <div class="col-1" style="padding: 10px">
        <img
          alt="image"
          width="100%"
          height="100%"
          src="<?php echo $_SESSION['avatar']?>"
          class="rounded-circle author-box-picture"
        />
      </div>
      <div class="col-5">
        <?php echo $_SESSION['username']?>
        <div class="author-box-job"><?php echo $_SESSION['email']?></div>
      </div>
      <div class="col-6" style="text-align: right">
        <h6 style="display: inline">Shown as:</h6>
        <select
          style="width: fit-content; display: inline"
          class="form-control form-control-sm"
          id="user_time_zone"
        >
          <option value="-14">GMT -14</option>
          <option value="-13">GMT -13</option>
          <option value="-12">GMT -12</option>
          <option value="-11">GMT -11</option>
          <option value="-10">GMT -10</option>
          <option value="-9">GMT -9</option>
          <option value="-8">GMT -8</option>
          <option value="-7">GMT -7</option>
          <option value="-6">GMT -6</option>
          <option value="-5">GMT -5</option>
          <option value="-4">GMT -4</option>
          <option value="-3">GMT -3</option>
          <option value="-2">GMT -2</option>
          <option value="-1">GMT -1</option>
          <option value="0">GMT +0</option>
          <option value="1">GMT +1</option>
          <option value="2">GMT +2</option>
          <option value="3">GMT +3</option>
          <option value="4">GMT +4</option>
          <option value="5">GMT +5</option>
          <option value="6">GMT +6</option>
          <option value="7">GMT +7</option>
          <option value="8">GMT +8</option>
          <option value="9">GMT +9</option>
          <option value="10">GMT +10</option>
          <option value="11">GMT +11</option>
          <option value="12">GMT +12</option>
          <option value="13">GMT +13</option>
          <option value="14">GMT +14</option>
        </select>
        <button
          type="button"
          data-toggle="modal"
          data-target="#exampleModalCenter"
          class="btn btn-primary"
          style="margin-left: 10px"
        >
          Edit your Avatar
        </button>
      </div>
    </div>
  </div>
  <form id="changeAvatarForm" action="<?php echo base_url('/profile/changeAvatar')?>" method="post">
    <input id='upload-ava' type="file" accept=".png, .jpg, .jpeg" name="image" enctype="multipart/form-data" style='display:none;' onchange="$('#changeAvatarForm').submit();">
    <input type="hidden" name="user_id" value="<?=$_SESSION['user_id']?>">
    <!-- <input type="submit" name="submit" value="Upload">  -->
  </form>

</div>
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card" style="padding:30px">
        <div class="row">
          <div class="col-6">Shown as GMT<?php echo $_SESSION['GMT']?></div>
        <div class="col-6" style="text-align:right">
      <input type="number"/><input type="button" onclick="AddAccount()"  value="+"></input></div>
      </div>
            <ul class="nav nav-pills" id="myTab3" role="tablist">
                <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#serviecs" role="tab" aria-controls="strength" aria-selected="true">Services</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#settings" role="tab" aria-controls="profit" aria-selected="false">Settings</a>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="serviecs" role="tabpanel" aria-labelledby="serviecs">
                    <div class="table-responsive">
                        <table class="table table-striped" id="plan_users_list">
                            <thead>                
                            <th>Email</th>
                            <th>Account ID</th>
                            <th>Broker</th>
                            <th>Added Date</th>
                            <th>Pricing</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings">
                    <div class="col-md-12">
                        <form id="AccountListingGridGrouped" class="table">
                          <div class="row">
                            <div class="col-xl-4 col-lg-4">
                              <div class="card">
                                <div class="card-header">
                                  <h4 class="card-title">Billing</h4>
                                </div>
                                <div class="card-body">
                                  <div class="basic-form">
                                    <div class="input-group mb-3">
                                      <input type="text" class="form-control" placeholder="#123456" aria-label="" readonly>
                                      <div class="input-group-append">
                                        <button class="btn btn-primary changeuser-billing" type="button">Change</button>
                                      </div>
                                    </div>
                                    <div class="mb-3">
                                      <p>First Name</p>
                                      <input
                                        type="text"
                                        class="form-control input-default"
                                        id="fname_setting"
                                        name="fname_setting"
                                        value="<?php echo !empty($_SESSION['fname']) ? $_SESSION['fname']:'';?>"
                                      />
                                      <p class="required error" id="fname_setting-info"></p>
                                    </div>
                                    <div class="mb-3">
                                      <p>Street</p>
                                      <input
                                        type="text"
                                        class="form-control input-default"
                                        id="street_setting"
                                        name="street_setting"
                                        value="<?php echo !empty($_SESSION['street']) ? $_SESSION['street']:'';?>"
                                      />
                                      <p class="required error" id="street_setting-info"></p>
                                    </div>
                                    <div class="mb-3">
                                      <p>Country</p>
                                      <input
                                        type="text"
                                        class="form-control"
                                        id="country_setting"
                                        name="country_setting"
                                        value="<?php echo !empty($_SESSION['country']) ? $_SESSION['country']:'';?>"
                                      />
                                      <p class="required error" id="country_setting-info"></p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-xl-4 col-lg-4">
                              <div class="card">
                                <div class="card-header">
                                  <h4 class="card-title">Email</h4>
                                </div>
                                <div class="card-body">
                                  <div class="basic-form">
                                    <div class="input-group mb-3">
                                      <input type="text" class="form-control" id="email_setting" name="email_setting" placeholder="<?php echo !empty($_SESSION['email']) ? $_SESSION['email']:'';?>" aria-label="" readonly>
                                      <div class="input-group-append">
                                        <button class="btn btn-primary changeuser-email" type="button" >Change</button>
                                      </div>
                                    </div>
                                    <div class="mb-3">
                                      <p>Last Name</p>
                                      <input
                                        type="text"
                                        class="form-control input-default"
                                        id="lname_setting"
                                        name="lname_setting"
                                        value="<?php echo !empty($_SESSION['lname']) ? $_SESSION['lname']:'';?>"
                                      />
                                      <p class="required error" id="lname_setting-info"></p>
                                    </div>
                                    <div class="mb-3">
                                      <p>City</p>
                                      <input
                                        type="text"
                                        class="form-control input-default"
                                        id="city_setting"
                                        name="city_setting"
                                        value="<?php echo !empty($_SESSION['city']) ? $_SESSION['city']:'';?>"
                                      />
                                      <p class="required error" id="city_setting-info"></p>
                                    </div>
                                    <div class="mb-3">
                                      <p>Zip Code</p>
                                      <input
                                        type="text"
                                        class="form-control"
                                        id="zipcode_setting"
                                        name="zipcode_setting"
                                        value="<?php echo !empty($_SESSION['zipcode']) ? $_SESSION['zipcode']:'';?>"
                                      />
                                      <p class="required error" id="zipcode_setting-info"></p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-xl-4 col-lg-4">
                              <div class="card">
                                <div class="card-header">
                                  <h4 class="card-title">Password</h4>
                                </div>
                                <div class="card-body">
                                    <div class="basic-form">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="*********" aria-label="" readonly>
                                            <div class="input-group-append">
                                            <a href="javascript:void(0);" class="btn btn-primary changeuser-pwd">Change</a>
                                                <!-- <button class="btn btn-primary changeuser-pwd"  type="button">Change</button> -->
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <p>Phone</p>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="phone_setting"
                                                name="phone_setting"
                                                value="<?php echo !empty($_SESSION['phone']) ? $_SESSION['phone']:'';?>"
                                            />
                                            <p class="required error" id="phone_setting-info"></p>
                                        </div>
                                        <div class="mb-3">
                                            <p>State/Region</p>
                                            <!-- <input type="text" class="form-control input-default " placeholder="State/Region">  -->
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="state_setting"
                                                name="state_setting"
                                                value="<?php echo !empty($_SESSION['state']) ? $_SESSION['state']:'';?>"
                                            />
                                            <p class="required error" id="state_setting-info"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                  <button type="submit" class="btn btn-warning btn-lg btn-save">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php foreach ($params['data']['planlist'] as $plan) {?>
            <div class="col-12 col-md-4 col-lg-4">
                <?php if ($plan->id == $_SESSION['plan_id']) {?>
                <div class="pricing pricing-highlight" style="border: 1px solid #798ad9;">
                <?php } else {?>
                <div class="pricing" style="border: 1px solid #dce0ef;">
                <?php }?>
                  <div class="pricing-title">
                    Support
                  </div>
                  <div class="pricing-padding">
                    <div class="pricing-price">
                      <div><?php echo $plan->name?></div>
                    </div>
                    <div class="pricing-price">
                      <div>$<?php echo $plan->price?></div>
                    </div>
                    <div class="pricing-price">
                        <h3>Full Access</h3>
                    </div>
                  </div>
                  <div class="pricing-cta">
                    <button 
                      class="btn btn-warning" 
                      data-toggle="modal"
                      data-target="#modalPaymentMethod" 
                      onClick="ChoosePlan(<?php echo $plan->id?>, <?php echo $_SESSION['plan_id'] ?>, <?php echo $plan->price ?>)">
                        <?php if ($plan->id == $_SESSION['plan_id']) {?>
                            Current Plan
                        <?php } else {?>
                            GET
                        <?php }?>
                    </button>
                  </div>
                </div>
              </div>
        <?php } ?>
    </div>
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2><i class="ion-calculator">&nbsp;Invoice</i></h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="plan_invoice_list">
                            <thead>                                 
                                <th>Invoice</th>
                                <th>Invoice Date</th>
                                <th>Start Date</th>
                                <th>Due Date</th>
                                <th>Total</th>
                                <th>Status</th>
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
</script>

<script src="<?php echo base_url('assets/js/page/profile.js')?>"></script>
<script src="<?php echo base_url('assets/js/page/plan.js')?>"></script>
<script src="<?php echo base_url('assets/js/plugins/notify.js')?>"></script>
<script src="<?php echo base_url('assets/js/notifyme.js')?>"></script>
<script src="https://www.paypal.com/sdk/js?client-id=ARsCEDtwbQSGyW6m5uH-0x5Ch_XiLDpb8zeSyn699l20xsytdv7N_iCTVa0HZx1xl262EPYh4xs7oSm6&currency=USD&disable-funding=venmo,credit"></script>