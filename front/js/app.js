// Jquery's syntax, this will tell this file to run only after our HTML is loaded
$(document).ready(function () {

    // HTML is now loaded, we can start our work.


    // Step 1 : Send a HTTP - GET request to the server or API to fetch all the record
    // Use Jquery's AJAX method, to send GET request
    $.ajax({
        url: "./../back/api/contract/read_all.php",  // The URL of our API
        type: "get",                                                            // The type of the request - GET/POST
        data: {},                                                               // Any data that we want to send as parameter along with the request, empty right now
        success: function (data) {                                              // The callback, this will be called, when we will recieve response from server
            var parsed_data = JSON.parse(data);
            console.log(parsed_data);                                           // Print the response after parsing the JSON

            // Step 2 : loop through the parsed data to dispaly each data on the HTML page
            parsed_data.forEach(element => {

                console.log(element.contract_name);

                // Step 3 : Use JQuery's append function, to dynamically insert the <li> in HTML inside the <ul> placeholder
                $("#list-placeholder").append("<li>" + element.contract_name + "<a href='view_detail.html?id=" + element.contract_id + "'>ReadMore</a><a  id = 'update' href = 'update.html?id=" + element.contract_id + "'> Update</a></li>");

            });
        }
    });

});