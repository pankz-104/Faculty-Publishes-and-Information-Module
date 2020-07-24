<?php require_once("includes/DB.php");?>
<?php require_once("includes/functions.php");?>
<?php require_once("includes/Session.php");?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="stylesheet" href="CSS/all.min.css">
    <title>Blog Page</title>
    <style media="screen">
    .heading{
      font-family : Bitter,Georgia,"Times New Roman",Times,Serif;
      font-weight : bold;
      color : #005E90;
    }

    .heading:hover{
      color : #0090DB;
    }
    </style>
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
              <h1>The complete resopnsive publishes site</h1>
              <h1 class = "lead">The complete publishes site using PHP by Pankaj Pandey</h1>
              <?php
                  echo ErrorMessage();
                  echo SuccessMessage();
               ?>
              <!-- Search Button function -->
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
              } //query if paginnation is active
              elseif (isset($_GET["page"])){
                $Page = $_GET["page"];
                //$ShowPostFrom = 0;
                if($Page==0||$Page<1){
                $ShowPostFrom=0;
                }else {
                $ShowPostFrom=($Page*5)-5;
                }
                $sql = "SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,5";
                $stmt = $ConnectingDB->query($sql);
              }
              //query when category is active in URL tab
              elseif (isset($_GET["category"])) {
                $Category = $_GET["category"];
                $sql = "SELECT * FROM posts WHERE category = '$Category' ORDER BY id desc";
                $stmt = $ConnectingDB->query($sql);
              }
              //the default sql query
              else {
                  $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,4";
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
                   <span style="float:right" class="badge-dark text-light">Comments <?php echo ApproveCommentsAccordingtoPost($PostId); ?>
                   </span>
                   <hr>
                   <p class="card-text">
                      <?php if(strlen($postDescription)>150){
                          $postDescription = substr($postDescription,0,150)."....";} echo htmlentities($postDescription); ?> </p>
                   <a href="FullPost.php?id=<?php echo $PostId; ?>" style="float:right">
                     <span class="btn btn-info">Read More>></span>
                   </a>
                 </div>
               </div>
             <?php } ?>
             <!--pagination-->
             <nav>
               <ul class="pagination pagination-lg">
                 <!-- Creating Backward Button -->
             <?php  if(isset($Page)){
               if($Page>1){
               ?>
                 <li class="page-item">
                   <a href="Blog.php?page=<?php echo $Page-1; ?>" class="page-link">&laquo;</a>
                 </li>
             <?php } } ?>
                 <?php
                  global $ConnectingDB;
                  $sql = "SELECT COUNT(*) FROM posts";
                  $stmt = $ConnectingDB->query($sql);
                  $RowPagination=$stmt->fetch();
                  $TotalPosts=array_shift($RowPagination);
                //  echo $TotalPosts."<br>";
                  $PostPagination = $TotalPosts/4;
                  $PostPagination=ceil($PostPagination);
              //    echo $PostPagination;
                  for($i=1;$i<=$PostPagination;$i++)
                  {
                    if(isset($Page)){
                      if($i == $Page){ ?>
                        <li class="page-item">
                          <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                        </li>
                        <?php
                      }else {
                          ?> <li class="page-item">
                            <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                            </li>
                          <?php }
                         }
                    } ?>
                          <!-- for forward button -->
                      <?php  if(isset($Page)&&!empty($Page)){
                        if($Page+1<=$PostPagination){
                        ?>
                          <li class="page-item">
                            <a href="Blog.php?page=<?php echo $Page+1; ?>" class="page-link">&raquo;</a>
                          </li>
                      <?php } } ?>
               </ul>
             </nav>
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
              This site is for purpose to provide information in regard to made by teachers at
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
