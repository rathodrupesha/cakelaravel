1) For Thumb generate install library 
   http://www.expertphp.in/article/php-laravel-5-intervention-image-upload-and-resize-tutorial
2) edit blade.php file mate

 <div class="{{$form_control}}">
                                 <?php
                                 $path=public_path().'/storage/uploads/profile_images/thumbnail';
                                 if(isset($user[0]['profile_image']) && !empty($user[0]['profile_image']) && file_exists($path))
                                 {    
                                   $thumb_img_name=str_replace("profile_images/","","profile_images/".$user[0]['profile_image']);
                                ?>
                                     <img src="{{asset('storage/uploads/profile_images/thumbnail/'.$thumb_img_name)}}"  class="displayImage" alt="" width="100px" height="">

                                      <input type="file" name="profile_image" style="display:none; " class="uploadImage file" accept="image/*">

                                       <input type="hidden" name="previous_file_name" value="{{$user[0]['profile_image']}}">

                                      <button type="button" class="onChangeImage" id="{{$user[0]['id']}}" file-name="{{$thumb_img_name}}">Remove</button> 
                                 <?php     
                                  }
                                  else
                                  {
                                ?>
                                    <input type="file" name="profile_image" class="file">
                                 <?php   
                                  }
                                  ?> 
  </div>
@if ($errors->has('profile_image'))
       <span class="text-danger">{{ $errors->first('profile_image') }}</span>
 @endif



<!-- Boot box cdn -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.js"></script>



<!-- script -->

<script type="text/javascript">
/* image change*/
  $(".onChangeImage").click(function(){
     var self=this;
     var id=$(self).attr('id');
     var file_name=$(self).attr('file-name');

     
      bootbox.confirm({
        title: "confirmation",
        message: "Are you sure want to remove image ?",
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> Cancel'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Confirm'
            }
        },
        callback: function (result) {
            if(result==true){
              $(self).hide();
              $(".displayImage").hide();
              $(".uploadImage").show();

                  $.ajax({ 
                          url: "{{ url('admin/remove-profile-image/') }}/"+id+'/'+file_name, 
                          method: 'get', 
                          success: function(result){ 
                               $('.remove_img_msg').show().fadeOut(5000);
                          }});  
            }else{
              
            }
        }
    });

  });

  </script>




  <!-- Controller -->

 $requestData = $request->all();
  if ($request->file('profile_image')) {

            $destinationPath = public_path() . '/storage/uploads/profile_images/';
            $file = $request->file('profile_image');
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            $fileName = rand(11111, 99999) . strtotime(date('Y-m-d H:i:s')) .'.'. $extension;
            $request->file('profile_image')->move($destinationPath, $fileName);
            $requestData['profile_image'] = 'profile_images/'.$fileName;

            $thumbPath=public_path() . '/storage/uploads/profile_images/thumbnail/';
                $img = Image::make($destinationPath.$fileName);
                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath.'/'.$fileName);
            
            if(isset($requestData['previous_file_name']) && !empty($requestData['previous_file_name'])){

               $unlink = public_path() . '/storage/uploads/'.$requestData['previous_file_name'];
               $thumb_img_name=str_replace("profile_images/","","profile_images/".$requestData['previous_file_name']);
                $unlink_thumbnail = public_path() . '/storage/uploads/profile_images/thumbnail/'.$thumb_img_name;

                  if(file_exists($unlink)){

                     unlink($unlink);
                  }

                  if(file_exists($unlink_thumbnail)){

                    unlink($unlink_thumbnail);
                  }
            }
        }