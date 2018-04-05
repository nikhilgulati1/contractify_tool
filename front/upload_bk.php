<!DOCTYPE html>
<html>

<head>
     <?php 
        
        session_start();
        if(! isset($_SESSION['logged_in'])){
            
            header("Location:login.html");
        }
    ?>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <link href="css/style.css" rel="stylesheet" type="text/css" />

</head>

<body>

    <div class="container-fluid">
        <div class="row heading">
            <div class="col-sm-10">
                <div class="logo"><img src="images/logo.png" /></div>
            </div>
            <div class="col-sm-2 ">
                <a id="link_1" href="index.php" class="btn btn-primary pull-right" role="button" aria-pressed="true">View All</a>
            </div>
        </div>
        
    </div>
          
        <div class="main-container">
       
        </div>
        <div class="row success-alert">
            <div class="col-sm-10">
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Well done!</h4>
                    <p>Contract has been successfully uploaded.</p>
                    <hr>
                    
                </div>
            </div>
            <div class="col-sm-2">
                <img class="img-fluid" src="images/tick.png" />
            </div>
        </div>    


        <form id="upload_contract" >
            <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <div class="form-sec entclint">
                      <div class="addnewbox">
                        <ul>
                        <li>
                        <label for="upload">Select</label>
                        <input type="file" id="contract_upload">
                        <input type="hidden" id="upload_con" name="upload_con" required>
                        <input type="hidden" id="upload_name" name = "upload_name">
                        
                        </li>
                       </ul>
                     </div>  
                    </div>
                    <input type="submit" id="submit" value="Upload" class="btn btn-primary">
                </div>
            </div>

            </div>
        </form>
        <div class="container-fluid">
        <div class="row">
            <div class = "col-sm-8 col-sm-offset-3">
                <div class = "gstn_client">
                    <ul class = "list">
                        
                    </ul>
                    
                </div>
            </div>
        </div>
        </div>

            




    <!-- Include JQuery - A JS library to make life easier -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

    <script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>

    <!-- Include our app.js file, this will contain the logic on frontend -->
    <script src="js/path.js"></script>
    <script src="js/upload.js"></script>

</body>

</html>