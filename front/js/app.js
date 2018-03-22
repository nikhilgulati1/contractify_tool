$(document).ready(function () {


    google.charts.load('current', { 'packages': ['table'] });
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
                console.log(parsed_data);
                parsed_data.forEach(element => {
                    if (element.contract_type == 1) {
                        con_type = "Digital Marketing";
                    } else if (element.contract_type == 2) {
                        con_type = "Technical;"
                    } else {
                        con_type = "Digital Marketing and Technical"
                    }

                    gridData.addRow(
                        [   
                            element.contract_id,
                            element.contract_name,
                            con_type,
                            element.contract_start_date,
                            element.contract_end_date,
                            element.client_email_address,
                            element.contract_status,

                            "<img src= './images/udate-icon.png' class ='update' href='./view_detail.html?id=" + element.contract_id + "'/><img src= './images/view.png' class = 'view' href = './read.html?id=" + element.contract_id + "'/><img src= './images/pdf-download.png' class='download' href='./../back/generated/contracts/dd_c" + element.contract_id + ".pdf'/><img src = './images/remove.png' class ='del' href ='#' onClick='recp("+element.contract_id+")'/>"
                        ]
                    );

                });
                drawTable();
            }
        });
     
    }
   
    function loadTableSchema() {
        gridData = new google.visualization.DataTable();
        gridData.addColumn('string', 'S.No.');
        gridData.addColumn('string', 'Contract Name');
        gridData.addColumn('string', 'Contract Type');
        gridData.addColumn('string', 'Start Date');
        gridData.addColumn('string', 'End Date');
        gridData.addColumn('string', 'Contact email');
        gridData.addColumn('string', 'Contract Status');
        gridData.addColumn('string', 'Action');

        startWork();

    }

    function drawTable() {
        var table = new google.visualization.Table(document.getElementById('table_div'));
        table.draw(gridData, {width: '100%', height: '100%', allowHtml: true, cssClassNames: { headerRow: 'grid_headerRow', tableRow: 'grid_tableRow', headerCell: 'grid_headerCell', tableCell: 'grid_tableCell' } });
    };

});

function recp(id){
        $.ajax({
        url: "./../back/api/contract/delete.php",
            type: "post",
            data: {id:id},
            success: function (data) {
                $('.del').click(function() {
                    window.location.reload(true);
                });
            }
        });    
    
    }

