$(document).ready(function () {

    google.charts.load('current', {'packages':['table']});
    google.charts.setOnLoadCallback(loadTableSchema);

    var gridData = null;

    function startWork() {
         $.ajax({
            url: "./../back/api/contract/read_all.php",  
            type: "get",                                                           
            data: {},                                                               
            success: function (data) {   
                var con_type = null;
                var parsed_data = JSON.parse(data);
                parsed_data.forEach(element => {
                    if(element.contract_type==1){
                         con_type = "Digital Marketing";
                    }
                    else if(element.contract_type == 2){
                         con_type = "Technical;"
                    }
                    else{
                        con_type = "Digital Marketing and Technical"
                    }
                    console.log(typeof element.contract_type);
                    gridData.addRow([element.contract_name,
                        con_type,
                        element.contract_start_date,
                        element.contract_end_date,
                        element.client_email_address
                    ]);    
                });
                drawTable();
            }
        });
    }

    function loadTableSchema() {

        gridData = new google.visualization.DataTable();
        gridData.addColumn('string', 'Contract Name');
        gridData.addColumn('string', 'Contract Type');
        gridData.addColumn('string', 'Start Date');
        gridData.addColumn('string', 'End Date');
        gridData.addColumn('string', 'Contact email');
        startWork();

    }

    function drawTable() {

        var table = new google.visualization.Table(document.getElementById('table_div'));
        table.draw(gridData, {showRowNumber: true, width: '100%', height: '100%'});

    };

});


