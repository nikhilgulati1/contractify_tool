<!DOCTYPE html>
<html>

<head>
     <?php 
        
        session_start();
        if(! isset($_SESSION['logged_in'])){
            
            header("Location:login.html");
        }
    ?>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="assets/css/paper-dashboard.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/style.css" />

    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/themify-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <link href="css/style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div class="wrapper">

          
    <div class="container-fluid create">
        <div class="sidebar" data-background-color="white" data-active-color="danger">
                <div class="sidebar-wrapper">
                    <div class="logo">

                    </div>

                    <ul class="nav">
                        <li>
                            <a href="dashboard.php">
                                <i class="ti-panel"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li >
                            <a href="create.php">
                               <i class="ti-user"></i>
                               <p>Create Contract</p>
                            </a>
                        </li>
                        <li class="active">
                            <a href="upload.php">
                               <i class="ti-cloud-up"></i>
                               <p>Upload</p>
                            </a>
                        </li>
                        <li>
                            <a href="services.php">
                               <i class="ti-check-box"></i>
                               <p>Select Services</p>
                            </a>
                        </li>
                        <!-- <li>
                            <a href="index.php">
                               <i class="ti-pencil-alt2"></i>
                               <p>View Grid</p>
                            </a>
                        </li> -->
                <!-- <li>
                    <a href="maps.html">
                        <i class="ti-map"></i>
                        <p>Maps</p>
                    </a>
                </li> -->
                        <li>
                            <a href="login.html">
                               <i class="ti-power-off"></i>
                               <p>Logout</p>
                            </a>
                        </li>
                <!-- <li class="active-pro">
                    <a href="upgrade.html">
                        <i class="ti-export"></i>
                        <p>Upgrade to PRO</p>
                    </a>
                </li> -->
                    </ul>
                </div>
            
        </div>
    </div>  
    <div class="main-panel">  
        <div class="main-container">
            <div class="row sub-heading">
                <div class="col-sm-9">
                    <h2>Upload Contract</h2>
                </div>
            </div>
            <div class="row success-alert">
                <div class="col-sm-10">
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Well done!</h4>
                        <p>Contract has been successfully Uploaded.</p>
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
    </div>
        <footer class="footer">
                <div class="container-fluid">
                    <nav class="pull-left">
                    <!-- <ul>

                        <li>
                            <a href="http://www.creative-tim.com">
                                Creative Tim
                            </a>
                        </li>
                        <li>
                            <a href="http://blog.creative-tim.com">
                               Blog
                            </a>
                        </li>
                        <li>
                            <a href="http://www.creative-tim.com/license">
                                Licenses
                            </a>
                        </li>
                    </ul> -->
                    </nav>
                    <div class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script> by <a href="http://www.dignitasdigital.com/">Dignitas Digital</a>
                    </div>
                </div>
        </footer>
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