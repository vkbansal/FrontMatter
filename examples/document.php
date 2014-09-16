<?php

require '../vendor/autoload.php';

use VKBansal\FrontMatter\Document;

$document = new Document('<body>Hello</body>', array('title' => 'test', 'layout' => 'layout.html'));

var_dump($document->getConfig('title'));
var_dump($document->getConfig());

$document->setConfig('title', 'Another Title');
var_dump($document->getConfig());
$document->setConfig(['title'=> 'Random Title', 'category' => 'yet another category']);
var_dump($document->getConfig());

var_dump($document->getContent());

$document->setContent('Lorem ipsum');
var_dump($document->getContent());

echo $document["title"]."<br>";
$document["category"] = "Some Category";
echo $document["category"];
unset($document["category"]);
var_dump(isset($document["category"]));


echo $document;