---
---
#Basic Usage
```php
<?php

require 'vendor/autoload.php';

use VKBansal\FrontMatter\Parser;
use VKBansal\FrontMatter\Document;

//Parse a document
$doc = Parser::parse(<<<EOF
---
layout: custom
my_list:
    - one
    - two
    - three
---
Main Title
-----
### Subtilte

Lorem ipsum......
EOF
);

var_dump($doc->getConfig());
var_dump($doc->getContent());
```
```php
array (size=2)
  'layout' => string 'custom' (length=6)
  'my_list' =>
    array (size=3)
      0 => string 'one' (length=3)
      1 => string 'two' (length=3)
      2 => string 'three' (length=5)

string 'Main Title
-----
### Subtilte

Lorem ipsum......' (length=48)
```
