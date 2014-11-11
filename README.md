[![SensioLabsInsight](https://insight.sensiolabs.com/projects/8723ff04-60ac-43b2-b432-18fae0829979/big.png)](https://insight.sensiolabs.com/projects/8723ff04-60ac-43b2-b432-18fae0829979)

[![Build Status](https://travis-ci.org/vkbansal/FrontMatter.svg?branch=master)](https://travis-ci.org/vkbansal/FrontMatter)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/vkbansal/FrontMatter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/vkbansal/FrontMatter/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/vkbansal/FrontMatter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/vkbansal/FrontMatter/?branch=master)
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
        "vkbansal/frontmatter": "~1.2.0"
    }
}
```
##Supported Formats

- YAML
- JSON
- INI

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
<?php

$document = new Document('<body>Hello</body>', ['title' => 'test', 'layout' => 'layout.html']);

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
<?php
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
For more detailed usage see [wiki](https://github.com/vkbansal/FrontMatter/wiki)

##License
[MIT](LICENSE.md)

##Changelog
[Changelog](CHANGELOG.md)
