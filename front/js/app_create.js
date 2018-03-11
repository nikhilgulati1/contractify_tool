var clientList = null;
var subServiceList = null;

$(document).ready(function () {

    $('.form_datetime').datetimepicker({
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        format: 'yyyy-mm-dd hh:ii'
    });

    var isOpen_1 = false;
    $('#contract_start_date').click(function () {
        if (isOpen_1) {
            $('#contract_start_date').blur();
        }
        isOpen_1 = !isOpen_1;
    });
    var isOpen_2 = false;
    $('#contract_end_date').click(function () {
        if (isOpen_2) {
            $('#contract_end_date').blur();
        }
        isOpen_2 = !isOpen_2;
    });

    $.ajax({
        url: "./../back/api/client/get.php",
        type: "get",
        data: {},
        success: function (data) {
            clientList = JSON.parse(data);
            clientList.forEach(client => {
                $("#existing_client_list").append('<li class="nav-item client-pill" onclick="updateExistingClient(' + client.client_id + ')" data-client-id="' + client.client_id + '">' + client.client_name + '</li>');
            });
        }
    });

    var tempArray = [];
    $.ajax({
        url: "./../back/api/service/get.php",
        type: "get",
        data: {},
        success: function (data) {
            subServiceList = JSON.parse(data);
            subServiceList.forEach(subService => {

                if (tempArray.indexOf(subService.master_id) < 0) {
                    tempArray.push(subService.master_id);
                    $("#scope_list").append('<li><label for="master_' + subService.master_id + '"> ' + subService.master_service_name + '</label><ul id="sub_list_' + subService.master_id + '"></ul></li >');
                }

                $("#sub_list_" + subService.master_id).append('<li><label><input type="checkbox" class="subOption">' + subService.scope_name + '</label></li>');

            });
        }
    });

    $("#create_contract").submit(function (event) {

        event.preventDefault();

        var dataFromForm = objectifyForm($("#create_contract").serializeArray());
        //console.log(dataFromForm);
        $.ajax({
            url: "./../back/api/contract/create.php",
            type: "post",
            data: dataFromForm,
            success: function (data) {
                console.log(data);
            }
        });

    });

});

function updateExistingClient(client_id) {
    clientList.forEach(client => {
        if (parseInt(client.client_id) === client_id) {
            populateClientFields(client);
        }
    });
};

function populateClientFields(client_object) {
    $("#client_name").val(client_object.client_name);
    $("#client_spoc").val(client_object.client_spoc);
    $("#client_contact_no").val(client_object.client_contact_no);
    $("#client_pan").val(client_object.client_pan);
    $("#client_gstn").val(client_object.client_gstn);
    $("#client_billing_address").val(client_object.client_billing_address);
    $("#client_payment_terms").val(client_object.client_payment_terms);
    $("#client_address").val(client_object.client_address);
    $("#client_id").val(client_object.client_id);
}

function objectifyForm(formArray) {
    var returnArray = {};
    for (var i = 0; i < formArray.length; i++) {
        returnArray[formArray[i]['name']] = formArray[i]['value'];
    }
    return returnArray;
}
