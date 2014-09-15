<?php

require '../vendor/autoload.php';

use VKBansal\FrontMatter\Parser;
use VKBansal\FrontMatter\Document;

$document = new Document('<body>Hello</body>', array('title' => 'test', 'layout' => 'layout.html'));

$dump_y = Parser::dump($document);

$dump_j = Parser::dump($document, true);

var_dump($dump_y);