
          <div class="right-side-code ajaxcouponsection scroll-append">
            <h1 class="section_tile">Best Buy Promo Codes, Coupons & Deals</h1>

            <?php foreach ($couponData1 as $key => $value) {?>
               <div class="coupon_code_box">
                </div>
            <?php } ?>

          </div>




A) On Blade file  script
=================
<script type="text/javascript">
//On scroll load the page
$(document).ready(function(){

    var skip ='{{$skip}}';
    var take ='{{$take}}';
    var reachedMax = false;
    var originalHight=$( ".scroll-append" ).height();

    $(window).scroll(function(){

      if (($(window).scrollTop() >= $(document).height()- $(window).height()) && reachedMax==false) { //upto scroll corner end or full scroll
      // if ($(window).scrollTop() >=$( ".scroll-append" ).offset().top+originalHight) { //upto div height end

        $(".ajaxcouponsection").LoadingOverlay("show");
         $.ajax({
          url: "{{$actualLink}}",
          type: 'GET',
          data:{'skip':skip,'take':take},
          datatype: "html",
          success: function(data) {
             if(data != ''){
              skip=parseInt(skip)+10; //efect from php to j query
              $('.scroll-append').append(data);

              $('html,body').animate({
                                      scrollTop: $(".A" + skip).first().offset().top-122
                                      }, 'slow');
              // originalHight=$( ".scroll-append" ).height();


            }else{
              reachedMax=true;
            }
              $(".ajaxcouponsection").LoadingOverlay("hide");

          }
        });
      }
    });

});//document ready2
</script>




B) Controller
==========
<?php

public function coupons(Request $request)
    {
        $actualLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $take=10;
        $noOfAppend=10;
        if (Request::ajax()) { //B. onscroll
            $reqData =Request::all();
            if (!empty($reqData['skip']) || $reqData['skip']==0) {
                $skip=$reqData['skip']+$noOfAppend;
                //Not deleted & front side show is 1
                $couponData1=MasterCoupon::where('is_deleted', 0)->where('show_status', 1)->skip($skip)->take($take)->get()->toArray();

                if (count($couponData1)>0) {
                    foreach ($couponData1 as $key => $value) {
                        $currentDate=date('Y-m-d');
                        if ($value['start_date']>$currentDate) {
                            $couponData1[$key]['tag']="Future Promotion";
                        } elseif ($value['end_date']>date('Y-m-d', strtotime('-3 month')) && $value['end_date']<$currentDate) {
                            $couponData1[$key]['tag']="Most Recent";
                        } else {
                            $couponData1[$key]['tag']="";
                        }
                    }
                    return view('frontend.home.scrollOfCoupons', compact('userprofileheadinfo', 'couponCategory', 'couponData2', 'couponData1', 'skip', 'take'))->render();
                } else {
                    return '';
                }
            }
        } else { //A.Normal
            $skip=0;

            $couponData1=MasterCoupon::where('is_deleted', 0)->where('show_status', 1)->skip($skip)->take($take)->get()->toArray();


            foreach ($couponData1 as $key => $value) {
                $currentDate=date('Y-m-d');
                if ($value['start_date']>$currentDate) {
                    $couponData1[$key]['tag']="Future Promotion";
                } elseif ($value['end_date']>date('Y-m-d', strtotime('-3 month')) && $value['end_date']<$currentDate) {
                    $couponData1[$key]['tag']="Most Recent";
                } else {
                    $couponData1[$key]['tag']="";
                }
            }

            return view('frontend.home.coupon-page', compact('userprofileheadinfo', 'couponCategory', 'couponData2', 'couponData1', 'skip', 'take', 'actualLink', 'showCashBackBlock', 'advertiserId', 'storeAdvtName', 'storeCashbackValue', 'storeTermsConditions', 'storeLogo', 'storeDomain', 'isStoreViseCouponPage'));
        }
    }

?>

C) Dynamic blade scrollOfCoupons

=================================

<?php foreach ($couponData1 as $key => $value) {?>

             <div class="coupon_code_box A{{$skip}}">  <--this is important for scroll & set to show

              <?php if(!empty($value['percentage_off'])){?>
                <div class="per_off">
                  <?php echo preg_replace('/[^0-9$%.]+/', '', $value['percentage_off']).' Off'; ?>  {{$value['id']}}
                </div>
              <?php } ?>

            <div class="desc_coupon">
             <?php
              $vendordomain = '';
              if ($value['merchant_home_page']) {
                  $vendor_url_array = parse_url($value['merchant_home_page']);
                  //print_r($value['destination']);
                  if (isset($vendor_url_array['host'])) {
                      $vendordomain = $vendor_url_array['host'];
                  }
              }
              ?>

              <?php if (($value['image_url']!="")) {
                  ?>
               <?php  //manually upload image then
               if (file_exists("public/frontend/images/coupon-upload-images/".$value['image_url'])) {?>
              <img src="<?php echo url(); ?>/public/frontend/images/coupon-upload-images/<?php echo $value['image_url']; ?>" alt="{{$value['title']}}" class="" style="height:auto; width:100px;">
               <?php }
                  //direct image url then
                  if (isURL($value['image_url'])) {?>
                    <img src="{{$value['image_url']}}" alt="{{$value['title']}}" class="" style="height:auto; width:100px;">

               <?php } ?>

             <?php
              } elseif ($vendordomain) { ?>
                <!-- clear bit logo by domain -->
                 <img src="https://logo-core.clearbit.com/{{$vendordomain}}" onerror="this.onrrror=null;this.src='<?php echo url(); ?>/public/uploads/no-image.png';" alt="{{$value['title']}}" class="" style="height:auto; width:100px;">

            <?php } else {?>
              <!-- No image found then -->
              <img src="<?php echo url(); ?>/public/uploads/no-image.png" alt="{{$value['title']}}" class="" style="height:auto; width:100px;">

             <?php } ?>

              <h4 class="offer_text_title">{{$value['title']}}</h4>
              <p class="offer_desc">
                <?php $readLessDescription=substr($value['description'], 0, 20); ?>
                <?php if (strlen($value['description'])>20) { ?>
                <div class="readLess"><span class="lesscont"><?php echo html_entity_decode($readLessDescription)?>
                ... </span><b><span class="metaDespReadMoreSpan" style="color: #31C3E4;cursor: pointer" data-toggle="collapse" data-target="#{{$value['id']}}">Read More</span></b>
               </div>

               <div class="readMore collapse" id="{{$value['id']}}"><?php echo html_entity_decode($value['description']);?>
               </div>
               <?php } else {
                  echo $value['description'];
              } ?>

             </p>
            </div>

              <div class="tag_right">
              {{$value['tag']}}
              </div>

            <div class="btn_right">
              <?php
              $couponId=base64_encode($value['id']);
              $couponType=$value['type'];
              $couponCode=base64_encode(base64_encode($value['code']));
              ?>
              <a href="javascript:void(0)" class=" btn btn-solid-blue" id="{{$value['id']}}">
                <img src="{{asset('public/frontend/images/coupon-store-page/whit_icon_img-min.png')}}" alt="" >

               <?php
                    if ($couponType=='Code') {
                        $cTitle="Click to Copy";
                    } else {
                        $cTitle="Click for Deal";
                    }
                ?>
                <span class="coupan_code_defult1 CID_{{$value['id']}}"  data-toggle="tooltip1" data-placement="top" title="{{$cTitle}}" ci='{{$couponId}}' ct='{{$couponType}}' cc='{{$couponCode}}'>
                <?php
                    if ($couponType=='Code') { ?>
                       {{$value['code']}}
                  <?php   } else {
                        echo "Deal";
                    } ?>

                </span>

              </a>
            </div>
            </div>
          <?php } ?>