$(document).ready(function () {
	$("#login").submit(function (event) {

		event.preventDefault();
		var dataFromLogin = objectifyForm($("#login").serializeArray());
		$.ajax({
			url: login,
			type: "post",
			data: dataFromLogin,
			success: function (data){
				console.log(data);
				// if(data =="success"){
   	// 				 	window.location.href="index.php";
 			// 	}

 			// 	else{
    // 					$("#loading_spinner").css({"display":"none"});
    // 					alert("Wrong Details");
  		// 		}


			}

		});


	});
});	

function objectifyForm(formArray) {
    var returnArray = {};
    for (var i = 0; i < formArray.length; i++) {
        returnArray[formArray[i]['name']] = formArray[i]['value'];
    }
    return returnArray;
}