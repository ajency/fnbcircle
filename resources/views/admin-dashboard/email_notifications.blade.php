 @extends('layouts.admin-dashboard')

 @section('js')
      @parent
          <script src="/js/jquery.tagsinput.js"></script>
          <script type="text/javascript" src="/js/dashboard-email-notifications.js"></script>
 @endsection

 @section('page-data')
  <div class="right_col" role="main">
      <div class="">

      
        <div class="page-title">
          <div class="title_left">
            <h5>Email Notifications <!-- <small>Some examples to get you started</small> --></h5>
          </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">

          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_content  table-responsive">

                <table id="" class="table table-striped nowrap" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Email Type</th>
                      <th>Recipients</th>
                      <th class="no-sort"></th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr class="email-input-container">
                      <td>New User Registration</td>
                      <td>
                        <input type="text" class="recipients email-input-field" name="notification-new-user" value="test@xxx.com, abc@xxx.com">
                        <!-- <textarea class="form-control no-edit" name="" tabindex="-1">test@xxx.com, abc@xxx.com</textarea> -->
                      </td>
                      <td class="row-actions">
                        <a href="#" title="Edit" class="edit_email_type"><i class="fa fa-pencil"></i></a>
                        <div class="edit-actions hidden">
                          <a href="#" title="Save" class="save_email_type save-email-btn"><i class="fa fa-check text-success"></i></a>
                          <a href="#" title="Cancel" class="cancel_email_type"><i class="fa fa-times text-danger"></i></a>
                        </div>
                      </td>
                    </tr>
                    <tr class="email-input-container">
                      <td>Business Listing for Approval</td>
                      <td>
                        <input type="text" class="recipients email-input-field" name="notification-listing-approval" value="test@xxx.com, abc@xxx.com">
                        <!-- <textarea class="form-control no-edit" name="" tabindex="-1">test@xxx.com, abc@xxx.com</textarea> -->
                      </td>
                      <td class="row-actions">
                        <a href="#" title="Edit" class="edit_email_type"><i class="fa fa-pencil"></i></a>
                        <div class="edit-actions hidden">
                          <a href="#" title="Save" class="save_email_type save-email-btn"><i class="fa fa-check text-success"></i></a>
                          <a href="#" title="Cancel" class="cancel_email_type"><i class="fa fa-times text-danger"></i></a>
                        </div>
                      </td>
                    </tr>
                    <tr class="email-input-container">
                      <td>Advertise with us</td>
                      <td>
                        <input type="text" class="recipients email-input-field" name="notification-advertise" value="test@xxx.com, abc@xxx.com, a1@xxx.com">
                        <!-- <textarea class="form-control no-edit" name="" tabindex="-1">test@xxx.com, abc@xxx.com, a1@xxx.com</textarea> -->
                      </td>
                      <td class="row-actions">
                        <a href="#" title="Edit" class="edit_email_type"><i class="fa fa-pencil"></i></a>
                        <div class="edit-actions hidden">
                          <a href="#" title="Save" class="save_email_type save-email-btn"><i class="fa fa-check text-success"></i></a>
                          <a href="#" title="Cancel" class="cancel_email_type"><i class="fa fa-times text-danger"></i></a>
                        </div>
                      </td>
                    </tr>
                    <tr class="email-input-container">
                      <td>Get Featured</td>
                      <td>
                        <input type="text" class="recipients email-input-field" name="notification-get-featured" value="test@xxx.com, abc@xxx.com, a1@xxx.com">
                        <!-- <textarea class="form-control no-edit" name="" tabindex="-1">test@xxx.com, abc@xxx.com, a1@xxx.com</textarea> -->
                      </td>
                      <td class="row-actions">
                        <a href="#" title="Edit" class="edit_email_type"><i class="fa fa-pencil"></i></a>
                        <div class="edit-actions hidden">
                          <a href="#" title="Save" class="save_email_type save-email-btn"><i class="fa fa-check text-success"></i></a>
                          <a href="#" title="Cancel" class="cancel_email_type"><i class="fa fa-times text-danger"></i></a>
                        </div>
                      </td>
                    </tr>
                    <tr class="email-input-container">
                      <td>Job Listings Posted</td>
                      <td>
                        <input type="text" class="recipients email-input-field" name="notification-job-posted" value="job@xxx.com, j2@xxx.com">
                        <!-- <textarea class="form-control no-edit" name="" tabindex="-1">job@xxx.com, j2@xxx.com</textarea> -->
                      </td>
                      <td class="row-actions">
                        <a href="#" title="Edit" class="edit_email_type"><i class="fa fa-pencil"></i></a>
                        <div class="edit-actions hidden">
                          <a href="#" title="Save" class="save_email_type save-email-btn"><i class="fa fa-check text-success"></i></a>
                          <a href="#" title="Cancel" class="cancel_email_type"><i class="fa fa-times text-danger"></i></a>
                        </div>
                      </td>
                    </tr>
                    <tr class="email-input-container">
                      <td>Contact Us</td>
                      <td>
                        <input type="text" class="recipients email-input-field" name="notification-contact-us" value="job@xxx.com, j2@xxx.com">
                        <!-- <textarea class="form-control no-edit" name="" tabindex="-1">job@xxx.com, j2@xxx.com</textarea> -->
                      </td>
                      <td class="row-actions">
                        <a href="#" title="Edit" class="edit_email_type"><i class="fa fa-pencil"></i></a>
                        <div class="edit-actions hidden">
                          <a href="#" title="Save" class="save_email_type save-email-btn"><i class="fa fa-check text-success"></i></a>
                          <a href="#" title="Cancel" class="cancel_email_type"><i class="fa fa-times text-danger"></i></a>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>

              </div>
            </div>
          </div>

        </div>


      </div>
    </div>


@endsection