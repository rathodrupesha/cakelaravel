

<!-- ======================== Html ========================================-->
 <div class="append_tile_needed">
                  <?php $tile_array=array('2"','3"','4"','5"','6"','8"','10"','12"','15"','18"','24"'); ?>
                  <div class="col-md-5">
                     <label>Tile Needed :</label>
                     <select class="form-control required" name="tile_needed_note[0]">
                        <option value="">--Select Tile--</option>
                        <?php foreach($tile_array as $key=>$value){?>
                        <option value="{{$value}}">{{$value}}</option>
                        <?php } ?>   
                     </select>
                  </div>

                  <div class="col-md-5">
                     <label style="margin-left: 92px">Tile Length :</label>
                     <div class="form-group striped-col">
                        <input type="text" name="tile_note[0]" class="form-control foot required" id="tile_note" onkeypress="javascript: if(event.which === 32 && !this.value.length) return false;">
                     </div>
                  </div>
                  <div class="col-md-2 appned_icon">
                     <span class="plus_needed"><i class="fa fa-plus" style="font-size:18px;"></i></span>
                  </div>
    </div>



<!-- ======================== Script ========================================-->

<!-- FOR Delete -->
$(document).on('click', '.remove_div', function(event) {
      $(this).closest('.row').prev('.row').find('.plus_needed').show();
      
      if( $(this).closest('.row').next('.row').find('.plus_needed').length=='0'){

          $(this).closest('.row').prev('.row').find('.plus_needed').show();
      }else{
      $(this).closest('.row').prev('.row').find('.plus_needed').hide();

      }
      $(this).closest('.row').remove();
      
      var numItems = $('.plus_needed').length;
      
      if(numItems==1){
        
       $('.plus_needed').show();
      }

   });
   


<!-- FOR Add -->
     /*On click of tile_needed + */
    $(document).on('click', '.plus_needed', function(event) {

      var numberIncr = $('.plus_needed').length;
      var tile_array = <?php echo json_encode($tile_array); ?>;
      console.log(tile_array);
      var option_tile='';    
      $.each(tile_array, function( index, value ) {
        console.log(value);
        option_tile+='<option value="'+value+'">'+value+'</option>'
      });
      $(this).hide();

      var fields_tile='<div class="row"><div class="col-md-5"><select class="form-control required" name="tile_needed_note['+numberIncr+']"><option value="">--Select Tile--</option>'+option_tile+'</select></div>';

      fields_tile+='<div class="col-md-5"><div class="form-group striped-col"><input type="text" name="tile_note['+numberIncr+']" class="form-control foot required" id="tile_note['+numberIncr+']" onkeypress="javascript: if(event.which === 32 && !this.value.length) return false;"></div></div>';

       fields_tile+='<div class="col-md-2 appned_icon"><span class="plus_needed"><i class="fa fa-plus" style="font-size:18px;"></i></span><span class="minus_outlet remove_div"><i class="fa fa-minus" style="font-size:18px;"></i></span></div></div>';
   
      $('.append_tile_needed').append(fields_tile);

      numberIncr++;
   });






   OutPUT
   ===========

   Tile Needed :            Tile Length :

   selectbox                 textbox         +
   selectbox                 textbox         -
   selectbox                 textbox         -
   selectbox                 textbox         + -

