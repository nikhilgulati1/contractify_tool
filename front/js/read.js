var contractDetail = null;
var subServiceList = null;
var contractList = null;

$(document).ready(function () {
    $(".scope_list").attr('readonly', 'readonly');
    

    $('.success-alert').hide();

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

    var tempArray = [];

    var queryStringObject = getUrlVars();
    $.ajax({

        url: read +"?id=" + queryStringObject['id'],
        type: "get",
        data: {},
        success: function (data) {
            contractDetail = JSON.parse(data);
            $.ajax({

                url: get_service,
                type: "get",
                data: {},
                success: function (data) {
                    subServiceList = JSON.parse(data);
                    subServiceList.forEach(subService => {

                        if (tempArray.indexOf(subService.master_id) < 0) {
                            tempArray.push(subService.master_id);

                            $("#scope_list").append('<li><label for="master_' + subService.master_id + '"> ' + subService.master_service_name + '</label><ul id="sub_list_' + subService.master_id + '"></ul></li >');
                        }

                        var isChecked = "";
                        if (contractDetail.sub_services.indexOf(subService.sub_service_id) >= 0) {
                            isChecked = "checked";
                        }

                        $("#sub_list_" + subService.master_id).append('<li><label><input' + isChecked + ' class="subOption" data-master-id="' + subService.master_id + '" value="' + subService.sub_service_id + '" name="master_' + subService.master_id + '">' + subService.scope_name + '</label></li>');

                    });
                    $('.contract_name_head').html(contractDetail.contract_name);
                    populateClientFields(contractDetail);
                    populateContractFields(contractDetail);
                }
            });
        }
    });

    function getUrlVars() {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for (var i = 0; i < hashes.length; i++) {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }

});


function populateClientFields(client_object) {
    $("#client_name").val(client_object.client_name);
    $("#client_spoc").val(client_object.client_spoc);
    $("#client_contact_no").val(client_object.client_contact_no);
    $("#client_pan").val(client_object.client_pan);
    $("#client_billing_address").val(client_object.client_billing_address);
    $("#client_payment_terms").val(client_object.client_payment_terms);
    $("#client_email_address").val(client_object.client_email_address);
    $("#client_id").val(client_object.client_id);
    $("#client_gstn").val(client_object.client_gstn);
}

function populateContractFields(contract_object) {                          // To populate contract data...scopes also need to be added
    $("#client_name").val(contract_object.client_name);
    $("#client_spoc").val(contract_object.client_spoc);
    $("#client_contact_no").val(contract_object.client_contact_no);
    $("#client_pan").val(contract_object.client_pan);
    $("#client_billing_address").val(contract_object.client_billing_address);
    $("#client_payment_terms").val(contract_object.client_payment_terms);
    $("#client_email_address").val(contract_object.client_email_address);
    $("#client_id").val(contract_object.client_id);
    $("#client_gstn").val(contract_object.client_gstn);
    $("#contract_name").val(contract_object.contract_name);
    $("#contract_start_date").val(contract_object.contract_start_date);
    $("#contract_end_date").val(contract_object.contract_end_date);
    $("#contract_description").val(contract_object.contract_description);
    if(contract_object.contract_type ==1){
        $("#contract_type").val("Digital Marketing");
    }
    else if(contract_object.contract_type ==2){
    $("#contract_type").val("Technical");
    }
    else
    $("#contract_type").val("Both");

   
}
function objectifyForm(formArray) {
    var returnArray = {};
    for (var i = 0; i < formArray.length; i++) {
        returnArray[formArray[i]['name']] = formArray[i]['value'];
    }
    return returnArray;
}
