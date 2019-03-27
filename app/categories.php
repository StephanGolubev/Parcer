<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<?php require "../includes/nava.php" ?>
<?php
require_once 'classes/db.php';
require_once 'classes/getter.php';
// Сканировщик каталога

// новые обьекты
$object = new Getter();
$con = new DB();

// получаем страницу
$object->url = "дизайн-керамика.рф";
$result = $object->get_web_page();

// проверяем правильность
if (($result['errno'] != 0 )||($result['http_code'] != 200))
    {
	echo $result['errmsg'];
	}
else{



    // режем код страницы до и после нужного кода
    $page2 = $result['content'];
    $pos = strpos($page2, "<svg role=\"img\" class=\"arrow\"><use xlink:href=\"/static/images/sprite.svg#arrow\"></use></svg>");
    $page2 = substr($page2, $pos);
    $pos = strpos($page2, "<div class=\"menu__nav\">");
    $page2 = substr($page2, 0, $pos);
    $value_array = array();

echo "<ul>";

    // массив таблиц, в которые будем добавлять каталог
    $insert_tables = array('name', 'url');
    // регуль. выр. для нарезки имени каталога 
    $regex = "<a href=\"([^\"]*)\">(.*)<\/a>";

    // режем страницу рег. выр.
    if(preg_match_all("/$regex/iU", $page2, $matches)) {
      }
      // массивы ссылки каталога и названия
      $matches_link = $matches[1];
      $matches_name = $matches[2];

      // проходим массивы и добавляем в массив одного каталога
      for ($i=0; $i < count($matches_link); $i++) { 
        array_push($value_array,$matches_name[$i]);
        array_push($value_array,$matches_link[$i]);
          echo $matches_link[$i]."->  ";
          echo $matches_name[$i]."<br>";
          // делаем запись в бд
        // $test =  $con->insert('categories',$insert_tables,$value_array);

        // опусташаем массив
       $value_array = array();
      }

}
echo "</ul>";
    
    
      ?>  
</body>
</html>
<hr>    
