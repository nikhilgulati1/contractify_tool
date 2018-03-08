// Jquery's syntax, this will tell this file to run only after our HTML is loaded
$(document).ready(function () {

    // HTML is now loaded, we can start our work.

    // Step 0-: Add a listener to form click or more specificallly when form gets submitted
    $("#create_contract").submit(function (event) {

        // Since this is the func called, when form submit, we need to add this.
        event.preventDefault();

        // This will be called when the forms get submitted, so we will move our AJAX res insied this func

        // But first, lets get the data from the form here.
        console.log(objectifyForm($("#create_contract").serializeArray()));
        // instead of readin each field manuall, we used this func, that will create an array of all the field. We just consoled this. Let see what we get.

        var dataFromForm = objectifyForm($("#create_contract").serializeArray());

        // Step 1 : Send a HTTP - POST request to the server or API to create the record
        // Use Jquery's AJAX method, to send POST request
        $.ajax({
            url: "./../back/api/contract/create.php",  // The URL of our API
            type: "post",                                                            // The type of the request - GET/POST
            data: dataFromForm,                                                               // Any data that we want to send as parameter along with the request, empty right now
            success: function (data) {                                              // The callback, this will be called, when we will recieve response from server
                alert(data);                                           // Print the response after parsing the JSON
            }
        });

    });

    function objectifyForm(formArray) {//serialize data function

        var returnArray = {};
        for (var i = 0; i < formArray.length; i++) {
            returnArray[formArray[i]['name']] = formArray[i]['value'];
        }
        return returnArray;
    }

});