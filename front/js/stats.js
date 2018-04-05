$(document).ready(function () {

	$.ajax({
		url: stats,
		type: "get",
		data: {},
		success:function(data){
			var list = JSON.parse(data);
			console.log(list);
			
				$('#con').html(list.total_contracts);
				$('#cli').html(list.total_client);
				$('#mas').html(list.total_master);

			
		}




	});

});