<?php require "../includes/nava.php" ?>
<?php

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
    // echo htmlspecialchars($page);
    if (($result['errno'] != 0 )||($result['http_code'] != 200)){
        echo "No";
	    echo $result['errmsg'];
	}else{

    $page2 = $result['content'];
    echo $page2;
    echo "good";
    echo "<br><br><br>";
}
}
