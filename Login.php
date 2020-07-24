<?php require_once("includes/DB.php");?>
<?php require_once("includes/functions.php");?>
<?php require_once("includes/Session.php");?>
<?php
if(isset($_SESSION["User_Id"])){
  Redirect_to("Dashboard.php");
}
if(isset($_POST["Submit"])){
  $UserName = $_POST["Username"];
  $Password = $_POST["Password"];
  if(empty($UserName)||empty($Password)){
      $_SESSION["ErrorMessage"] = "All fields must be filled out ..!!";
      Redirect_to("Login.php");
  }
  else {
    $Found_Account = Login_Attempt($UserName,$Password);
    if($Found_Account){
      $_SESSION["User_Id"]=$Found_Account["id"];
      $_SESSION["Username"]=$Found_Account["username"];
      $_SESSION["AdminName"]=$Found_Account["aname"];
      $_SESSION["SuccessMessage"] = "Welcome ".$_SESSION["Username"];
      if(isset($_SESSION["TrackingURL"])){
        Redirect_to($_SESSION["TrackingURL"]);
      }else {
      Redirect_to("DashBoard.php");
    }
    }else {
      $_SESSION["ErrorMessage"] = "Incorrect Username/Password";
      Redirect_to("Login.php");
    }
  }
}

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="stylesheet" href="CSS/all.min.css">
    <title>Login Page</title>
  </head>
  <body background>
      <!-- NAVBAR -->
      <div style="height:10px; background:#27aae1;"></div>
      <nav class = "navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand"> Pankaj.com </a>
            <!-- bar button.......... data-target = javascript functionality -->
            <button class = "navbar-toggler" data-toggle = "collapse" data-target = "#navbarcollapseCMS" type="button" name="button">
              <span class = "navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse" id="navbarcollapseCMS">
              <!-- ID navbarcollapseCMS includes entire div tag -->
            <ul class = "navbar-nav ml-auto">
              <li class = "nav-item"> <a href="Logout.php" class = "nav-link text-danger"><i class="fas fa-user-times"></i> Logout</a> </li>
            </ul>
          </div>
        </div>
      </nav>
     <div style="height:10px; background:#27aae1;"></div>
      <!--navabr end-->
      <br>
      <!-- Header section -->
      <header class = "bg-dark text-white py-3">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
            </div>
          </div>
        </div>
      </header>

      <!-- End of header section -->
      <br>
      <!-- Main Area start -->
      <section class="container py-2 mb-4">
        <div class="row">
          <div class="offset-sm-3 col-sm-6" style="min-height:500px;">
            <br><br><br>
            <?php
              echo ErrorMessage();
              echo SuccessMessage();
             ?>
            <div class="card bg-secondary text-light">
              <div class="card-header">
                <h4>Welcome Back !</h4>
                  </div>
                <div class="card-body bg-dark">

                <form class="" action="Login.php" method="post">
                  <div class="form-group">
                    <label for="username"> <span class="FieldInfo">Username :</span> </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text text-white bg-info"> <i class="fas fa-user"></i> </span>
                      </div>
                      <input type="text" class="form-control" name="Username" id="username" value="">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="password"> <span class="FieldInfo">Password :</span></label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text text-white bg-info"> <i class="fas fa-lock"></i> </span>
                      </div>
                      <input type="password" class="form-control" name="Password" id="password" value="">
                    </div>
                  </div>
                  <input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">
                </form>
              </div>
            </div>
          </div>

        </div>
      </section>
      <!-- Main Area End -->
      <!--footer Here -->
      <footer class = "bg-dark text-white">
        <div class="container">
          <div class="row">
            <div class="col">
            <p class = "lead text-center"> Theme By | Pankaj Pandey | <span id="year"></span> &copy; ---ALL Rights Reserved.</p>
            <p class = "text-center small"> <a style = "color :white; text-decoration: none; cursor : pointer;" href="#"></a>
              This site is for purpose to provide information in regard to workshops being conducted at
              Dr.Ambedkar Institute Of Technology
             </p>
            </div>
          </div>
        </div>
      </footer>
      <div style="height:10px; background:#27aae1;"></div>
      <!-- end of footer -->



    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script type="text/javascript">
      $('#year').text(new Date().getFullYear());
    </script>

  </body>
</html>
