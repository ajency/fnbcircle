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
                                    <h3 class="profile-stats__title text-medium sectionTitle">
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
                                    <form action="{{action('ProfileController@updateUserDetails')}}" method="POST" id="details-form" class="m-t-40 describe-form">
                                    <input type="hidden" name="email_id" value="{{$data['email']['email']}}">
                                    <div class="save-best-data text-right desk-hide">
                                        <button class="btn fnb-btn outline full border-btn">Save</button>
                                    </div>
                                    @endif
                                    <div class="describe-best" id="accordion" role="tablist" aria-multiselectable="true">
                                    @foreach($descriptions as $description)
                                      <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="{{$description->value}}">
                                          <h4 class="panel-title flex-row">
                                            <div><input type="checkbox" class="checkbox" name="user_details[]" value="{{$description->value}}" @if(!$self and !$admin) disabled @endif @isset($details[$description->value]) checked @endisset ></div>
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#{{$description->value}}-collapse" aria-expanded="true" aria-controls="collapseOne">
                                                <div>
                                                    {{$description->title}} 
                                                </div>
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                            </a>
                                          </h4>
                                        </div>
                                        <div id="{{$description->value}}-collapse" class="panel-collapse collapse @if($loop->first)in @endif" role="tabpanel" aria-labelledby="{{$description->value}}">
                                          <div class="panel-body">
                                            {{$description->description}} 
                                          </div>
                                        </div>
                                      </div>
                                      @endforeach
                                      
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
        Description updated successfully.
    </div>
</div>

@endif

@endsection
