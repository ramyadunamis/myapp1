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
        How useful do you find this application?
      </legend>
      
      <div>
      
      	<div>
      		<input id="Field5_0" name="useful" type="radio" value="VERY USEFUL" tabindex="5" checked="checked">
      		<label class="choice" for="Field5_0">VERY USEFUL</label>
      	</div>
        <div>
        	<input id="Field5_1" name="useful" type="radio" value="LITTLE USEFUL" tabindex="6">
        	<label class="choice" for="Field5_1">LITTLE USEFUL</label>
        </div>
           <div>
        	<input id="Field5_1" name="useful" type="radio" value="NOT USEFUL" tabindex="6">
        	<label class="choice" for="Field5_1">NOT USEFUL</label>
        </div>
      </div>
    </fieldset>
  </div>
  
  <div>
    <fieldset>
      <legend id="title6" class="desc">
       Are you satisfied with the information displayed in the map?
      </legend>
      <div>
    	<div>
      		<input id="Field5_0" name="information" type="radio" value="Yes" tabindex="5" checked="checked">
      		<label class="choice" for="Field5_0">YES</label>
      	</div>
        <div>
        	<input id="Field5_1" name="information" type="radio" value="No" tabindex="6">
        	<label class="choice" for="Field5_1">NO</label>
        </div>
    </div></fieldset>
  </div>
  
    
    
    <div>
    <fieldset>
      <legend id="title6" class="desc">
       Are you satisfied with the design of the Application?
      </legend>
      <div>
    	<div>
      		<input id="Field5_0" name="design" type="radio" value="Yes" tabindex="5" checked="checked">
      		<label class="choice" for="Field5_0">YES</label>
      	</div>
        <div>
        	<input id="Field5_1" name="design" type="radio" value="No" tabindex="6">
        	<label class="choice" for="Field5_1">NO</label>
        </div>
    </div></fieldset>
  </div>
    
    
  <div>
    <label class="desc" id="title4" for="Field4">
     Did you find inaccuracies in the Application? If YES, pls let us know in the comments area below.
    </label>
  
    <div>
      <textarea id="Field4" name="inaccuracies" spellcheck="true" rows="10" cols="50" tabindex="4"></textarea>
    </div>
  </div>
   
    
      <div>
    <label class="desc" id="title4" for="Field4">
     What improvements would you like to see in this application?
    </label>
  
    <div>
      <textarea id="Field4" name="improvements" spellcheck="true" rows="10" cols="50" tabindex="4"></textarea>
    </div>
  </div>
    
    
    
          <div>
    <label class="desc" id="title4" for="Field4">
    Would you like us to call you regarding improvements to this Application? If YES, pls enter your name & telephone number so that we can contact you.
    </label>
  
    <div>
      <textarea id="Field4" name="call" spellcheck="true" rows="10" cols="50" tabindex="4"></textarea>
    </div>
  </div>

   
    
    
    <input type="hidden" name="child_name" value=" <?php echo $child_details['child_name']; ?>">
    <input type="hidden" name="child_class" value=" <?php echo $child_details['child_class']; ?>">
    <input type="hidden" name="child_section" value=" <?php echo $child_details['child_section']; ?>">
    <input type="hidden" name="child_father_name" value=" <?php echo $child_details['child_father_name']; ?>">
    <input type="hidden" name="child_mother_name" value=" <?php echo $child_details['child_mother_name']; ?>">
    <input type="hidden" name="child_father_email_id" value=" <?php echo $child_details['child_father_email_id']; ?>">
    
     <input type="hidden" name="child_father_tel" value=" <?php echo $child_details['child_father_tel']; ?>">
    <input type="hidden" name="child_mother_tel" value=" <?php echo $child_details['child_mother_tel']; ?>">
    <input type="hidden" name="	child_home_tel" value=" <?php echo $child_details['child_home_tel']; ?>">
    
    
  <div>
<div>
  		<input id="saveForm" name="saveForm" type="submit" value="Submit">
    </div>
	</div>
               <div>
    
    If you would like to contact us: Pls call us on 052-6932829 or email us at online@dunamisworld.com
   
           </div>
    <?php echo form_close(); ?>     
  

  
  
  



 </body></html>