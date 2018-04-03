$(document).ready(function(){
	var tempArrayObjects = [];
    var tempArrayids = [];
    var subServiceList = [];
    $.ajax({
        url: get_service_admin,
        type: "get",
        data: {},
        success: function (data) {
            serviceList = JSON.parse(data);
            //console.log(serviceList);
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
                $("#scope_list").append('<li><div class = "check"><input type="checkbox" class="Option" name = "sub_'+masterService.id+'" value =  "'+ masterService.id+'" /><label for="master_' + masterService.id + '"> ' + masterService.service_name + '</label><br /></div></li >');
                //console.log(masterService);
            });

        
		}
	});
	$('#done_service').submit(function(){
		event.preventDefault();

        var dataFromForm = objectifyForm($("#done_service").serializeArray());
        myCheckboxes_scope = [];

        tempArrayids.forEach(masterServiceID => {
            $.each($("input[name='sub_" + masterServiceID + "']:checked"), function () {
                var t = {
                    'id': $(this).val()
                };
                myCheckboxes_scope.push(t);
            });
        });
        var q = "scope";
        dataFromForm[q] = myCheckboxes_scope;

        $.ajax({
            url: service_api,
            type: "post",
            data: dataFromForm,
            success: function (data) {
                console.log(data);
                $('.success-alert').show();
                $("html, body").animate({ scrollTop: 0 }, "slow");
                $("#done_service").trigger('reset');


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
