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
  if(!empty($password)){
    $conn->update_userPassword($email,$password);
}
    if(!empty($squestion)){
      $conn->update_userQuestion($email,$squestion);

  }
      if(!empty($sanswer)){
        $conn->update_userAnswer($email,$sanswer);
    }
        if(!empty($twit_id)){
          $conn->update_userTwitterHandle($email,$twit_id);
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
