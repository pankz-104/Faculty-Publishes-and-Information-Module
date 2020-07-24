<?php require_once("includes/DB.php");?>
<?php require_once("includes/functions.php");?>
<?php require_once("includes/Session.php");?>
<?php
  if(isset($_GET["id"])){
    $SearchQueryParameter = $_GET["id"];
    global $ConnectingDB;
    $sql = "DELETE FROM comments WHERE id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);
    if($Execute)
    {
      $_SESSION["SuccessMessage"]="Comment Deleted Suscessfully..!!";
      Redirect_to("Comments.php");
    }
    else {
      $_SESSION["ErrorMessage"]="Try Again.. Something went wrong..!!";
      Redirect_to("Comments.php");
    }
  }
 ?>
