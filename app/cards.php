<?php

require_once 'classes/db.php';
require_once 'classes/getter.php';

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

    $page2 = $result['content'];
    $pos = strpos($page2, "<div class=\"carts_container\">");
    $page2 = substr($page2, $pos);
    $pos = strpos($page2, "<a href=\"/catalog/\" class=\"carts_container__more\">");
    echo $page2 = substr($page2, 0, $pos);
    $array = array();

echo "<ul>";
    $dom = new domdocument();
    libxml_use_internal_errors(true);
    $dom->loadhtml('<?xml encoding="utf-8" ?>' . $page2);
    $links = $dom->getelementsbytagname('a');
    $linki = $dom->getElementsByTagNameNS ('/media/filer_public/','*');
    foreach($links as $link) {
        // array_push($array,$link->nodeValue);
        // echo "<li>".$link->nodeValue . PHP_EOL."</li>";
        // echo "<br>";
    }
    foreach ($dom->getElementsByTagNameNS('/media/filer_public/', '*') as $element) {
        echo 'local name: ', $element->localName, ', prefix: ', $element->prefix, "\n";
    }
echo "</ul>";










}