<?php require_once("includes/DB.php");?>
<?php require_once("includes/functions.php");?>
<?php require_once("includes/Session.php");?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
//echo $_SESSION["TrackingURL"];
 Confirm_Login(); ?>

<?php
if(isset($_POST["Submit"]))
{
  $Category = $_POST["CategoryTitle"];
  $Admin = $_SESSION["Username"];
  date_default_timezone_set("Asia/kathmandu");
  $CurrentTime=time();
  $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

  if(empty($Category)){
    $_SESSION["ErrorMessage"] = "All fields must be filled...";
    Redirect_to("categories.php");
  }
  elseif(strlen($Category)<3){
    $_SESSION["ErrorMessage"] = "Category title should be greater than  character..";
    Redirect_to("categories.php");
  }
  elseif(strlen($Category)>49){
    $_SESSION["ErrorMessage"] = "Category title should be less than 100 character..";
    Redirect_to("categories.php");
  }
  else {
      // query to insert data
      global $ConnectingDB;
      $sql = "INSERT INTO category(title,author,datetime)";
      $sql .= "VALUES(:categoryName,:adminName,:datetime)";
      $stmt = $ConnectingDB->prepare($sql);
      $stmt->bindvalue(':categoryName',$Category);
      $stmt->bindvalue(':adminName',$Admin);
      $stmt->bindvalue('datetime',$DateTime);
      $Execute = $stmt->execute();

      if($Execute){
        $_SESSION["SuccessMessage"]="Category with id ".$ConnectingDB->lastInsertId()." Added Suscessfully";
        Redirect_to("Categories.php");
      }
      else {
        $_SESSION["ErrorMessage"] = "Something went wrong..Try Again";
        Redirect_to("categories.php");
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
    <title>Categories</title>
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
                <a href="Profile.php" class= " nav-link"><i class="fas fa-user"></i>  My Profile</a>
              <li class = "nav-item"></li>
                <a href="Dashboard.php" class= " nav-link">DashBoard</a>
              <li class = "nav-item"></li>
                <a href="Posts.php" class= " nav-link">Posts</a>
              <li class = "nav-item"></li>
                <a href="Category.php" class= " nav-link">Category</a>
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
              <h1> <i class = "fas fa-edit" style="color:#27aae1;"></i> Manage Categories</h1>
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
            <form class="" action="categories.php" method="post">
              <div class="card bg-secondary text-light mb-3">
                <div class="card-header">
                  <h1>Add New Category</h1>
                </div>
                <div class="card-body bg-dark text-white">
                  <div class="form-group">
                    <label for="title"><span class = "FieldInfo">Category Title :</span> </label>
                    <input class = "form-control" type="text" name="CategoryTitle" value="" id = "title" placeholder = "Type_title_here">
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
            <h2>Existing Categories</h2>
            <table class="table table-striped table-hover">
              <thead class="thead-dark">
                <tr>
                  <th>No. </th>
                  <th>Date&Time</th>
                  <th>Category Name</th>
                  <th>Creator Name</th>
                  <th>Action</th>
                </tr>
              </thead>
            <?php
              global $ConnectingDB;
            $sql = "SELECT * FROM category ORDER BY id desc";
            $Execute = $ConnectingDB->query($sql);
            $SrNo = 0;
            while($DataRows = $Execute->fetch())
            {
              $CategoryId      = $DataRows["id"];
              $CategoryDate    = $DataRows["datetime"];
              $CategoryName    = $DataRows["title"];
              $CreatorName     = $DataRows["author"];
              $SrNo++;
            //  if(strlen($CommenterName)>10) { $CommenterName = substr($CommenterName,0,10).'..';}
              //if(strlen($DateTimeOfComment)>10) { $DateTimeOfComment = substr($DateTimeOfComment,0,10).'..';}
             ?>
             <tbody>
               <tr>
                 <td> <?php echo htmlentities($SrNo);         ?> </td>
                 <td> <?php echo htmlentities($CategoryDate); ?> </td>
                 <td> <?php echo htmlentities($CategoryName); ?> </td>
                 <td> <?php echo htmlentities($CreatorName);  ?> </td>
                 <td style="width:140px"> <a href="DeleteCategory.php?id=<?php echo $CategoryId; ?>" class="btn btn-danger">Delete</a></td>
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
