



Ref: http://www.daterangepicker.com/#examples    Predifend date range section



style & script url
------------------

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


html
--------

 <div class="custom-select-holder" >
                 <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                  <i class="fa fa-calendar"></i>&nbsp;
                  <span>Select date range</span> <i class="fa fa-caret-down"></i>
                </div>

              <button type="button" class="searchdate">Search</button>
              <button type="button" class="resetdate">Reset</button>
              </div>





For data table
-----------------
d.daterange=$('#reportrange span').html();


Script
---------
  $(document).ready(function($) {
/*Date range  filter*/

 var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end,origin) {
       if(origin==0){
         $('#reportrange span').html('Select Order Date');
       }else{

        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
       }

    }


Controller
===========

 if (!empty($requestData['daterange']) && $requestData['daterange']!='Select Order Date') {
            $range=explode('-', $requestData['daterange']);
            $start_date=date("Y-m-d H:i:s", strtotime($range[0]));
            $end_date=date("Y-m-d H:i:s", strtotime($range[1]));

            $data=$data->where('order_date', '>=', $start_date)->where('order_date', '<=', $end_date);
        }
    $('#reportrange').daterangepicker({

        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end,0);

    $(document).on('click', '.searchdate', function(event) {
      var dval=$('#reportrange span').html();
      if(dval!='Select Order Date'){
        $('#store_filter').prop('selectedIndex',0);
        $('#supplier_filter').prop('selectedIndex',0);
        $('#giftcard-table').DataTable().draw();
      }
  });

  });//ready








//controller

$data=MasterGiftcardReport::where('supplier', $id);
        if (!empty($requestData['daterange']) && $requestData['daterange']!='Select Order Date') {
            $range=explode('-', $requestData['daterange']);
            $start_date=date("Y-m-d H:i:s", strtotime($range[0]));
            $end_date=date("Y-m-d H:i:s", strtotime($range[1]));

           $data=$data->where('order_date','>=',$start_date)->where('order_date','<=',$end_date);
            // $created_at_start=['created_at','>=',$start_date];
            // $created_at_end=['created_at','<=',$end_date];
            // array_push($whereData, $created_at_start);
            // array_push($whereData, $created_at_end);
        }



