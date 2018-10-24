<?php 
if(isset($_POST) && !empty($_POST)){

  // echo "<pre>"; print_r($_POST); exit();

  $name=$_POST['name'];

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
	    <input type="button" value="add" id="addInput" />

	    </div>
   </form>

   <script type="text/javascript">
   $(document).ready(function() {
        var numberIncr = 1; // used to increment the name for the inputs

        function addInput() {
            $('#inputs').append($('<input class="comment required" name="name['+numberIncr+']" />'));
            numberIncr++;
        }


        //append functin
        $("#addInput").on('click', addInput);

        // validation the form
        $('form.commentForm').validate();

   });


</script>

</body>
</html>