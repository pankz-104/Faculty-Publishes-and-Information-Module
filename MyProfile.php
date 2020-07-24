<?php require_once("includes/DB.php");?>
<?php require_once("includes/functions.php");?>
<?php require_once("includes/Session.php");?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<!--fetching the existing admin data-->
<?php
$AdminId = $_SESSION["User_Id"];
global $ConnectingDB;
$sql = "SELECT * FROM admins WHERE id='$AdminId'";
$stmt = $ConnectingDB->query($sql);
while($DataRows = $stmt->fetch())
{
  $ExistingName     = $DataRows["aname"];
//$ExistingUserName = $DataRows["username"];
  $ExistingHeadline = $DataRows["aheadline"];
  $ExistingBio      = $DataRows["abio"];
  $ExistingImage    = $DataRows["aimage"];
}
//fetching existing Admin data end
if(isset($_POST["Submit"]))
{
  $AName = $_POST["Name"];
  $AHeadline = $_POST["Headline"];
  $ABio = $_POST["Bio"];
  $Image = $_FILES["Image"]["name"];
  $Target = "Images/".basename($_FILES["Image"]["name"]);

  if(strlen($AHeadline)>12){
    $_SESSION["ErrorMessage"] = "Headline should be less than 12 character..";
    Redirect_to("MyProfile.php");
  }
  elseif(strlen($ABio)>999){
    $_SESSION["ErrorMessage"] = "Bio should be less than 1000 character..";
    Redirect_to("MyProfile.php");
  }
  else {
      // query to update admin data when everything is fine
      global $ConnectingDB;
      if(!empty($_FILES["Image"]["name"])){
        $sql = "UPDATE admins
                SET aname='$AName',aheadline='$AHeadline',abio='$ABio',image='$Image'
                WHERE id='$AdminId'";
      }
      else { // if image not posted by admin
        $sql = "UPDATE admins
                SET aname='$AName',aheadline='$AHeadline',abio='$ABio'
                WHERE id='$AdminId'";
      }
      $Execute = $ConnectingDB->query($sql);
      move_uploaded_file($_FILES["Image"]["tmps_name"],$Target);
      if($Execute){
      $_SESSION["SuccessMessage"]="Detais updated Suscessfully";
      Redirect_to("MyProfile.php");
      }
      else {
        $_SESSION["ErrorMessage"] = "Something went wrong..Try Again.!";
        Redirect_to("MyProfile.php");
      }
  }
}
// ending of submit button if condition
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/styles.css">
    <script src="https://kit.fontawesome.com/6208c9518e.js" crossorigin="anonymous"></script>
    <title>MyProfile</title>
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
                <a href="Comment.php" class= " nav-link">Comment</a>
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
              <h1> <i class = "fas fa-user text-success mr-2"></i> @<?php echo $ExistingUserName; ?></h1>
              <small><?php echo $ExistingHeadline; ?></small>
            </div>
          </div>
        </div>
      </header>

      <!-- End of header section -->
      <!-- Main Area -->

      <section class = "container py-2 mb-4">
         <div class="row">
           <!--Left Area -->
           <div class="col-md-3">
             <div class="card">
               <div class="card-header bg-dark text-light">
                 <h3> <?php echo $ExistingName; ?> </h3>
               </div>
               <div class="card-body">
                 <img src="Images/<?php echo $ExistingImage; ?>" class="block img-fluid mb-3" alt="">
                 <div class="">
                   Publishing is the activity of making information, literature, music, software and other content available to the public for sale or for free.
                   So we proceed to publish and keep upto date information for everyone about the college. In various ways its effective for the students, Guardians and
                   teachers with this medium of interaction.
                 </div>
               </div>

             </div>
           </div>
           <!-- Right Area-->
           <div class="col-md-9" style="min-height:500px;">
             <?php
             echo ErrorMessage();
             echo SuccessMessage();
             ?>
            <form class="" action="MyProfile.php" method="post" enctype="multipart/form-data"> <!--enctype for image to keep it in database-->
              <div class="card bg-dark text-light">
                <div class="card-header bg-secodary text-light ">
                  <h4>Edit Profile</h4>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <input class = "form-control" type="text" name="Name" id = "title" placeholder = "Your name">
                  </div>
                  <div class="form-group">
                    <input class = "form-control" type="text" name="Headline" id = "title" placeholder="Headline">
                    <small class="text-muted">Add a professional headline like, 'Engineer' at XYZ or 'Architect'</small>
                    <span class="text-danger"> Not more than 12 Characters</span>
                  </div>
                  <div class="form-group">
                    <textarea name="Bio" class="form-control" id="post" placeholder="Bio" rows="8" cols="80"></textarea>
                  </div>
                  <div class="form-group">
                    <div class="custom-file">
                      <input class="custom-file-input" type="File" name="Image" id="imageselect" value="">
                      <label for="imageSelect" class="custom-file-label">Select Image</label>
                    </div>
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
