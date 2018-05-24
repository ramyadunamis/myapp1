<html><head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
   <title><?php include realpath('.').'/application/views/'.'title_inc.php'; ?></title>

  
      <style>
      * {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

body {
  padding: 20px 15%;
}
form header {
  margin: 0 0 20px 0; 
}
form header div {
  font-size: 90%;
  color: #999;
}
form header h2 {
  margin: 0 0 5px 0;
}
form > div {
  clear: both;
  overflow: hidden;
  padding: 1px;
  margin: 0 0 10px 0;
}
form > div > fieldset > div > div {
  margin: 0 0 5px 0;
}
form > div > label,
legend {
	width: 25%;
  float: left;
  padding-right: 10px;
}
form > div > div,
form > div > fieldset > div {
  width: 75%;
  float: right;
}
form > div > fieldset label {
	font-size: 90%;
}
fieldset {
	border: 0;
  padding: 0;
}

input[type=text],
input[type=email],
input[type=url],
input[type=password],
textarea {
	width: 100%;
  border-top: 1px solid #ccc;
  border-left: 1px solid #ccc;
  border-right: 1px solid #eee;
  border-bottom: 1px solid #eee;
}
input[type=text],
input[type=email],
input[type=url],
input[type=password] {
  width: 50%;
}
input[type=text]:focus,
input[type=email]:focus,
input[type=url]:focus,
input[type=password]:focus,
textarea:focus {
  outline: 0;
  border-color: #4697e4;
}

@media (max-width: 600px) {
  form > div {
    margin: 0 0 15px 0; 
  }
  form > div > label,
  legend {
	  width: 100%;
    float: none;
    margin: 0 0 5px 0;
  }
  form > div > div,
  form > div > fieldset > div {
    width: 100%;
    float: none;
  }
  input[type=text],
  input[type=email],
  input[type=url],
  input[type=password],
  textarea,
  select {
    width: 100%; 
  }
}
@media (min-width: 1200px) {
  form > div > label,
	legend {
  	text-align: right;
  }
}
    </style>



</head>

<body translate="no">

    

  <header>
   
  </header>

     <?php echo form_open('web_view/send_mail',array("class"=>"form-horizontal")); ?>    

  <div>
    <fieldset>
    
      <legend id="title5" class="desc">
        I Enjoy Using This App
      </legend>
      
      <div>
      
      	<div>
      		<input id="Field5_0" name="enjoy" type="radio" value="Yes" tabindex="5" checked="checked">
      		<label class="choice" for="Field5_0">YES</label>
      	</div>
        <div>
        	<input id="Field5_1" name="enjoy" type="radio" value="No" tabindex="6">
        	<label class="choice" for="Field5_1">NO</label>
        </div>
        
      </div>
    </fieldset>
  </div>
  
  <div>
    <fieldset>
      <legend id="title6" class="desc">
        This App Meets My Needs
      </legend>
      <div>
    	<div>
      		<input id="Field5_0" name="meet" type="radio" value="Yes" tabindex="5" checked="checked">
      		<label class="choice" for="Field5_0">YES</label>
      	</div>
        <div>
        	<input id="Field5_1" name="meet" type="radio" value="No" tabindex="6">
        	<label class="choice" for="Field5_1">NO</label>
        </div>
    </div></fieldset>
  </div>
  
  <div>
    <label class="desc" id="title4" for="Field4">
      Message
    </label>
  
    <div>
      <textarea id="Field4" name="Field4" spellcheck="true" rows="10" cols="50" tabindex="4"></textarea>
    </div>
  </div>
   
    <input type="hidden" name="child_name" value=" <?php echo $child_details['child_name']; ?>">
    <input type="hidden" name="child_class" value=" <?php echo $child_details['child_class']; ?>">
    <input type="hidden" name="child_section" value=" <?php echo $child_details['child_section']; ?>">
    <input type="hidden" name="child_father_name" value=" <?php echo $child_details['child_father_name']; ?>">
    <input type="hidden" name="child_mother_name" value=" <?php echo $child_details['child_mother_name']; ?>">
    <input type="hidden" name="child_father_email_id" value=" <?php echo $child_details['child_father_email_id']; ?>">
  <div>
<div>
  		<input id="saveForm" name="saveForm" type="submit" value="Submit">
    </div>
	</div>
    <?php echo form_close(); ?>     
  

  
  
  



 </body></html>