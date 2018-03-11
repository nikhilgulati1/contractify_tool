<!DOCTYPE html>
<html>
<head>

	<link href="css/style.css" />
	<style>
		body {
			font-family: Arial, Helvetica, sans-serif;
		}

		input[type=text],
		select,
		textarea {
			width: 100%;
			padding: 12px;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-sizing: border-box;
			margin-top: 6px;
			margin-bottom: 16px;
			resize: vertical;
		}

		input[type=submit] {
			background-color: #4CAF50;
			color: white;
			padding: 12px 20px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
		}

		input[type=submit]:hover {
			background-color: #45a049;
		}

		.container {
			border-radius: 5px;
			background-color: #f2f2f2;
			padding: 20px;
		}
	</style>
</head>

<body>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="js/update.js"></script>

	<!-- Include our app.js file, this will contain the logic on frontend -->
	
	<div class="container">

		<form id="update_contract">

			<h3>Client Details</h3>

			<label for="client_name">Client Name</label>
			<input type="text" id="client_name" name="client_name">

			<br>


			<label for="client_address">Contract Address</label>
			<input type="text" id="client_address" name="client_address">

			<br>
			<br>

			<h3>Contract Details</h3>

			<label for="contract_name">Contract Name</label>
			<input type="text" id="contract_name" name="contract_name">

			<br>

			<label for="contract_duration">Contract Duration</label>
			<input type="text" id="contract_duration" name="contract_duration">

			<br>

			<label for="contract_description">Contract Description</label>
			<input type="text" id="contract_description" name="contract_description">

			<br>
			<br>

			<h3>Scope Details</h3>

			<input type="checkbox" id="scope1" value="service_1">This is service one.
			<br>
			<input type="checkbox" id="scope2" value="service_2">This is service two.

			<!-- checked="checked" -->

			<br>
			<br>

			<input type="submit" id ="update" value="Update">

			<br>

		</form>
	</div>


	<!-- Include JQuery - A JS library to make life easier -->
	

</body>

</html>