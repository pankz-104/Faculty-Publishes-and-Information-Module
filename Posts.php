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
    <title>Posts</title>
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
                <a href="Profile.php" class= " nav-link"><i class="fas fa-user text-success"></i>My Profile</a>
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
              <h1> <i class = "fas fa-blog" style="color:#27aae1;"></i>Blog Posts</h1>
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
            <div class="col-lg-12">
              <?php
              echo ErrorMessage();
              echo SuccessMessage();
              ?>
              <table class="table table-striped table-hover">
                <thead class = "thead-dark">
                <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Cateory</th>
                  <th>Date&Time</th>
                  <th>Author</th>
                  <th>Banner</th>
                  <th>Comments</th>
                  <th>Action</th>
                  <th>Live Preview</th>
                </tr>
                </thead>
                <?php
                  global $ConnectingDB;
                  $sql = "SELECT * FROM posts";
                  $stmt = $ConnectingDB->query($sql);
                  $Sr = 0;
                  while($DataRows = $stmt->fetch()){
                    $Id        = $DataRows["id"];
                    $DateTime  = $DataRows["datetime"];
                    $PostTitle = $DataRows["title"];
                    $Category  = $DataRows["category"];
                    $Admin     = $DataRows["author"];
                    $Image     = $DataRows["image"];
                    $PostText  = $DataRows["post"];
                    $Sr++;
                 ?>
                <tbody>
                 <tr>
                   <td><?php echo $Sr; ?></td>
                   <td class="table-danger">
                          <?php
                                if (strlen($PostTitle)>20) { $PostTitle=substr($PostTitle,0,18).'..'; }
                                echo $PostTitle;
                          ?>
                  </td>
                   <td>
                         <?php
                                if (strlen($Category)>10) { $Category=substr($Category,0,10).'..'; }
                                echo $Category;
                          ?>
                    </td>
                   <td>
                         <?php
                                if (strlen($DateTime)>11) { $DateTime=substr($DateTime,0,11).'..'; }
                                echo $DateTime;
                          ?>
                    </td>
                   <td>
                         <?php
                                if (strlen($Admin)>6) { $Admin=substr($Admin,0,6).'..'; }
                                echo $Admin;
                          ?>
                    </td>
                   <td> <img src="Uploads/<?php echo $Image; ?>" width="170px;" height="50px"</td>
                   <td>
                     <!-- <span class="badge badge-danger"> -->
                     <?php
                        $Total = ApproveCommentsAccordingtoPost($Id);
                        if($Total>0){
                        ?>
                        <span class="badge badge-success">
                        <?php echo $Total;  ?>
                        <?php  } ?>
                        </span>
                    <?php
                        $Total = DisApproveCommentsAccordingtoPost($Id);
                       if($Total>0){
                       ?>
                       <span class="badge badge-dan">
                       <?php echo $Total;  ?>
                       <?php  } ?>
                       </span>
                   </td>
                   <td>
                     <a href="EditPost.php?id=<?php echo $Id;?>"> <span class="btn btn-warning">Edit</span> </a>
                     <a href="DeletePost.php?id=<?php echo $Id;?>"> <span class="btn btn-danger">Delete</span> </a>
                    </td>
                   <td> <a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank"> <span class="btn btn-primary">Live Preview</span></a> </td>
                 </tr>
               </tbody>
             <?php } ?>
              </table>
            </div>
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
