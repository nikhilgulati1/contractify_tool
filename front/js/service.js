$(document).ready(function(){
	var tempArrayObjects = [];
    var tempArrayids = [];
    var subServiceList = [];
    $.ajax({
        url: get_service,
        type: "get",
        data: {},
        success: function (data) {
            serviceList = JSON.parse(data);
            console.log(serviceList);
            serviceList.forEach(service => {
                if (service.parent_id === null || service.parent_id === "" || service.parent_id === 'NULL') {
                    if (tempArrayids.indexOf(service.id) < 0) {
                        tempArrayids.push(service.id);
                        tempArrayObjects.push(service);
                    }
                } else {
                    subServiceList.push(service);
                }
            });

            tempArrayObjects.forEach(masterService => {
                $("#scope_list").append('<li><div class = "check"><input type="checkbox" class="Option" /><label for="master_' + masterService.id + '"> ' + masterService.service_name + '</label><br /></div></li >');
                //console.log(masterService);
            });

        
	}
});
});    