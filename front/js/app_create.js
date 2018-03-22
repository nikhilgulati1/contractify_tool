var clientList = null;
var serviceList = null;
var legalList = null;


$(document).ready(function () {

    $('.success-alert').hide();

    $('.form_datetime').datetimepicker({
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        format: 'yyyy-mm-dd'
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

    $("#contract_start_date").datetimepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        maxDate: '0',
        onClose: function( selectedDate ) {
        $( "#contract_end_date" ).datetimepicker( "option", "minDate", selectedDate );
        }
    });
    $("#contract_end_date").datetimepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        maxDate: '0',
        onClose: function( selectedDate ) {
        $( "#contract_end_date" ).datetimepicker( "option", "maxDate", selectedDate );
        }
    });

    $('#existing_client_list').on('change',function(){
        var selected = $('#existing_client_list').find(":selected").attr('data-client-id');
        updateExistingClient(selected);
    });

    $.ajax({
        url: get_client,
        type: "get",
        data: {},
        success: function (data) {
            clientList = JSON.parse(data);
            clientList.forEach(client => {
                $("#existing_client_list").append('<option class="nav-item client-pill"  data-client-id="' + client.client_id + '">' + client.client_name + '</option>');
            });
        }
    });

    var tempArrayObjects = [];
    var tempArrayids = [];
    var subServiceList = [];
    $.ajax({
        url: get_service,
        type: "get",
        data: {},
        success: function (data) {
            serviceList = JSON.parse(data);
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
                $("#scope_list").append('<li><label for="master_' + masterService.id + '"> ' + masterService.service_name + '</label><br /><ul id="sub_list_' + masterService.id + '"></ul></li >');
                //console.log(masterService);
            });

            subServiceList.forEach(subService => {

                $("#sub_list_" + subService.parent_id).append('<li><div class = "check"><input type="checkbox" class="subOption" data-master-id="' + subService.parent_id + '" value="' + subService.id + '" name="sub_' + subService.parent_id + '"/><label>' + subService.service_name + '</label>&nbsp;</div>&nbsp;&nbsp;&nbsp;&nbsp;<div class = "price"><input id ="price_' + subService.id + '" type="number" value="' + subService.service_price + '"/></div>&nbsp;&nbsp;&nbsp;&nbsp;<div class = "comm"><textarea id = "comment_' + subService.id + '" type="text" placeholder="Enter Comments"/></textarea></div></li>');

                //console.log(subService);
            });
        }
    });

    $.ajax({
        url: get_legal,
        type: "get",
        data: {},
        success: function (data) {
            legalList = JSON.parse(data);
            legalList.forEach(legal => {

                //console.log(legal);
                $("#legal").append('<li><input type="checkbox" checked legal-id="' + legal.id + '" name="legal" /> ' + legal.name + ' </li>');
                //console.log(masterService);
            });

        }
    });
    var daysObject = getdays();
    console.log(daysObject);
    function getdays() {
        
        var hashes = $('#client_payment_terms').slice("+")[1];
        
        return hashes;
    }


    $("#create_contract").submit(function (event) {

        event.preventDefault();

        var dataFromForm = objectifyForm($("#create_contract").serializeArray());

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

        var m = "legal";
        dataFromForm[m] = myCheckboxes_legal;

        var u = "days";
        dataFromForm [u] = daysObject;

        //console.log(dataFromForm);

        $.ajax({
            url: create_contract,
            type: "post",
            data: dataFromForm,
            success: function (data) {

                $("#downpdf_link").attr("href", "http://localhost/contractify/back/generated/contracts/" + data);
                $('.success-alert').show();
                $("html, body").animate({ scrollTop: 0 }, "slow");

            }
        });

    });

});

function updateExistingClient(client_id) {

    clientList.forEach(client => {
        if (parseInt(client.client_id) == client_id) {
            populateClientFields(client);
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
}

function objectifyForm(formArray) {
    var returnArray = {};
    for (var i = 0; i < formArray.length; i++) {
        returnArray[formArray[i]['name']] = formArray[i]['value'];
    }
    return returnArray;
}
