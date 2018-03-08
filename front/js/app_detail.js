$(document).ready(function () {

    var q_string = getUrlVars();
    var id = q_string.id;
    console.log(id);
    $.ajax({
        url: "http://localhost/contractify_tool/back/api/contract/read.php?id=" +id,  // The URL of our API
        type: "get",                                                            // The type of the request - GET/POST
        data: {'id':id},                                                               // Any data that we want to send as parameter along with the request, empty right now
        success: function (data) {   
            console.log(data);  
                                                     // The callback, this will be called, when we will recieve response from server
            var parsed_data = JSON.parse(data);                                 
            console.log(parsed_data);                                           // Print the response after parsing the JSON

            // Step 2 : loop through the parsed data to dispaly each data on the HTML page
    

                

                // Step 3 : Use JQuery's append function, to dynamically insert the <li> in HTML inside the <ul> placeholder
         $("#container").append("<h1>" + parsed_data[0].contract_name + "</h1><p>" + parsed_data[0].contract_abc +"</p>");
         

           
        }
    });
    function getUrlVars()
    	{
        	var vars = [], hash;
        	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        	for(var i = 0; i < hashes.length; i++)
        		{
            		hash = hashes[i].split('=');
            		vars.push(hash[0]);
            		vars[hash[0]] = hash[1];
        		}
        	return vars;
    	}

});

    

   

    




















































