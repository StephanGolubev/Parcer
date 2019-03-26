<!DOCTYPE html>
<html>
<head>
	<title>Scan cards</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <style>
    #loading{position:fixed;top:40%;left:40%;z-index:1104;}
    </style>
</head>
<body>
<script type="text/javascript">
$( document ).ready(function() {
    $("#loading").hide();
});
</script>
<!-- <img id="loading" alt="" src="../media/loader.gif"/> -->


<?php require "../includes/nava.php" ?>
<?php
ini_set('max_execution_time', 600);
error_reporting(0);

require_once 'classes/db.php';
require_once 'classes/getter.php';

$con = new DB();

$res = $con->BuildSelect("categories");

while($row = mysqli_fetch_array($res)){
    echo "<table>";
    echo "<tr>";
        echo "<td> " . $row['id'] . "</td>";
        echo "<td> " . $row['name'] . "</td>";
        echo '<td><a href="http://дизайн-керамика.рф'. $row['url'] .'">'. $row['name'] .'</a></td>';
    echo "</tr>";
echo "<br><br><br>";
echo "</table>";
    // $urls = "http://дизайн-керамика.рф". $row['url'];
    // echo $urls;
    $object = new Getter();
    $object->url = "http://дизайн-керамика.рф". $row['url']."";
    $result = $object->get_web_page();
//    print_r($result);

    if (($result['errno'] != 0 )||($result['http_code'] != 200)){
        echo "No";
        echo $result['errmsg'];
	}else{

    $page2 = $result['content'];
    // echo htmlspecialchars($page2);

    $pos = strpos($page2, "<!-- Catalog content -->");
    $page2 = substr($page2, $pos);
    $pos = strpos($page2, "<!-- /Catalog content -->");
    $page2 = substr($page2, 0, $pos);


    echo $page2;
    echo "<br><br><br>";



    $name = array('name', 'url');
    $regex = "(?<=href=\").+(?=\")";
    // <a href="/plitka/">Керамическая плитка</a>
    // <a class="collection_cart" href="/plitka/collKarandashiKerama-Marazzi/">

    if(preg_match_all("/$regex/iU", $page2, $matches)) {
        foreach ($matches[0] as $key => $value) {
            echo '<a href="http://дизайн-керамика.рф'.$value.'">'.$value.'</a>'."<br>";
            // echo "http://дизайн-керамика.рф".$value."<br>";

            
        $getter = new Getter();
        $getter->url = "http://дизайн-керамика.рф".$value."";
        $getter_result = $getter->get_web_page();
        if (($getter_result['errno'] != 0 )||($getter_result['http_code'] != 200)){
            echo $getter_result['errmsg'];
            echo "oops..."."<hr>";
	}
    else{
        echo "good...";
        // print_r($getter_result);
        $page_product = $getter_result['content'];
        // echo ($page_product);
        $page_aft = strpos($page_product, '<p class="the_title">');
        $page_product = substr($page_product, $page_aft);
        $page_aft = strpos($page_product, '<div class="product__info--other">');
        $page_product = substr($page_product, 0, $page_aft);
        // htmlspecialchars($page_product);
        // echo $page_product;
        
        $massiv = array();
        $reg_ex1 = "<(.|\n)*?>";
        $reg_ex2 = "<div[^<>]*class=\"[^\"']+\"[^<>]*>[\s\S]*?</div>";
        $reg_ex = "<div[^<>]*class=\"my-class\"[^<>]*>[\s\S]*?";


        // $nodes = $xp->query('//div[@class="product__info__group"]');
        // print_r($nodes);


        $dom = new DomDocument();
// $dom->load($page_product);
$dom->loadhtml('<?xml encoding="utf-8" ?>' . $page_product);
$finder = new DomXPath($dom);
$classname="product__info__group";
$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
print_r($nodes);
echo $nodes->textContent;
foreach ($nodes as $value10) {
    echo $value10->textContent."<br>";
}

        // (?<=href=\").+(?=\")
        // class="product__info__name">

        // str_replace("'", "\"", $page_product);
        preg_match_all('~the_title">\K(?:[^<]+)(?=<)~', $page_product, $matches10);
        print_r($matches10);
        echo "<hr>";
    // if(preg_match_all("/class=\"product__info__value\">[.*]</iU", $page_product, $mat)) {
    //   }
    //   foreach ($mat[0] as $value1) {
        //   if ($value1 = 'Страна'or 'Производитель' or 'Код товара') {
            //   array_push($massiv,$value1);
            // echo "No<br>";
        //   }
        //   echo  "<li>".$value1."<br>";
    //   }
    //   print_r($massiv);
    }

}
      }
      echo "<br><br><br>";
}
}?>
</body>
</html>