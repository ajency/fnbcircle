<!-- Contact Modal -->
<div class="modal fnb-modal contact-modal verification-modal multilevel-modal fade" id="contact-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">
        <div class="modal-header">
           <button class="close mobile-hide" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
           <div class="mobile-back flex-row desk-hide">
              <div class="back ellipsis">
                 <button class="btn fnb-btn outline border-btn no-border" data-dismiss="modal"><i class="fa fa-arrow-left p-r-10" aria-hidden="true"></i></button>
                 <span class="m-b-0 ellipsis heavier back-text">Back to {{$data['title']['name']}}</span>
              </div>
           </div>
        </div>
        <div class="modal-body">
           <!-- data goes here -->
<!--            <div class="site-loader">
                <div id="floatingBarsG">
                    <div class="blockG" id="rotateG_01"></div>
                    <div class="blockG" id="rotateG_02"></div>
                    <div class="blockG" id="rotateG_03"></div>
                    <div class="blockG" id="rotateG_04"></div>
                    <div class="blockG" id="rotateG_05"></div>
                    <div class="blockG" id="rotateG_06"></div>
                    <div class="blockG" id="rotateG_07"></div>
                    <div class="blockG" id="rotateG_08"></div>
                </div>
            </div> -->
        </div>
     </div>
  </div>
</div>
<!-- Contact Modal End -->
<div id="CR">
 @include('modals.verification.new-mobile-number')
 </div>