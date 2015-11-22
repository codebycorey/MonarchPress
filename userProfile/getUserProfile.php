<?php

include("MonarchPressDb.php");

//test user insert
function getUserProfile($email,$rowID,$url, $user, $pwd, $db){
$test = new MonarchPressDb($url, $user, $pwd, $db);
if ($result = $test->search_user_by_email($email)) {

   /* fetch object array */
   while($row = $result->fetch_assoc()) {
        return $row[$rowID];
}
   /* free result set */
   $result->close();
}
}
?>
<html>
<body>
  <?php
  echo ("User Information<br>");
  echo ("Email: ".getUserProfile('test@test.com','email','128.82.11.37','root','w@t3rg@t3','wordpress')."<br>");
  echo ("Username: ".getUserProfile('test@test.com','username','128.82.11.37','root','w@t3rg@t3','wordpress')."<br>");
  echo ("Password: ".getUserProfile('test@test.com','password','128.82.11.37','root','w@t3rg@t3','wordpress')."<br>");
  echo ("Secret Quetion: ".getUserProfile('test@test.com','secret_question','128.82.11.37','root','w@t3rg@t3','wordpress')."<br>");
  echo ("Secret Answer: ".getUserProfile('test@test.com','secret_answer','128.82.11.37','root','w@t3rg@t3','wordpress')."<br>");
  echo ("Twitter Username: ".getUserProfile('test@test.com','twitter_handle','128.82.11.37','root','w@t3rg@t3','wordpress')."<br>");
  ?>

</body>
</html>
