<?php
/*
Plugin Name: Monarch Press
Plugin URI:
Description: TODO
Author: Green Team
Version: 0.1
Author URI: http://www.cs.odu.edu/~411green/
*/
function xmlMaker($classID, $classValue){
$doc = new DOMDocument('1.0');

$doc->formatOutput = true;

$root = $doc->createElement('HTML');
$root = $doc->appendChild($root);
$head = $doc->createElement('head');
$head = $root->appendChild($head);
$body = $doc->createElement('body',"\n");
$body = $root->appendChild($body);
$div = $doc->createElement('div',"\n\n");
$div = $body->appendChild($div);

foreach ($classID as $value){
$text = $doc->createTextNode("<div class=$value>$classValue </div>\n");
$text = $div->appendChild($text);
}

echo $doc->save("usersXML.xml");
}
$array = array('foo' => "jack",
              'monkey'=> "attack");
xmlMaker($array, "helloTest");
?>

<html>
<body>
  <div class="making">
    testing hehe
  </div>
</body>
<script src="/bower_components/jquery/src/jquery-2.1.4.js"></script>

<script>
var hello = $("div.making").html();
console.log("what is hello? " + hello);
</script>
</html>
