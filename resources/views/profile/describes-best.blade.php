@extends('layouts.profile')

@section('js')
    @parent
    @if(Session::has('updateDescription')) 
    <script type="text/javascript">
    $('.alert-success').addClass('active');
    setTimeout((function() {
      $('.alert-success').removeClass('active');
    }), 5000);
    </script>
    @endif
@endsection

@section('main-content')

                                <div class="describe-best tab-pane fade active in" id="description">
                                    <!-- <h6 class="enquiries-made title">
                                        <i aria-hidden="true" class="fa fa-thumbs-up">
                                        </i>
                                        What describe Abhay the best?
                                    </h6> -->
                                    <h3 class="profile-stats__title text-medium sectionTitle mobile-hide">
                                        What describes @if($self) me @else {{$data['name']}} @endif the best?
                                    </h3>
                                    <!-- <div class="panel-group" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-parent="#accordion" data-toggle="collapse" href="#collapseOne">
                                                        <i aria-hidden="true" class="fa fa-briefcase">
                                                        </i>
                                                        Working Professional
                                                    </a>
                                                </h4>
                                            </div>
                                            <div class="panel-collapse collapse in" id="collapseOne">
                                                adasdas
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-parent="#accordion" data-toggle="collapse" href="#collapseFour">
                                                        <i aria-hidden="true" class="fa fa-graduation-cap">
                                                        </i>
                                                        Student
                                                    </a>
                                                </h4>
                                            </div>
                                            <div class="panel-collapse collapse" id="collapseFour">
                                                qwqw
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-parent="#accordion" data-toggle="collapse" href="#collapseFive">
                                                        <i aria-hidden="true" class="fa fa-users">
                                                        </i>
                                                        Prospective Entreprenuer
                                                    </a>
                                                </h4>
                                            </div>
                                            <div class="panel-collapse collapse" id="collapseFive">
                                                adsd
                                            </div>
                                        </div>
                                    </div> -->

                                    @if($self or $admin)
                                    <form action="{{action('ProfileController@updateUserDetails')}}" method="POST" id="details-form">
                                    <input type="hidden" name="email_id" value="{{$data['email']['email']}}">
                                    <div class="save-best-data text-right">
                                        <button class="btn fnb-btn outline full border-btn">Save</button>
                                    </div>
                                    @endif
                                    <div class="describe-best" id="accordion" role="tablist" aria-multiselectable="true">
                                      <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingOne">
                                          <h4 class="panel-title flex-row">
                                            <div><input type="checkbox" class="checkbox" name="user_details[]" value="hospitality" @if(!$self and !$admin) disabled @endif @isset($details['hospitality']) checked @endisset ></div>
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <div>
                                                    Hospitality Business Owner <i class="fa fa-info-circle p-l-5" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Some data"></i>
                                                </div>
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                            </a>
                                          </h4>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                          <div class="panel-body">
                                            If you are an Owner/Founder/Director/C.E.O of a Restaurant, Catering business, Hotel, Food or Beverage Manufacturing/Processing unit or any other Hospitality business
                                          </div>
                                        </div>
                                      </div>
                                      <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingTwo">
                                          <h4 class="panel-title flex-row">
                                            <div><input type="checkbox" class="checkbox" name="user_details[]" value="professional" @if(!$self and !$admin) disabled @endif @isset($details['professional']) checked @endisset></div>
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                <div>
                                                    Working Professional <i class="fa fa-info-circle p-l-5" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Some data"></i>
                                                </div>
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                            </a>
                                          </h4>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                          <div class="panel-body">
                                            If you are a chef, senior Manager, mid level Manager, Supervisor, Order Taker, Customer Representative, etc
                                          </div>
                                        </div>
                                      </div>
                                      <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingThree">
                                          <h4 class="panel-title flex-row">
                                            <div><input type="checkbox" class="checkbox" name="user_details[]" value="vendor" @if(!$self and !$admin) disabled @endif @isset($details['vendor']) checked @endisset></div>
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                <div>
                                                    Vendor/Suppliers/Service Provider <i class="fa fa-info-circle p-l-5" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Some data"></i>
                                                </div>
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                            </a>
                                          </h4>
                                        </div>
                                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                          <div class="panel-body">
                                            If you or your company trades in or supplies/provides anything to the Hospitality Industry. This category includes Food &amp; Beverage Traders, Manufacturers, Importers, Exporters, Service/Solution Providers
                                          </div>
                                        </div>
                                      </div>
                                       <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingFour">
                                          <h4 class="panel-title flex-row">
                                            <div><input type="checkbox" class="checkbox" name="user_details[]" value="student" @if(!$self and !$admin) disabled @endif  @isset($details['student']) checked @endisset></div>
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
                                                <div>
                                                    Student <i class="fa fa-info-circle p-l-5" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Some data"></i>
                                                </div>
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                            </a>
                                          </h4>
                                        </div>
                                        <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                          <div class="panel-body">
                                            If you are pursuing your education in hospitality sector currently
                                          </div>
                                        </div>
                                      </div>
                                      <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingFive">
                                          <h4 class="panel-title flex-row">
                                            <div><input type="checkbox" class="checkbox" name="user_details[]" value="enterpreneur" @if(!$self and !$admin) disabled @endif  @isset($details['enterpreneur']) checked @endisset></div>
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseThree">
                                                <div>
                                                    Prospective Entrepreneur <i class="fa fa-info-circle p-l-5" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Some data"></i>
                                                </div>
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                            </a>
                                          </h4>
                                        </div>
                                        <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                                          <div class="panel-body">
                                            If you see yourself becoming a part of the awesome Hospitality Industry in the near or distant future
                                          </div>
                                        </div>
                                      </div>
                                      <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingSix">
                                          <h4 class="panel-title flex-row">
                                            <div><input type="checkbox" class="checkbox" name="user_details[]" value="others" @if(!$self and !$admin) disabled @endif  @isset($details['others']) checked @endisset></div>
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseThree">
                                                <div>
                                                    Others <i class="fa fa-info-circle p-l-5" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Some data"></i>
                                                </div>
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                            </a>
                                          </h4>
                                        </div>
                                        <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                                          <div class="panel-body option-col flex-row flex-wrap">
                                           Consultants, Media, Investors, Foodie, etc
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    @if($self or $admin)
                                    <div class="save-best-data text-right mobile-hide">
                                        <button class="btn fnb-btn outline full border-btn">Save</button>
                                    </div>
                                    </form>
                                    @endif
                                </div>
@if(Session::has('updateDescription')) 
<div class="alert fnb-alert alert-success alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <div class="flex-row">
        <i class="fa fa-check-circle" aria-hidden="true"></i>
        Description Updated successfully.
    </div>
</div>

@endif

@endsection
