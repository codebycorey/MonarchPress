<?php
  //Update DB according to input and users email
  $password = $_POST['password'];
  $squestion = $_POST['squestion'];
  $sanswer = $_POST['sanswer'];
  $twit_id = $_POST['twit_username'];
  $email = $_POST['email'];
  if($_POST && isset($_POST['submit'])){
  echo("Test");
  $email = 'test@test.com';
  include("MonarchPressDb.php");
  $conn = new MonarchPressDb('128.82.11.37','root','w@t3rg@t3','wordpress');
  if(isset($password)){
    $sql = "'UPDATE wordpress.monarch_user set password='{$password}' where email='{$email}'";
    $conn->mysqli->query($sql);
}
    if(isset($squestion)){
      $sql = "UPDATE wordpress.monarch_user set secret_question=$squestion where email=$email";

  }
      if(isset($sanswer)){
        $sql = "UPDATE wordpress.monarch_user set secret_answer=$sanswer where email=$email";
    }
        if(isset($twit_id)){
          $sql = "UPDATE wordpress.monarch_user set twitter_handle=$twit_id where email=$email";
      }
}

 ?>
<html>
<head>

</head>

<body>
  <h2>Update information:</h2>
  <br>
  <form method="post">
    Password:
    <br>
    <input type="password" name="password">

    <br>
    Secret Question:
    <br>
    <input type="text" name="squestion">

    <br>
    Secret Answer:
    <br>
    <input type="password" name="sanswer">

    <br>
    Twitter username:
    <br>
    <input type="text" name="twit_username">

    <br>
    Email:
    <br>
    <input type="text" name="email">
    <br>
    <input type="submit" name="submit" value="Submit">
  </form>


</body>
</html>
