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
// require_once 'model/categories.php';
// require_once 'core/view.php';



$object = new Getter();
$con = new DB();


$object->url = "дизайн-керамика.рф";
$result = $object->get_web_page();

if (($result['errno'] != 0 )||($result['http_code'] != 200))
    {
	echo $result['errmsg'];
	}
else{




    $page2 = $result['content'];
    $pos = strpos($page2, "<svg role=\"img\" class=\"arrow\"><use xlink:href=\"/static/images/sprite.svg#arrow\"></use></svg>");
    $page2 = substr($page2, $pos);
    $pos = strpos($page2, "<div class=\"menu__nav\">");
    $page2 = substr($page2, 0, $pos);
    $array = array();

echo "<ul>";

    $name = array('name', 'url');
    $regex = "<a href=\"([^\"]*)\">(.*)<\/a>";

    if(preg_match_all("/$regex/iU", $page2, $matches)) {
      }
      $matches_link = $matches[1];
      $matches_name = $matches[2];

      for ($i=0; $i < count($matches_link); $i++) { 
        array_push($array,$matches_name[$i]);
        array_push($array,$matches_link[$i]);
          echo $matches_link[$i]."->  ";
          echo $matches_name[$i]."<br>";
        // $test =  $con->insert('categories',$name,$array);
       $array = array();
      }

}
echo "</ul>";
    
    
      ?>  
</body>
</html>
<hr>    