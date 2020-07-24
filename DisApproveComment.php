<?php require_once("includes/DB.php");?>
<?php require_once("includes/functions.php");?>
<?php require_once("includes/Session.php");?>
<?php
  if(isset($_GET["id"])){
    $SearchQueryParameter = $_GET["id"];
    global $ConnectingDB;
    $Admin = $_SESSION["AdminName"]-*;
    $sql = "UPDATE comments SET status='off', approvedby='$Admin' WHERE id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);
    if($Execute)
    {
      $_SESSION["SuccessMessage"]="Comment Dis-Approved Suscessfully..!!";
      Redirect_to("Comments.php");
    }
    else {
      $_SESSION["ErrorMessage"]="Try Again.. Something went wrong..!!";
      Redirect_to("Comments.php");
    }
  }
 ?>
