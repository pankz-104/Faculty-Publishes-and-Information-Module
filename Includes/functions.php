<?php require_once("includes/DB.php");?>

<?php
  function Redirect_to($New_Location){
  header("Location:".$New_Location);
  exit;
}
  function CheckUserNameExistsOrNot($UserName){
    global $ConnectingDB;
    $sql = "SELECT username FROM admins
            WHERE username = :userName";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindvalue(':userName',$UserName);
    $stmt->execute();
    $Result=$stmt->rowcount();
    if($Result==1){
      return true;
    }
    else {
      return false;
    }
  }

  function Login_Attempt($UserName,$Password){
      global $ConnectingDB;
      $sql = "SELECT * FROM admins
              WHERE username=:userName AND password=:passWord LIMIT 1";
      $stmt=$ConnectingDB->prepare($sql);
      $stmt->bindvalue(':userName',$UserName);
      $stmt->bindvalue(':passWord',$Password);
      $stmt->execute();
      $Result = $stmt->rowcount();
      if($Result==1){
        return $Found_Account = $stmt->fetch();
      }
      else {
        return null;
      }
  }

  function Confirm_Login(){
    if(isset($_SESSION["User_Id"])){
      return true;
    }
    else {
      $_SESSION["ErrorMessage"]="Login Required";
      Redirect_to("Login.php");
    }
  }

  function TotalPosts()
  {
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM posts";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalPosts = array_shift($TotalRows);
    echo $TotalPosts;
  }

  function TotalCategories()
  {
      global $ConnectingDB;
      $sql = "SELECT COUNT(*) FROM category";
      $stmt = $ConnectingDB->query($sql);
      $TotalRows = $stmt->fetch();
      $TotalCategories = array_shift($TotalRows);
      echo $TotalCategories;
  }

  function TotalAdmins()
  {
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM admins";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalAdmins = array_shift($TotalRows);
    echo $TotalAdmins;
  }

  function TotalComments()
  {
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM comments";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalComments = array_shift($TotalRows);
    echo $TotalComments;
  }

  function ApproveCommentsAccordingtoPost($PostId)
  {
    global $ConnectingDB;
    $sqlApprove = "SELECT COUNT(*) from comments WHERE post_id='$PostId' AND status='on'";
    $stmtApprove = $ConnectingDB->query($sqlApprove);
    $RowsTotal = $stmtApprove->fetch();
    $Total = array_shift($RowsTotal);
    return $Total;
  }

  function DisApproveCommentsAccordingtoPost($PostId)
  {
    global $ConnectingDB;
    $sqlDisApprove = "SELECT COUNT(*) from comments WHERE post_id='$PostId' AND status='off'";
    $stmtDisApprove = $ConnectingDB->query($sqlDisApprove);
    $RowsTotal = $stmtDisApprove->fetch();
    $Total = array_shift($RowsTotal);
    return $Total;
  }

 ?>
