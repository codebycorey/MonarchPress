<?php

include("MonarchPressDb.php");

$test = new MonarchPressDb('128.82.11.37','root','w@t3rg@t3','wordpress');

if ($result = $test->search_user_by_username('ekennedy')) {

    /* fetch object array */
    while ($row = $result->fetch_row()) {
        foreach($row as &$value){
            printf ("[%s] ", $value);
        }
        echo "\n\n";
        
    }

    /* free result set */
    $result->close();
}



?>

