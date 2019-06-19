<?php
if (isset($_POST) && !empty($_POST)) {
    echo "<pre>";
    print_r($_POST);
    echo "<pre>";
    print_r($_FILES);


    exit;
    
    
           if ($request->file('media')) {
            if (substr($requestData['media']->getMimeType(), 0, 5) == 'image') {
                $requestData ['media_type']=1;
            }
            if (substr($requestData['media']->getMimeType(), 0, 5) == 'video') {
                $requestData ['media_type']=2;
            }

            $destinationPath = public_path() . '/advertisements/';
            $file = $request->file('media');
            $extension = $request->file('media')->getClientOriginalExtension();
            $fileName = 'start_'.rand(11111, 99999) . strtotime(date('Y-m-d H:i:s')) .'.'. $extension;
            $request->file('media')->move($destinationPath, $fileName);
            $requestData['media'] = $fileName;

            /* Generate Thumb */
            $thumbPath=public_path() . '/advertisements/thumbnail/';
            if ($requestData ['media_type']==1) {
                $img = Image::make($destinationPath.$fileName);
                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath.'/'.$fileName);
            }

            if (isset($requestData ['previous_file_name']) && !empty($requestData ['previous_file_name'])) {

                /* delete previous thumb */
                if (file_exists($thumbPath.$requestData ['previous_file_name'])) {
                    $unlink_url=$thumbPath.$requestData ['previous_file_name'];
                    unlink($unlink_url);
                }
                /* delete previous image or video */
                $unlink_url=$destinationPath.$requestData ['previous_file_name'];
                unlink($unlink_url);
            }
        }
}
?>
<html lang="en">
<head>
    <title>Laravel DataTables Tutorial Example</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">  
        <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
</head>
      <body>
         <div class="container">
         <form method="post" action="edit_image.php" enctype="multipart/form-data">

          <?php
             $imageFromDb="abc.png";
             // if(isset($imageFromDb) && !empty($imageFromDb) && file_exists($imageFromDb)){
             if (isset($imageFromDb) && !empty($imageFromDb)) {
           ?>
            <img src="{{asset('public/user/profile/'.$imageFromDb)}}"  class="displayImage" alt="" width="50px" height="50px"> 
            <input type="file" name="filename" style="display:none; " class="uploadImage">
            <input type="hidden" name="previous_file_name" value="{{$advertisement->media}}">
            <button type="button" class="onChangeImage">change</button>   
          <?php
             } else {
          ?>
           <input type="file" name="filename">
          <?php
             }
          ?>
         
           <input type="submit" value="Submit" name="submit">
          </form>

             
         </div>
       <script>
         $(document).ready(function(){
          $(".onChangeImage").click(function(){
            $(this).hide();
            $(".displayImage").hide();
            $(".uploadImage").show();

          });
        });
       </script>
   </body>
</html>
