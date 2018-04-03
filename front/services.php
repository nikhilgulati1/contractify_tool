<!DOCTYPE html>
<html>

<head>
	 <?php 
        
        session_start();
        if(! isset($_SESSION['logged_in'])){
            
            header("Location:login.html");
        }
    ?>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
	 crossorigin="anonymous">
	<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
	<link href="css/style.css" rel="stylesheet" type="text/css" />

</head>

<body>
	<div class="container-fluid create">
		<div class="row heading">
			<div class="col-sm-10">
				<div class="logo">
					<img src="images/logo.png" />
				</div>
			</div>
			<div class="col-sm-2 ">
				<a id="link_1" href="index.php" class="btn btn-primary pull-right" role="button" aria-pressed="true">View All</a>
			</div>
		</div>
		<div class="main-container">
			<div class="row sub-heading">
				<div class="col-sm-12">
					<h2>Choose all the services</h2>
				</div>
			</div>
		</div>
		<form id="done_service">
			<div class="row">
					<div class="col-sm-12">

						<div class="form-sec seobox">

							<h3>Scope Details</h3>
							<br />

							<ul id="scope_list" name="contract_scope"></ul>

						</div>
						<input type="submit" id="submit" value="Done" class="btn btn-primary">
					</div>
			</div>	
		</form>
	</div>	
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
	 crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
	 crossorigin="anonymous"></script>

	<script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>

	<!-- Include our app.js file, this will contain the logic on frontend -->
	<script src="js/path.js"></script>
	<script src="js/service.js"></script>



</body>


</html>