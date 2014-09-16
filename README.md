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
        "vkbansal/frontmatter": "dev-master"
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
;;;
{
    "layout": "custom",
    "my_list": [
      "one",
      "two",
      "three"
    ]
}
;;;
Main Title
-----
### Subtilte

Lorem ipsum......
```

##Usage

###Parser
####Document Parser::parse(string $input)
It accepts a `string` as an input and returns an instance of `VKBansal\FrontMatter\Document`
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
It produces the following result
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
####string Parser::dump(Document $document [, boolean $asJSON])
This method takes an Instance of `VKBansal\FrontMatter\Document` as its first argument. 
An optional second argument can be provided as a boolean. Its default value is `false` which outputs `YAML`. If it's set to `true`, output will be in `JSON` format. 
```php
<?php

require '../vendor/autoload.php';

use VKBansal\FrontMatter\Parser;
use VKBansal\FrontMatter\Document;

$document = new Document('<body>Hello</body>', array('title' => 'test', 'layout' => 'layout.html'));

$dump_y = Parser::dump($document);

$dump_j = Parser::dump($document, true);

var_dump($dump_y);
var_dump($dump_j);
```
It produces the following result
```php
string '---
title: test
layout: layout.html
---
<body>Hello</body>' (length=58)
```
##Document
TODO: documentation of `Docuemnt`
##License
[MIT](LICENSE.md)
