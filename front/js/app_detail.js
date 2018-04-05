var contractDetail = null;
var allServiceList = null;
var contractList = null;
var legalList = null;

$(document).ready(function () {

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

    var tempArrayObjects = [];
    var tempArrayids = [];
    var subServiceList = [];

    var queryStringObject = getUrlVars();

    $.ajax({
        url: read + "?id=" + queryStringObject['id'],
        type: "get",
        data: {},
        success: function (data) {
            //console.log(data);
            contractDetail = JSON.parse(data);
            //console.log(contractDetail);
            $.ajax({
                url: get_service_admin,
                type: "get",
                data: {},
                success: function (data1) {
                    allServiceList = JSON.parse(data1);
                    $.ajax({
                        url: get_legal,
                        type: "get",
                        data: {},
                        success: function (data2) {
                            //console.log(data2);
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

                                    $("#sub_list_" + service.parent_id).append('<li><div class = "check"><input type="checkbox" ' + isChecked + 'class="subOption" data-master-id="' + service.parent_id + '" value="' + service.id + '" name="sub_' + service.parent_id + '"/><label>' + service.service_name + '</label>&nbsp;</div>&nbsp;&nbsp;&nbsp;&nbsp;<div class = "price"><input id ="price_' + service.id + '" type="number" value="' + currPrice + '"/></div>&nbsp;&nbsp;&nbsp;&nbsp;<div class = "comm"><textarea id = "comment_' + service.id + '" type="text" placeholder="Enter Comments">' + currComment + '</textarea></div></li>');

                                }

                            });

                            $('.contract_name_head').html('Update - ' + contractDetail.contract_name);
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
    $("#client_gstn_upload").change(function (evt) {
        var files = evt.target.files;
        var file = files[0];
        var fileName = file.name;
        if (files && file) {
            var reader = new FileReader();

            reader.onload = function (readerEvt) {
                var binaryString = readerEvt.target.result;
                var q = btoa(binaryString);
                $("#client_gstn").val(q);
                $("#gstn_name").val(fileName);
                $('#gstn_preview').attr('href', 'data:application/pdf;base64,' + q);
                $('#gstn_preview').attr('download', fileName);
                $('#gstn_preview').html(fileName);

            };

            reader.readAsBinaryString(file);
        }
    });

    $("#create_contract1").submit(function (event) {

        event.preventDefault();

        var dataFromForm = objectifyForm($("#create_contract1").serializeArray());

        var myCheckboxes_scope = [];
        var myCheckboxes_legal = [];

        tempArrayids.forEach(masterServiceID => {
            $.each($("input[name='sub_" + masterServiceID + "']:checked"), function () {
                var t = {
                    'parent_id': $(this).attr('data-master-id'),
                    'id': $(this).val(),
                    'price': $('#price_' + $(this).val() + '').val(),
                    'comment': $('#comment_' + $(this).val() + '').val()
                };
                myCheckboxes_scope.push(t);
            });
        });

        $.each($("input[name ='legal']:checked"), function () {
            var s = {
                'id': $(this).attr('legal-id')
            };
            myCheckboxes_legal.push(s);
        });


        var q = "scope";
        dataFromForm[q] = myCheckboxes_scope;

        var t = "contract_id";
        dataFromForm[t] = queryStringObject['id'];

        var m = "legal";
        dataFromForm[m] = myCheckboxes_legal;

        var contract_start_date = $("#contract_start_date").datetimepicker('getDate');
        var contract_end_date = $("#contract_end_date").datetimepicker('getDate');

        var diff = contract_end_date - contract_start_date;
        var days = diff / 1000 / 60 / 60 / 24;

        if (days <= 0) {
            alert('End Time must be greater than Start Time.');
            return false;
        }

        if (myCheckboxes_scope.length == 0) {
            alert('Atleast one scope must be selected.');
            return false;
        }


        var res = window.confirm("Are you sure you want to update!");
        //console.log(res);
        if (res) {
            $.ajax({
                url: update_contract,
                type: "post",
                data: dataFromForm,
                success: function (data) {
                    $("#downpdf_link").attr("href", "../../back/generated/contracts/" + data);
                    $('.success-alert').show();
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                }
            });
        }

    });

});

function updateExistingClient(client_id) {
    contractDetail.forEach(client => {
        if (parseInt(client.client_id) === client_id) {
            populateClientFields(client);
        }
    });
}
function updateExistingContract(contract_id) {                     // To update a contract
    contractList.forEach(contract => {
        if (parseInt(contract.contract_id) === contract_id) {
            populateContractFields(contract);
        }
    });
}


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
    $("#gstn_name").val(client_object.client_gstn_name);
    $('#gstn_preview').attr('href', 'data:application/pdf;base64,' + client_object.client_gstn);
    $('#gstn_preview').attr('download', client_object.client_gstn_name);
    $('#gstn_preview').html(client_object.client_gstn_name);
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
    var parts1 = contract_object.contract_start_date.split('-');
    $("#contract_start_date").datetimepicker("update", new Date(parts1[0], parts1[1] - 1, parts1[2]));
    $("#contract_end_date").val(contract_object.contract_end_date);
    var parts2 = contract_object.contract_end_date.split('-');
    $("#contract_end_date").datetimepicker("update", new Date(parts2[0], parts2[1] - 1, parts2[2]));
    $("#contract_description").val(contract_object.contract_description);
    $("#contract_type").val(contract_object.contract_type);

}
function objectifyForm(formArray) {
    var returnArray = {};
    for (var i = 0; i < formArray.length; i++) {
        returnArray[formArray[i]['name']] = formArray[i]['value'];
    }
    return returnArray;
}
