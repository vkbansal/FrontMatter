[![Build Status](https://travis-ci.org/vkbansal/FrontMatter.svg?branch=master)](https://travis-ci.org/vkbansal/gulp-group-files)
[![Latest Stable Version](https://poser.pugx.org/vkbansal/frontmatter/v/stable.svg)](https://packagist.org/packages/vkbansal/frontmatter)
[![License](https://poser.pugx.org/vkbansal/frontmatter/license.svg)](https://packagist.org/packages/vkbansal/frontmatter)
#FrontMatter
Frontmatter allows page-specific variables to be included at the top of a template using the YAML or JSON format.

##Requirements
 - PHP >= 5.4

##Installation
Create or update your composer.json and run `composer update`
```json
{
    "require": {
        "vkbansal/frontmatter": "~1.1.0"
    }
}
```
##Supported Formats

###YAML
```
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
```
###JSON
```
--- json
{
    "layout": "custom",
    "my_list": [
      "one",
      "two",
      "three"
    ]
}
---
Main Title
-----
### Subtilte

Lorem ipsum......
```

##Usage
###Parse
```php
<?php

require '../vendor/autoload.php';

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
####Dump
```php
$document = new Document('<body>Hello</body>', array('title' => 'test', 'layout' => 'layout.html'));

$dump = Parser::dump($document);

var_dump($dump);

```
```php
string '---
title: test
layout: layout.html
---
<body>Hello</body>' (length=58)
```
####Validation
```php
Parser::isValid('Lorem ipsum....'); //false
Parser::isValid(<<<EOF
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
); //true
```
For more detailed usage see [wiki](./wiki)

##License
[MIT](LICENSE.md)

##Changelog
[Changelog](CHANGELOG.md)