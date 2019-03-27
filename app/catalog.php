<!DOCTYPE html>
<html>
<head>
	<title>Scan cards</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
</head>
<body>


<?php require "../includes/nava.php" ?>
<?php
// Сканировщик товаров каждого каталога

// процесс идет долго, увеличиваем время загрузки страницы
ini_set('max_execution_time', 600);

require_once 'classes/db.php';
require_once 'classes/getter.php';

// обьект бд
$con = new DB();

// получаем все каталоги из бд
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
    
    // формируем каждого каталога ссылку и получем код страницы 
    $object = new Getter();
    $object->url = "http://дизайн-керамика.рф". $row['url']."";
    $result = $object->get_web_page();

    if (($result['errno'] != 0 )||($result['http_code'] != 200)){
        echo $result['errmsg'];
	}else{

    $page2 = $result['content'];

    // режем до и после
    $pos = strpos($page2, "<!-- Catalog content -->");
    $page2 = substr($page2, $pos);
    $pos = strpos($page2, "<!-- /Catalog content -->");
    $page2 = substr($page2, 0, $pos);

    // регулярка для нарезки личной ссылки каждого товара
    $regex = "(?<=href=\").+(?=\")";

    // режем страницу каталога и получаем ссылки каждого товара
    if(preg_match_all("/$regex/iU", $page2, $matches)) {
        foreach ($matches[0] as $key => $value) {
            echo '<a href="http://дизайн-керамика.рф'.$value.'">'.$value.'</a>'."<br>";

        // создаем новый обьект для сохранения в бд данных каждого товара
        $getter = new Getter();
        // формируем ссылку и получаем код страницы
        $getter->url = "http://дизайн-керамика.рф".$value."";
        $getter_result = $getter->get_web_page();
        if (($getter_result['errno'] != 0 )||($getter_result['http_code'] != 200)){
            echo $getter_result['errmsg'];
	}
    else{

        // обрабатываем страницу
        $page_product = $getter_result['content'];
        // до после
        $page_aft = strpos($page_product, '<p class="the_title">');
        $page_product = substr($page_product, $page_aft);
        $page_aft = strpos($page_product, '<div class="product__info--other">');
        $page_product = substr($page_product, 0, $page_aft);
        
        // создаем структуру html страницы
        $dom = new DomDocument();
        $dom->loadhtml('<?xml encoding="utf-8" ?>' . $page_product);
        // так как в разны товарах разная структура (иногда div иногда p) будем исплоьзавать DomXPath() и резать по классам
        $finder = new DomXPath($dom);
        // вот класс для нарезки
        $classname="product__info__group";
        $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");

        // массивы которые будем обрабатывать для сохранения данных в бд
        $insert_vals = array();
        $tables = array('coutry', 'creator', 'name', 'category');
        $counter = 0;
        // пробегаем массив
        foreach ($nodes as $value_card) {
            // исключаем, кода есть код товара
            if (preg_match('/(Код товара)/', $value_card->textContent)) {
                continue;
            }
    // приводим в надлежащее состояное
    $value_card->textContent = trim(preg_replace('/\s\s+/', ' ', $value_card->textContent));
    echo "<li>".$value_card->textContent."<br>";
        
    // добавляем в массив
    array_splice($insert_vals, $counter, 0, $value_card->textContent);
   

}       
        // обрабатываем код и получаем название товара
        preg_match_all('~the_title">\K(?:[^<]+)(?=<)~', $page_product, $matches10);
        foreach ($matches10[0] as $key => $value_name) {
            echo "<li>".$value_name."<br>";
            // добаваляем в тот же массив
            array_push($insert_vals,$value_name);
        }
        // добаваляем в тот же массив id каталога, чтобы обращаться к нему
        array_push($insert_vals, $row['id']);
        // в некоторых товарах нет станы и произвадиетля, поэтому, если нет, то добавляем none
        echo $nubers = count($insert_vals)."<br>";
        if ($nubers == 2) {
            $insert_vals_sp = array();
            $insert_vals_sp[0] = 'None';
            $insert_vals_sp[1] = 'None';
            $insert_vals_sp[2] = $insert_vals[0];
            $insert_vals_sp[3] = $insert_vals[1];
            
            print_r($insert_vals_sp);
            // делаем запись в бд
            // $query =  $con->insert('card',$tables,$insert_vals_sp);

            echo "<hr>";
            continue;
        }
        // если значений 4 то делаем запись
        print_r($insert_vals);
        echo "<br>";

        // запись в бд
        // $query =  $con->insert('card',$tables,$insert_vals);

        echo "<hr>";

    }

}
      }
      echo "<br>";
}
}?>

</body>
</html>