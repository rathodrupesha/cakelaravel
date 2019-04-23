<?php
if (isset($_POST) && !empty($_POST)) {
    // echo "<pre>"; print_r($_POST); exit();
    $name=array_values($_POST['name']);
    for ($i=0; $i <count($name); $i++) {
        echo $name[$i];
        echo "<br>";
        //write here insert query
    }
}
?>

<html>
  <head>
    <title>reCAPTCHA demo: Explicit render after an onload callback</title>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>  
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
   
  </head>
  <body>

    <form class="commentForm" method="post" action="dynamic_field_validation.php">
         
	    <div>

	        <p id="inputs">    
	            <input class="comment required" name="name[0]" />
	        </p>

	    <input class="submit" type="submit" value="Submit" />

	    </div>
   </form>
      <input type="button" value="add" id="addInput" />

  <script type="text/javascript">

     $(document).ready(function() {

          var numberIncr = 1; // used to increment the name for the inputs

          function addInput() {
              $('#inputs').append($('</br><input class="comment required  del_'+numberIncr+'" name="name['+numberIncr+']" />&nbsp;<span class="delete_btn" del_attribute="'+numberIncr+'">delete</span>'));
              numberIncr++;
          }
          //append functin
          $("#addInput").on('click', addInput);
         
          
     });

     /*validation the form*/
     $(".submit").click(function(){
       $('form.commentForm').validate();
     });
     /* Delete */
     $(document).on('click', '.delete_btn', function(){
      
        $(this).remove();
        var classname=$(this).attr("del_attribute");
        $(".del_"+classname).remove();
     });

</script>

</body>
</html>