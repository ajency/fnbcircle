 @extends('layouts.admin-dashboard')


 @section('page-data')
  <div class="right_col" role="main">
      <div class="">

      
        <div class="page-title">
          <div class="title_left">
            <h5>Internal Emails <!-- <small>Some examples to get you started</small> --></h5>
          </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">

          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_content  table-responsive">

              	<select id="internal-email-type"></select>
              </div>
            </div>
          </div>

        </div>


      </div>
    </div>


@endsection