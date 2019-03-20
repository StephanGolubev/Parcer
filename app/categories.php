<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>
<body>

<?php
require_once 'classes/db.php';
require_once 'classes/getter.php';
require_once 'model/categories.php';
// require_once 'core/view.php';
$cate = new Categore();


$object = new Getter();
$con = new DB();
$object->url = "дизайн-керамика.рф";
$result = $object->get_web_page();
if (($result['errno'] != 0 )||($result['http_code'] != 200))
    {
	echo $result['errmsg'];
	}
else
	{
    $page = $result['content'];
    $page2 = $result['content'];
    $pos = strpos($page2, "<svg role=\"img\" class=\"arrow\"><use xlink:href=\"/static/images/sprite.svg#arrow\"></use></svg>");
    $page2 = substr($page2, $pos);
    $pos = strpos($page2, "<div class=\"menu__nav\">");
    $page2 = substr($page2, 0, $pos);
    $array = array();

echo "<ul>";
    $dom = new domdocument();
    libxml_use_internal_errors(true);
    $dom->loadhtml('<?xml encoding="utf-8" ?>' . $page2);
    $links = $dom->getelementsbytagname('a');
    foreach($links as $link) {
        array_push($array,$link->nodeValue);
        echo "<li>".$link->nodeValue . PHP_EOL."</li>";
        echo "<br>";



}
echo "</ul>";

$name = array('name');
echo $test =  $con->insert('categories',$name,$array);


    }
    
    
      ?>  
</body>
</html>
<hr>    