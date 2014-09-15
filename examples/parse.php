<?php

require '../vendor/autoload.php';

use VKBansal\FrontMatter\Parser;
use VKBansal\FrontMatter\Document;

$yaml = file_get_contents(__DIR__.'/../test/resources/yaml.md');
$json = file_get_contents(__DIR__.'/../test/resources/json.md');

$doc_y = Parser::parse($yaml);
$doc_j = Parser::parse($json);

var_dump($doc_j->getContent());
var_dump($doc_y->getContent());
