var contractDetail = null;
var allServiceList = null;
var contractList = null;
var legalList = null;

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

    var tempArrayids = [];
    var tempArrayObjects = [];
    var subServiceList = [];

    var queryStringObject = getUrlVars();
    $.ajax({
        url: read + "?id=" + queryStringObject['id'],
        type: "get",
        data: {},
        success: function (data) {
            contractDetail = JSON.parse(data);
            $.ajax({
                url: get_service,
                type: "get",
                data: {},
                success: function (data1) {
                    allServiceList = JSON.parse(data1);
                    $.ajax({
                        url: get_legal,
                        type: "get",
                        data: {},
                        success: function (data2) {

                            legalList = JSON.parse(data2);

                            legalList.forEach(legal => {
                                var isPresent = contractDetail.legal_ids.indexOf(("" + legal.id));
                                var isChecked = "";
                                if (isPresent >= 0) {
                                    isChecked = "checked ";
                                }
                                $("#legal").append('<li><input type="checkbox" ' + isChecked + 'legal-id="' + legal.id + '" name="legal" /> ' + legal.name + ' </li>');
                            });

                            allServiceList.forEach(service => {

                                if (service.parent_id == null || service.parent_id === 'null') {
                                    if (tempArrayids.indexOf(service.id) < 0) {
                                        tempArrayids.push(service.id);
                                        tempArrayObjects.push(service);
                                        $("#scope_list").append('<li><label for="master_' + service.id + '"> ' + service.service_name + '</label><ul id="sub_list_' + service.id + '"></ul></li >');
                                    }
                                } else {
                                    var isChecked = "";
                                    var isPresent = contractDetail.sub_services_ids.indexOf(("" + service.id));
                                    var currPrice = service.service_price;
                                    var currComment = "";
                                    if (isPresent >= 0) {
                                        isChecked = "checked ";
                                        currPrice = contractDetail.sub_services[isPresent].price;
                                        currComment = contractDetail.sub_services[isPresent].comment;
                                    }
                                    
                                    $("#sub_list_" + service.parent_id).append('<li><div class = "check"><input type="checkbox" ' + isChecked + 'class="subOption" data-master-id="' + service.parent_id + '" value="' + service.id + '" name="sub_' + service.parent_id + '" /><label>' + service.service_name + '</label>&nbsp;</div>&nbsp;&nbsp;&nbsp;&nbsp;<div class = "price"><input id ="price_' + service.id + '" type="number" value="' + currPrice + '"readonly/></div>&nbsp;&nbsp;&nbsp;&nbsp;<div class = "comm"><textarea id = "comment_' + service.id + '" type="text" placeholder="Enter Comments" readonly>' + currComment + '</textarea></div></li>');

                                }

                            });

                            $('.contract_name_head').html(contractDetail.contract_name);
                            var d = new Date(0);
                            d.setUTCSeconds(contractDetail.last_modified);
                            $('.contract_last_mod span').html(d);
                            populateClientFields(contractDetail);
                            populateContractFields(contractDetail);
                        }
                    });
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
    $("#client_gstn_name").val(contract_object.client_gstn_name);
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
