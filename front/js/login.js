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
				if(data == '1'){
   	 				 	window.location.href ="../front/select.php";

 				}
 				else if(data == '0'){
 						window.location.href ="../front/index.php";
 				}

				else{
    					alert("Wrong Details");
  				}


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