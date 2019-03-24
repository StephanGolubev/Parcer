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
<img id="loading" alt="" src="../media/loader.gif"/>


<?php require "../includes/nava.php" ?>
<?php
ini_set('max_execution_time', 300);

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
    // echo htmlspecialchars($result);

    if (($result['errno'] != 0 )||($result['http_code'] != 200)){
        echo "No";
        echo $result['errmsg'];
	}else{

    $page2 = $result['content'];
    // $result.header_remove('content');
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
            echo "http://дизайн-керамика.рф".$value."<br><hr>";

            
        $getter = new Getter();
        $getter->url = "http://дизайн-керамика.рф".$value."";
        $getter_result = $getter->get_web_page();
        if (($getter_result['errno'] != 0 )||($getter_result['http_code'] != 200)){
            echo $getter_result['errmsg'];
            echo "oops..."."<hr>";
	}
    else{
        echo "good...";
        $page_product = $getter_result['content'];
// echo htmlspecialchars($page_product);
        $page_aft = strpos($page_product, '<p class="the_title">');
        $page_product = substr($page_product, $page_aft);
        $page_aft = strpos($page_product, '<div class="filters__group__body">');
        $page_product = substr($page_product, 0, $page_aft);
        htmlspecialchars($page_product);
    }

}
      }
      echo "<br><br><br>";
}
}?>
</body>
</html>