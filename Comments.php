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
    <title>Comments</title>
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
                <a href="Profile.php" class= " nav-link"><i class="fas fa-user text-success"></i>  My Profile</a>
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
              <h1> <i class = "fas fa-comments"></i>Manage comments</h1>
            </div>
          </div>
        </div>
      </header>

      <!-- End of header section -->
      <br>
      <section class="container py-2 mb-4">
        <div class="row" style="min-height:30px;">
          <div class="col-lg-12" style="min-height:400px;">
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <h2>Un-Approved Comments</h2>
            <table class="table table-striped table-hover">
              <thead class="thead-dark">
                <tr>
                  <th>No. </th>
                  <th>Date&Time</th>
                  <th>Name</th>
                  <th>Comment</th>
                  <th>Aprove</th>
                  <th>Action</th>
                  <th>Details</th>
                </tr>
              </thead>
            <?php
              global $ConnectingDB;
            $sql = "SELECT * FROM comments WHERE status='off' ORDER BY id desc";
            $Execute = $ConnectingDB->query($sql);
            $SrNo = 0;
            while($DataRows = $Execute->fetch())
            {
              $CommentId         = $DataRows["id"];
              $DateTimeOfComment = $DataRows["datetime"];
              $CommenterName     = $DataRows["name"];
              $CommentContent    = $DataRows["comment"];
              $CommentPostId     = $DataRows["post_id"];
              $SrNo++;
            //  if(strlen($CommenterName)>10) { $CommenterName = substr($CommenterName,0,10).'..';}
              //if(strlen($DateTimeOfComment)>10) { $DateTimeOfComment = substr($DateTimeOfComment,0,10).'..';}
             ?>
             <tbody>
               <tr>
                 <td> <?php echo htmlentities($SrNo); ?></td>
                 <td> <?php echo htmlentities($DateTimeOfComment); ?></td>
                 <td> <?php echo htmlentities($CommenterName); ?></td>
                 <td> <?php echo htmlentities($CommentContent); ?></td>
                 <td> <a href="ApproveComment.php?id=<?php echo $CommentId; ?>" class="btn btn-success">Approve</a></td>
                 <td> <a href="DeleteComment.php?id=<?php echo $CommentId; ?>" class="btn btn-danger">Delete</a></td>
                 <td style="width:140px"> <a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live Preview</a> </td>
               </tr>
             </tbody>
           <?php } ?>
         </table>
         <h2>Approved Comments</h2>
         <table class="table table-striped table-hover">
           <thead class="thead-dark">
             <tr>
               <th>No. </th>
               <th>Date&Time</th>
               <th>Name</th>
               <th>Comment</th>
               <th>Revert</th>
               <th>Action</th>
               <th>Details</th>
             </tr>
           </thead>
         <?php
           global $ConnectingDB;
         $sql = "SELECT * FROM comments WHERE status='oon' ORDER BY id desc";
         $Execute = $ConnectingDB->query($sql);
         $SrNo = 0;
         while($DataRows = $Execute->fetch())
         {
           $CommentId         = $DataRows["id"];
           $DateTimeOfComment = $DataRows["datetime"];
           $CommenterName     = $DataRows["name"];
           $CommentContent    = $DataRows["comment"];
           $CommentPostId     = $DataRows["post_id"];
           $SrNo++;
         //  if(strlen($CommenterName)>10) { $CommenterName = substr($CommenterName,0,10).'..';}
           //if(strlen($DateTimeOfComment)>10) { $DateTimeOfComment = substr($DateTimeOfComment,0,10).'..';}
          ?>
          <tbody>
            <tr>
              <td> <?php echo htmlentities($SrNo); ?></td>
              <td> <?php echo htmlentities($DateTimeOfComment); ?></td>
              <td> <?php echo htmlentities($CommenterName); ?></td>
              <td> <?php echo htmlentities($CommentContent); ?></td>
              <td style="width:140px"> <a href="DisApproveComment.php?id=<?php echo $CommentId; ?>" class="btn btn-warning">DisApprove</a></td>
              <td style="width:140px"> <a href="DeleteComment.php?id=<?php echo $CommentId; ?>" class="btn btn-danger">Delete</a></td>
              <td style="width:140px"> <a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live Preview</a> </td>
            </tr>
          </tbody>
        <?php } ?>
      </table>
          </div>

        </div>
      </section>
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
