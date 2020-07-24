<?php require_once("includes/DB.php");?>
<?php require_once("includes/functions.php");?>
<?php require_once("includes/Session.php");?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
//echo $_SESSION["TrackingURL"];
Confirm_Login(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="stylesheet" href="CSS/all.min.css">
    <title>Dashboard</title>
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
                <a href="MyProfile.php" class= " nav-link"><i class="fas fa-user text-success"></i>My Profile</a>
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
              <h1> <i class = "fas fa-cog" style="color:#27aae1;"></i>Dashboard</h1>
            </div>
            <div class="col-lg-3 mb-2">
              <a href="AddNewPost.php" class="btn btn-primary btn-block">Add New Post</a>
              <i class="fas-fa-edit"></i>
            </div>
            <div class="col-lg-3 mb-2">
              <a href="Categories.php" class="btn btn-info btn-block">Add New Category</a>
              <i class="fas-fa-folder-plus"></i>
            </div>
            <div class="col-lg-3 mb-2">
              <a href="Admins.php" class="btn btn-warning btn-block">Add New Admin</a>
              <i class="fas-fa-user-plus"></i>
            </div>
            <div class="col-lg-3 mb-2">
              <a href="Comments.php" class="btn btn-success btn-block">Approve Comments</a>
              <i class="fas-fa-check"></i>
            </div>
          </div>
        </div>
      </header>

      <!-- End of header section -->
      <!-- Main area -->
        <section class = "container py-2 mb-4">
          <div class="row">
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <br><br><br><br>
            <!-- left side area part -->
            <div class="col-lg-2">
              <div class="card text-center bg-dark text-white mb-3">
                <div class="card-body">
                  <h1 class="lead">Posts</h1>
                  <h4 class="display-5"></h4>
                  <i class="fab fa-readme"></i>
                  <?php TotalPosts(); ?>
                </div>
              </div>
              <div class="card text-center bg-dark text-white mb-3">
                <div class="card-body">
                  <h1 class="lead">Categories</h1>
                  <h4 class="display-5"></h4>
                  <i class="fab fa-folder"></i>
                  <?php TotalCategories();       ?>
                </div>
              </div>
              <div class="card text-center bg-dark text-white mb-3">
                <div class="card-body">
                  <h1 class="lead">Admins</h1>
                  <h4 class="display-5"></h4>
                  <i class="fas fa-users"></i>
                  <?php  TotalAdmins(); ?>
                </div>
              </div>
              <div class="card text-center bg-dark text-white mb-3">
                <div class="card-body">
                  <h1 class="lead">comments</h1>
                  <h4 class="display-5"></h4>
                  <i class="fas fa-comments"></i>
                  <?php TotalComments(); ?>
                </div>
              </div>
            </div>
            <!-- left side area part end -->
            <!-- Right side area part start -->
              <div class="col-lg-10">
                <h1>Top Posts</h1>
                <table class="table table-striped table-hover">
                  <thead class="thead-dark">
                    <tr>
                      <th>No.</th>
                      <th>Title</th>
                      <th>Date&Time</th>
                      <th>Author</th>
                      <th>Comment</th>
                      <th>Details</th>
                    </tr>
                  </thead>
                  <?php
                    $SrNo = 0;
                    global $ConnectingDB;
                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                    $stmt = $ConnectingDB->query($sql);
                    while($DataRows=$stmt->fetch())
                    {
                      $PostId    = $DataRows["id"];
                      $DateTime  = $DataRows["datetime"];
                      $Author    = $DataRows["author"];
                      $Title     = $DataRows["title"];
                      $SrNo++;
                   ?>
                   <tbody>
                     <tr>
                       <td> <?php echo htmlentities($SrNo);     ?>  </td>
                       <td> <?php echo htmlentities($Title);    ?>  </td>
                       <td> <?php echo htmlentities($DateTime); ?>  </td>
                       <td> <?php echo htmlentities($Author);   ?>  </td>
                       <td>
                         <!-- <span class="badge badge-danger"> -->
                         <?php
                            $Total = ApproveCommentsAccordingtoPost($PostId);
                            if($Total>0){
                            ?>
                            <span class="badge badge-success">
                            <?php echo $Total;  ?>
                            <?php  } ?>
                            </span>
                        <?php
                            $Total = DisApproveCommentsAccordingtoPost($PostId);
                           if($Total>0){
                           ?>
                           <span class="badge badge-dan">
                           <?php echo $Total;  ?>
                           <?php  } ?>
                           </span>
                       </td>
                       <td> <a target="_blank" href="FullPost.php?id=<?php echo $PostId; ?>">
                         <span class="btn btn-info">Preview</span>
                       </a> </td>
                     </tr>
                   </tbody>
                 <?php } ?>
                </table>
              </div>
            <!-- Right side area part end -->
          </div>
        </section>

      <!--End of main area -->
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
