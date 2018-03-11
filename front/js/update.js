$(document).ready(function() {
    $('#update').click(function(){
        $('#client_name').val("dfsl");
        //$("#client_name").val()
       // $("#client_name").val()
       // $("#client_name").val()
       // $("#client_name").val()
       // $("#client_name").val()

    });

$('#update_contract').submit(function(event) {
  event.preventDefault();
  console.log(objectifyForm($("#update_contract").serializeArray()));
  var dataFromForm = objectifyForm($("#update_contract").serializeArray());
  console.log(dataFromForm);
   

  $.ajax({
      url: "./../back/api/contract/update_contract_info.php",
      data: {dataFroomForm,'id': id},
      type: "post",
      success: function(data) {         
          console.log(data);
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
}); // end submit