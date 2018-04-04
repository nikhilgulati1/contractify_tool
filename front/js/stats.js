$(document).ready(function () {

	$.ajax({
		url: stats,
		type: "get",
		data: {},
		success:function(data){
			//var list = JSON.parse(data);
			console.log(data);
			// list.forEach(element => {
			// 	$('#con').append(list.);
			// });
		}




	});

});