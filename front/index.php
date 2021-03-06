<!DOCTYPE html>
<html>
<head>
    <?php 
        
        session_start();
        if(! isset($_SESSION['logged_in'])){
            
            header("Location:login.html");
        }
    ?>
    
    <title>Contractify</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.css" />

</head>

<body id="index">

    <div class="container-fluid">
        <div class="row heading">
            <div class="col-sm-9">
                <div class="logo"><img src="images/logo.png" /></div>
            </div>
            <div class="col-sm-3">
                <a id="link_0" href="upload_bk.php" class="btn btn-primary align-middle" role="button" aria-pressed="true">Upload Contract</a>
                <a id="link_1" href="create_bk.php" class="btn btn-primary pull-right align-middle" role="button" aria-pressed="true">New Contract</a>
                <a id="link_2" href="login.html" class="btn btn-primary align-middle" role="button" aria-pressed="true">Logout</a>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 nopad">
                <div id="table_div"></div>
            </div>
        </div>
    </div>     
    


    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script src="js/path.js"></script>
    <script src="js/app.js"></script>
    

</body>
</html>
