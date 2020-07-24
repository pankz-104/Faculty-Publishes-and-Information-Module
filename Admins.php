<?php require_once("includes/DB.php");?>
<?php require_once("includes/functions.php");?>
<?php require_once("includes/Session.php");?>
<?php $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>

<?php
if(isset($_POST["Submit"]))
{
  $UserName        = $_POST["UserName"];
  $Name            = $_POST["Name"];
  $Password        = $_POST["Password"];
  $ConfirmPassword = $_POST["ConfirmPassword"];
  $Admin = $_SESSION["Username"];
  date_default_timezone_set("Asia/kathmandu");
  $CurrentTime=time();
  $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

  if(empty($UserName)||empty($Password)||empty($ConfirmPassword)){
    $_SESSION["ErrorMessage"] = "All fields must be filled...";
    Redirect_to("Admins.php");
  }
  elseif(strlen($Password)<4){
    $_SESSION["ErrorMessage"] = "Password should be greater than 4 character..";
    Redirect_to("Admins.php");
  }
  elseif($Password !== $ConfirmPassword){
    $_SESSION["ErrorMessage"] = "Password and confirm password should match..";
    Redirect_to("Admins.php");
  }
  elseif(CheckUserNameExistsOrNot($UserName)){
    $_SESSION["ErrorMessage"]="Username Exists. Try Another one..";
  }
  else {
      // query to insert new admin in db if everything is fine
      global $ConnectingDB;
      $sql = "INSERT INTO admins(datetime,username,password,aname,addedby)";
      $sql .= "VALUES(:dateTime,:userName,:password,:aName,:adminName)";
      $stmt = $ConnectingDB->prepare($sql);
      $stmt->bindvalue(':dateTime',$DateTime);
      $stmt->bindvalue(':userName',$UserName);
      $stmt->bindvalue(':password',$Password);
      $stmt->bindvalue(':aName',$Name);
      $stmt->bindvalue(':adminName',$Admin);
      $Execute = $stmt->execute();

      if($Execute){
        $_SESSION["SuccessMessage"]="New Admin with the name of ".$Name." added suscessfully";
        Redirect_to("Admins.php");
      }
      else {
        $_SESSION["ErrorMessage"] = "Something went wrong..Try Again";
        Redirect_to("Admins.php");
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
    <script src="https://kit.fontawesome.com/6208c9518e.js" crossorigin="anonymous"></script>
    <title>Admin page</title>
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
            <ul class = "navbar-nav mr-auto">
              <li class = "nav-item"></li>
                <a href="MyProfile.php" class= " nav-link"><i class="fas fa-user"></i>  My Profile</a>
              <li class = "nav-item"></li>
                <a href="Dashboard.php" class= " nav-link">DashBoard</a>
              <li class = "nav-item"></li>
                <a href="Posts.php" class= " nav-link">Posts</a>
              <li class = "nav-item"></li>
                <a href="Categories.php" class= " nav-link">Category</a>
              <li class = "nav-item"></li>
                <a href="Admins.php" class= " nav-link">Manage Admins</a>
              <li class = "nav-item"></li>
                <a href="Comments.php" class= " nav-link">Comment</a>
              <li class = "nav-item"></li>
                <a href="Blog.php" class= " nav-link">Live Blog</a>
            </ul>
            <ul class = "navbar-nav ml-auto">
              <li class = "nav-item"> <a href="Logout.php" class = "nav-link text-danger"><i class="fas fa-user-times"></i>Logout</a> </li>
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
              <h1> <i class = "fas fa-user" style="color:#27aae1;"></i> Manage Admins</h1>
            </div>
          </div>
        </div>
      </header>

      <!-- End of header section -->
      <!-- Main Area -->

      <section class = "container py-2 mb-4">
         <div class="row">
           <div class="offset-lg-1 col-lg-10" style="min-height:500px;">
             <?php
             echo ErrorMessage();
             echo SuccessMessage();
             ?>
            <form class="" action="Admins.php" method="post">
              <div class="card bg-secondary text-light mb-3">
                <div class="card-header">
                  <h1>Add New Admin</h1>
                </div>
                <div class="card-body bg-dark text-white">
                  <div class="form-group">
                    <label for="title"><span class = "FieldInfo">Username :</span> </label>
                    <input class = "form-control" type="text" name="UserName" id="username">
                  </div>
                  <div class="form-group">
                    <label for="title"><span class = "FieldInfo">Name :</span> </label>
                    <input class = "form-control" type="text" name="Name" id="name">
                    <small class="text-warning text-muted">Optional</small>
                  </div>
                  <div class="form-group">
                    <label for="title"><span class = "FieldInfo">Password :</span> </label>
                    <input class="form-control" type="password" name="Password" id="password">
                  </div>
                  <div class="form-group">
                    <label for="title"><span class = "FieldInfo">Coinform Passsword :</span> </label>
                    <input class="form-control" type="password" name="ConfirmPassword" id="confirmpassword">
                  </div>
                  <div class="row">
                    <div class="col-lg-6 mb-2">
                      <a href="Dashboard.php" class = "btn btn-warning btn-block"> <i class = "fas fa-arrow-left"></i> Back To Dashboard</a>
                    </div>
                    <div class="col-lg-6 mb-2">
                      <button type="submit" name="Submit" class = "btn btn-success btn-block">  <i class = "fas fa-check"></i> Publish</button>

                    </div>
                  </div>
                </div>
              </div>
            </form>
            <h2>Existing Admins</h2>
            <table class="table table-striped table-hover">
              <thead class="thead-dark">
                <tr>
                  <th>No. </th>
                  <th>Date&Time</th>
                  <th>Username</th>
                  <th>Admin Name</th>
                  <th>Added By</th>
                  <th>Action</th>
                </tr>
              </thead>
            <?php
              global $ConnectingDB;
            $sql = "SELECT * FROM admins ORDER BY id desc";
            $Execute = $ConnectingDB->query($sql);
            $SrNo = 0;
            while($DataRows = $Execute->fetch())
            {
              $AdminId        = $DataRows["id"];
              $DateTime       = $DataRows["datetime"];
              $AdminUserName  = $DataRows["username"];
              $AdminName      = $DataRows["aname"];
              $AddedBy        = $DataRows["addedby"];
              $SrNo++;
            //  if(strlen($CommenterName)>10) { $CommenterName = substr($CommenterName,0,10).'..';}
              //if(strlen($DateTimeOfComment)>10) { $DateTimeOfComment = substr($DateTimeOfComment,0,10).'..';}
             ?>
             <tbody>
               <tr>
                 <td> <?php echo htmlentities($SrNo); ?></td>
                 <td> <?php echo htmlentities($DateTime); ?></td>
                 <td> <?php echo htmlentities($AdminUserName); ?></td>
                 <td> <?php echo htmlentities($AdminName); ?></td>
                 <td> <?php echo htmlentities($AddedBy); ?></td>
                 <td> <a href="DeleteAdmin.php?id=<?php echo $AdminId; ?>" class="btn btn-danger">Delete</a></td>
               </tr>
             </tbody>
           <?php } ?>
         </table>
           </div>
         </div>
      </section>

      <!-- End of Main Area -->
      <!--footer Here -->

      <div style="height:10px; background:#27aae1;"></div>
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
