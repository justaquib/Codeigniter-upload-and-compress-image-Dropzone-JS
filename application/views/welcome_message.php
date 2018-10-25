<?php
/*
Author : Aquib Shahbaz
Note   : You can change and play with more stuffs here
				 Connent database and insert/delete/update and
				 make your changes and find more stuffs
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Dropzone.js file upload using codeigniter with compression</title>

	<style type="text/css">
	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }
	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}
	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}
	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}
	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}
	#body {
		margin: 0 15px 0 15px;
	}
	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	.final-info{
		margin: 15px 0;
	    background-color: #f5f5f5;
	    padding: 20px;
	}
	#submit_dropzone_form{
		margin-top: 5px;
	}
	</style>
	<!-- Loading dropzone.css -->
	<link href="<?php echo base_url(); ?>assets/dropzone/dropzone.css" rel="stylesheet" type="text/css"/>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>

<div id="container">
	<h1>Using Dropzone.js with codeigniter</h1>
	<div id="body">
		<form method="post" action="<?php echo base_url(); ?>index.php/welcome/uploads" enctype="multipart/form-data" class="dropzone" id="myAwesomeDropzone">
		</form>
		<button type="button" class="btn btn-primary btn-lg" id="submit_dropzone_form">Upload</button>
		<div  id="boatAddForm" class="final-info">
			<label for="uploaded_files">Response recieved will be displayed here</label>
		</div>
		<div class="final-info" id="message">

		</div>
		<div class="final-info">
			<div class="row" id="live_data">

			</div>
		</div>
	</div>
</div>
<style media="screen">
	.dropzone .dz-preview .dz-remove
	{
		background-color: #E53935;
		color: #fff;
		text-decoration: none;
		padding: 5px;
		border-radius: 4px;
		margin: 5px;
	}
	.dropzone .dz-preview .dz-remove:hover
	{
		text-decoration: none;
		background-color: #D32F2F;
	}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Loading dropzone.js -->
<script src="<?php echo base_url(); ?>assets/dropzone/dropzone.js"></script>
<!-- Initiliazing dropzone -->
<script>
$(document).ready(function(){
	function fetch_gallery()
	{
		$.ajax({
				 url:"<?php echo base_url(); ?>index.php/welcome/fetch_gallery",
				 method:"POST",
				 success:function(data){
							$('#live_data').html(data);
				 }
		});
	}
	fetch_gallery();
	$(document).on('click','.thrash',function(){
		var file = $(this).attr('data-call');
		//alert(file);
		$.ajax({
			url: "<?php echo base_url(); ?>index.php/welcome/delete",
			type: "POST",
			data: { 'name': file},
			success:function(data)
	    {
	     $('#message').html(data+' File has been successfully removed');
			 fetch_gallery();
	    }
		});
	});
});
Dropzone.options.myAwesomeDropzone = {
		//autoDiscover: false,
		acceptedFiles: "image/*",
		autoProcessQueue: false, //if this is "false" then the below #submit_dropzone_form will work.
  	uploadMultiple: true,
  	parallelUploads:1,
		dictDefaultMessage: "Drop files here to upload",
		addRemoveLinks:true,
		dictUploadCanceled: true,

	successmultiple:function(data,response){
		var pix = (response).replace(/"/g,'').replace(/\[/g,'').replace(/\]/g,'');
		$("#boatAddForm").append('<input type="text" name="files[]" value="'+pix+'">');
		$(".dz-remove").hide();
		fetch_gallery();
		/*
		-------------------------------------------------------------
		Can add here remove function just make autoProcessQueue true,
		and .dz-remove to shadow
		-------------------------------------------------------------

		this.on("removedfile", function(file) {
		alert(response);
		$.ajax({
			url: "<?php //echo base_url(); ?>index.php/welcome/delete",
			type: "POST",
			data: { 'name': response},
			success:function(data)
	    {
	     $('#message').html(data);
			 fetch_gallery();
	    }
			});
		});
		*/
	},
	init: function() {
		//Submitting the form on button click
		var submitButton = document.querySelector("#submit_dropzone_form");
			myDropzone = this; // closure
		submitButton.addEventListener("click", function() {
			myDropzone.processQueue(); // Tell Dropzone to process all queued files.
		});
	}
};
</script>
</body>
</html>
