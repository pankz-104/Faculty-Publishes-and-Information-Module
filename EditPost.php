<?php require_once("includes/DB.php");?>
<?php require_once("includes/functions.php");?>
<?php require_once("includes/Session.php");?>
<?php Confirm_Login(); ?>

<?php
$SarchQueryParameter = $_GET['id'];
if(isset($_POST["Submit"]))
{
  $PostTitle = $_POST["PostTitle"];
  $Category = $_POST["Category"];
  $Image = $_FILES["Image"]["name"];
  $Target = "Uploads/".basename($_FILES["Image"]["name"]);
  $postDescription = $_POST["postDescription"];
  $Admin = "Pankaj";
  date_default_timezone_set("Asia/kathmandu");
  $CurrentTime=time();
  $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

  if(empty($PostTitle)){
    $_SESSION["ErrorMessage"] = "Title cannot be empty..";
    Redirect_to("Posts.php");
  }
  elseif(strlen($PostTitle)<5){
    $_SESSION["ErrorMessage"] = "Post title should be greater than 5 character..";
    Redirect_to("Posts.php");
  }
  elseif(strlen($PostTitle)>9999){
    $_SESSION["ErrorMessage"] = "Post title should be less than 10000 character..";
    Redirect_to("Posts.php");
  }
  else {
      // query to update post inside database when everything is fine
      global $ConnectingDB;
      if(!empty($_FILES["Image"]["name"])){
        $sql = "UPDATE posts
                SET title='$PostTitle',category='$Category',image='$Image',post='$postDescription'
                WHERE id='$SarchQueryParameter'";
      }
      else {
        $sql = "UPDATE posts
                SET title='$PostTitle',category='$Category',post='$postDescription'
                WHERE id='$SarchQueryParameter'";
      }
      $Execute = $ConnectingDB->query($sql);
      move_uploaded_file($_FILES["Image"]["tmps_name"],$Target);
      if($Execute){
        $_SESSION["SuccessMessage"]="Post updated Suscessfully";
        Redirect_to("Posts.php");
      }
      else {
        $_SESSION["ErrorMessage"] = "Something went wrong..Try Again.!";
        Redirect_to("Posts.php");
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
    <title>Edit Post</title>
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
              <h1> <i class = "fas fa-edit" style="color:#27aae1;"></i>Edit Post</h1>
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
             //fetch existing content...!!!
             global $ConnectingDB;
             $sql = "SELECT * FROM posts WHERE id='$SarchQueryParameter'";
             $stmt = $ConnectingDB->query($sql);
             while($DataRows=$stmt->fetch()){
               $TitleToBeUpdated    = $DataRows['title'];
               $CategoryToBeUpdated = $DataRows['category'];
               $ImageToBeUpdated    = $DataRows['image'];
               $PostToBeUpdated     = $DataRows['post'];
             }
             ?>
            <form class="" action="EditPost.php?id=<?php echo $SarchQueryParameter; ?>$SarchQueryParameter" method="post" enctype="multipart/form-data"> <!--enctype for image to keep it in database-->
              <div class="card bg-secondary text-light mb-3">
                <div class="card-body bg-dark text-white">
                  <div class="form-group">
                    <label for="title"><span class = "FieldInfo">Post Title :</span> </label>
                    <input class = "form-control" type="text" name="PostTitle" id = "title" placeholder = "Type_title_here" value="<?php echo $TitleToBeUpdated; ?>">
                  </div>
                  <div class="form-group">
                    <span class="FieldInfo">Existing Category:</span>
                    <?php echo $CategoryToBeUpdated; ?> <br>
                    <label for="title"><span class = "FieldInfo">Choose Category :</span> </label>
                    <select class="form-control" name="Category" id="categoryTitle">
                      <?php
                        global $ConnectingDB;
                        //fetching all the categories from category table
                        $sql = "SELECT * FROM category";
                        $stmt = $ConnectingDB->query($sql);
                        while($DataRows = $stmt->fetch()){
                          $ID = $DataRows["id"];
                          $CategoryName = $DataRows["title"];
                      ?>
                      <option> <?php echo $CategoryName; ?></option>
                    <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <span class="FieldInfo">Existing Image:</span>
                    <img class="mb-1" src="Uploads/<?php echo $ImageToBeUpdated; ?>" width="170px;" height="70px;">
                    <div class="custom-file">
                      <input class="custom-file-input" type="File" name="Image" id="imageselect" value="">
                      <label for="imageselect" class="custom-file-label">Select Image</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="post"> <span class="FieldInfo"> Post :</span> </label>
                    <textarea name="postDescription" class="form-control" id="post" rows="8" cols="80">
                      <?php  echo $PostToBeUpdated; ?>
                    </textarea>
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
