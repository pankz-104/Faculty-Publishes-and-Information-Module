<?php require_once("includes/DB.php");?>
<?php require_once("includes/functions.php");?>
<?php require_once("includes/Session.php");?>
<?php $SearchQueryParameter = $_GET["id"]; ?>
<?php
if(isset($_POST["Submit"]))
{
  $Name = $_POST["CommenterName"];
  $Email = $_POST["CommenterEmail"];
  $Comment = $_POST["CommenterThoughts"];
  date_default_timezone_set("Asia/kathmandu");
  $CurrentTime=time();
  $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

  if(empty($Name)||empty($Email)||empty($Comment)){
    $_SESSION["ErrorMessage"] = "All fields must be filled";
    Redirect_to("FullPost.php?id=$SearchQueryParameter");
  }
  elseif(strlen($Comment)>1000){
    $_SESSION["ErrorMessage"] = "Comment length should be less than 1000 characters..!!";
    Redirect_to("FullPost.php?id=$SearchQueryParameter");
  }
  else {
      // query to insert comment in DB when everything is fine
      global $ConnectingDB;
      $sql = "INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id)";
      $sql .= "VALUES(:datetime,:name,:email,:comment,'pending','off',:postIdFromURl)";
      $stmt = $ConnectingDB->prepare($sql);
      $stmt->bindvalue(':datetime',$DateTime);
      $stmt->bindvalue(':name',$Name);
      $stmt->bindvalue(':email',$Email);
      $stmt->bindvalue(':comment',$Comment);
      $stmt->bindvalue(':postIdFromURL',$SearchQueryParameter);
      $Execute = $stmt->execute();

      if($Execute){
        $_SESSION["SuccessMessage"]="Comment submitted Suscessfully";
        Redirect_to("FullPost.php?id=$SearchQueryParameter");
      }
      else {
        $_SESSION["ErrorMessage"] = "Something went wrong..Try Again";
        Redirect_to("FullPost.php?id=$SearchQueryParameter");
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
    <title>Blog Page</title>
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
                <a href="Blog.php" class= " nav-link">Home</a>
              <li class = "nav-item"></li>
                <a href="" class= " nav-link">About us</a>
              <li class = "nav-item"></li>
                <a href="Blog.php" class= " nav-link">Blog</a>
              <li class = "nav-item"></li>
                <a href="#" class= " nav-link">Contact us</a>
              <li class = "nav-item"></li>
                <a href="#" class= " nav-link">Features</a>
            </ul>
            <ul class = "navbar-nav ml-auto">
              <form class="form-inline d-none d-sm-block" action="Blog.php">
                <div class="form-group">
                <input class="form-control mr-2" type="text" name="Search" placeholder="Search_Here">
                <button type="submit" class="btn btn-primary" name="SearchButton">Go</button>0
                </div>
              </form>
            </ul>
          </div>
        </div>
      </nav>
     <div style="height:10px; background:#27aae1;"></div>
      <!--navabar end-->
      <br>
      <!-- Header section -->
      <div class="container">
        <div class="row mt-4">

          <!-- Main Area start-->
          <div class="col-sm-8">
              <h1>The complete resopnsive CMS blog</h1>
              <h1 class = "lead">The complete blog using PHP by Pankaj Pandey</h1>
              <!-- Search Button function -->
              <?php
                echo ErrorMessage();
                echo SuccessMessage();
               ?>
              <?php
              global $ConnectingDB;
              if(isset($_GET["SearchButton"])){
                  $Search = $_GET["Search"];
                  $sql = "SELECT * FROM posts
                  WHERE datetime LIKE :search
                  OR title LIKE :search
                  OR categpry LIKE :search
                  OR post LIKE :search";
                  $stmt = $ConnectingDB->prepare($sql);
                  $stmt->bindvalue(':search','%'.$Search.'%');
                  $stmt->execute();
              }
              //the default sql query
              else {
                $PostIdFromURl = $_GET["id"];
                if(!isset($PostIdFromURl)){
                  $_SESSION["ErrorMessage"] = "Bad Request.!";
                  Redirect_to("Blog.php");
                }
                  $sql = "SELECT * FROM posts WHERE id='$PostIdFromURl'";
                  $stmt = $ConnectingDB->query($sql);
              }
                while($DataRows=$stmt->fetch())
                {
                  $PostId          = $DataRows["id"];
                  $DateTime        = $DataRows["datetime"];
                  $PostTitle       = $DataRows["title"];
                  $Category        = $DataRows["category"];
                  $Admin           = $DataRows["author"];
                  $Image           = $DataRows["image"];
                  $postDescription = $DataRows["post"];
               ?>
               <div class="card">
                 <img src="Uploads/<?php echo htmlentities($Image); ?>" style="max-height:450px;" class="img-fluid card-img-top"/>
                 <div class="card-body">
                   <h4 class="card-title"> <?php echo htmlentities($PostTitle); ?></h4>
                   <small class="text-muted">Category: <span class="text-dark"><?php echo htmlentities($Category); ?></span> & Written By <span class="text-dark"><?php echo htmlentities($Admin); ?></span> On <?php echo $DateTime; ?>  </small>
                   <hr>
                   <p class="card-text">
                      <?php echo htmlentities($postDescription); ?>
                   </p>
                 </div>
               </div>
             <?php } ?>
             <!--comment part start from here-->
             <!--fetching existing comment start-->
               <span class="FieldInfo">Comments</span>
               <br>
               <br>
             <?php
                global $ConnectingDB;
                $sql = "SELECT * FROM comments
                WHERE post_id='$SearchQueryParameter' AND status='on' ";
                $stmt = $ConnectingDB->query($sql);
                while($DataRows=$stmt->fetch())
                {
                  $CommentDate = $DataRows['datetime'];
                  $CommenterName = $DataRows['name'];
                  $CommentContent = $DataRows['comment'];
                ?>
                <div class="">
                  <div class="media CommentBlock">
                    <img class="d-block img-fluid align-self-start" src="Image/comment.png" alt="">
                    <div class="media-body ml-2">
                      <h6 class="lead"> <?php echo $CommenterName; ?> </h6>
                      <p class="small"> <?php echo $CommentDate; ?> </p>
                      <p> <?php echo $CommentContent; ?> </p>
                    </div>
                  </div>
                </div>
                <hr>
              <?php } ?>
             <!--fetching existing comment end -->
             <div class="">
               <form class="" action="FullPost.php?id=<?php echo $SearchQueryParameter; ?>" method="post">
                 <div class="card mb-3">
                   <div class="card-header">
                     <h5 class="FieldInfo">Share Your Thoughts</h5>
                   </div>
                   <div class="card-body">
                     <div class="form-group">
                       <div class="input-group">
                         <div class="input-group-prepend">
                           <span class="input-group-text"><i class="fas fa-user"></i></span>
                         </div>
                       <input class="form-control" type="text" name="CommenterName" placeholder="Name" value="">
                       </div>
                     </div>
                     <div class="form-group">
                       <div class="input-group">
                         <div class="input-group-prepend">
                           <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                         </div>
                       <input class="form-control" type="email" name="CommenterEmail" placeholder="Email" value="">
                       </div>
                     </div>
                     <div class="form-group">
                       <textarea name="CommenterThoughts" class="form-control" rows="6" cols="80" placeholder="Leave feedback!!"></textarea>
                     </div>
                     <div class="">
                       <button type="submit" name="Submit" class="btn btn-primary">Submit</button>
                     </div>
                   </div>
                 </div>
               </form>
             </div>
          </div>
          <!-- End of main area -->

          <!--side area-->
          <div class="col-sm-4">
            <div class="card mt-4">
              <div class="card-body">
                <img src="Images/daily_update.jpg" class="d-block img-fluid mb-3" alt="">
                <div class="text-center">
                  Publishing is the activity of making information, literature, music, software and other content available to the public for sale or for free.
                  So we proceed to publish and keep upto date information for everyone about the college. In various ways its effective for the students, Guardians and
                  teachers with this medium of interaction.
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header bg-dark text-light text-center">
                <h2 class="lead"> Sign Up !</h2>
              </div>
              <div class="card-body">
                <button type="button" class="btn btn-success btn-block text-center text-white mb-4" name="button"> Join the Forum</button>
                <button type="button" class="btn btn-danger btn-block text-center text-white mb-4" name="button">Login</button>
                <div class="input-group m-3">
                  <input type="text" class="form-control" placeholder="Enter your emial" name="" value="">
                  <div class="input-group-append">
                    <button type="button" class="btn btn-primary btn-sm text-center text-white" name="button">Subscribe Now</button>

                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="card">
              <div class="card-header bg-primary text-light">
                <h2 class="lead">Categories</h2>
              </div>

                <div class="card-body">
                  <?php
                    global $ConnectingDB;
                    $sql = "SELECT * FROM category ORDER BY id desc";
                    $stmt = $ConnectingDB->query($sql);
                    while($DataRows=$stmt->fetch())
                    {
                      $CategoryId    = $DataRows["id"];
                      $CategoryName  = $DataRows["title"];
                   ?>
                  <a href="Blog.php?category=<?php echo $CategoryName; ?>"><span class="heading"> <?php echo $CategoryName; ?> </span> <br></a>
                <?php } ?>
              </div>
            </div>
            <br>
            <div class="card">
              <div class="card-header bg-info text-white">
                <h2 class="lead">Recent Posts</h2>
              </div>
              <div class="card-body">
                <?php
                  global $ConnectingDB;
                  $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                  $stmt = $ConnectingDB->query($sql);
                  while($DataRows=$stmt->fetch()){
                    $Id       = $DataRows['id'];
                    $Title    = $DataRows['title'];
                    $DateTime = $DataRows['datetime'];
                    $Image    = $DataRows['image'];
                 ?>
                <div class="media">
                  <img src="Uploads/<?php echo htmlentities($Image); ?>" class="d-block img-fluid align-self-start" width="90px" height="90px">
                  <div class="media-body ml-2">
                   <a href="FullPost.php?id=<?php echo htmlentities($Id); ?>" target="_blank">  <h6 class="lead"> <?php echo htmlentities($Title); ?>  </h6></a>
                    <p class="small"> <?php echo $DateTime; ?></p>
                  </div>
                </div>
                <hr>
              <?php } ?>
              </div>
            </div>
          </div>
          <!--End of side area-->

        </div>
      </div>

      <!-- End of header section -->
      <br>
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
