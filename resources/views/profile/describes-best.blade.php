@extends('layouts.profile')


@section('main-content')
                                <div class="describe-best tab-pane fade active in" id="describe-best">
                                    <!-- <h6 class="enquiries-made title">
                                        <i aria-hidden="true" class="fa fa-thumbs-up">
                                        </i>
                                        What describe Abhay the best?
                                    </h6> -->
                                    <h3 class="profile-stats__title text-medium sectionTitle mobile-hide">
                                        What describes you the best?
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

                                    <div class="save-best-data text-right">
                                        <button class="btn fnb-btn outline full border-btn">Save</button>
                                    </div>

                                    <div class="describe-best" id="accordion" role="tablist" aria-multiselectable="true">
                                      <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingOne">
                                          <h4 class="panel-title flex-row">
                                            <div><input type="checkbox" class="checkbox"></div>
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
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut deleniti, odit iusto sunt impedit quam et, reprehenderit illum laborum fuga atque rem a, adipisci rerum libero alias maxime delectus praesentium laboriosam? Explicabo dolor, consequatur iste. Mollitia recusandae vero sapiente repellendus fugit quasi aliquid, rem nisi modi facilis accusantium, commodi animi.
                                          </div>
                                        </div>
                                      </div>
                                      <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingTwo">
                                          <h4 class="panel-title flex-row">
                                            <div><input type="checkbox" class="checkbox"></div>
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
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta veritatis porro odit, ipsum qui illum asperiores accusamus dolorum suscipit placeat deserunt laborum ipsam sequi. Molestiae veritatis ex reiciendis beatae minus.
                                          </div>
                                        </div>
                                      </div>
                                      <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingThree">
                                          <h4 class="panel-title flex-row">
                                            <div><input type="checkbox" class="checkbox"></div>
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
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                          </div>
                                        </div>
                                      </div>
                                       <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingFour">
                                          <h4 class="panel-title flex-row">
                                            <div><input type="checkbox" class="checkbox"></div>
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
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                          </div>
                                        </div>
                                      </div>
                                      <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingFive">
                                          <h4 class="panel-title flex-row">
                                            <div><input type="checkbox" class="checkbox"></div>
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
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                          </div>
                                        </div>
                                      </div>
                                      <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingSix">
                                          <h4 class="panel-title flex-row">
                                            <div><input type="checkbox" class="checkbox"></div>
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
                                            <div class="form-group m-b-0">
                                                <label class="m-b-0 text-lighter float-label required" for="test">Label</label>
                                                <input type="text" class="form-control fnb-input float-input" id="test">
                                            </div>
                                            <div class="form-group m-b-0">
                                                <label class="m-b-0 text-lighter float-label required" for="new">Label</label>
                                                <input type="email" class="form-control fnb-input float-input" id="new" value="">
                                            </div>
                                            <div class="form-group m-b-0">
                                                <label class="m-b-0 text-lighter float-label required" for="confirm">Label</label>
                                                <input type="tel" class="form-control fnb-input float-input" id="confirm">
                                            </div>
                                            <div class="form-group m-b-0">
                                                <label class="m-b-0 text-lighter float-label required" for="confirm">Label</label>
                                                <input type="tel" class="form-control fnb-input float-input" id="confirm">
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="save-best-data text-right mobile-hide">
                                        <button class="btn fnb-btn outline full border-btn">Save</button>
                                    </div>
                                </div>
@endsection
