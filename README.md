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

string ';;;
{
  "title": "test"
  "layout": "layout.html"
}
;;;
<body>Hello</body>' (length=72)
```
####boolean Parser::isValid(string $content)
Checks if given content has valid structure. It automatically handles YAML/JSON.
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

###Document
####Document::__construct([string $content [, array $header]])
The constructors can take two arguments. First argument is the body/content of the document as a `string`. Second is config/header in form of an `array`.
```php
$document = new Document('<body>Hello</body>', array('title' => 'test', 'layout' => 'layout.html'));
```
####mixed Document::getConfig([string $varName])
This method returns config value(s). If no argument is provided, It'll return entire config else it'll return config value with given name.
```php
var_dump($document->getConfig('title'));
var_dump($document->getConfig());
```
output
```php
string 'test' (length=4)
array (size=2)
  'title' => string 'test' (length=4)
  'layout' => string 'layout.html' (length=11)
```
####$this Document::setConfig(mixed $prop [, mixed $value])
This method sets config value(s). If only one argument is provided and is `array`, It'll replace entire config. If first argument is a `string`, a config value with that name will be set with second argument as its value if given else a `null`. This method is chainable.
```php
$document->setConfig('title', 'Another Title');
var_dump($document->getConfig());

$document->setConfig(['title'=> 'Random Title', 'category' => 'yet another category']);
var_dump($document->getConfig());
```
output
```php
array (size=2)
  'title' => string 'Another Title' (length=13)
  'layout' => string 'layout.html' (length=11)
array (size=2)
  'title' => string 'Random Title' (length=12)
  'category' => string 'yet another category' (length=20)
```
####string Document::getContent()
Returns the body/content of the document
```php
var_dump($document->getContent());
```
output
```php
string '<body>Hello</body>' (length=18)
```
####$this Document::setContent(string $content)
Sets the body/content of the document. This method is chainable.
```php
$document->setContent('Lorem ipsum');
var_dump($document->getContent());
```
output
```php
string 'Lorem ipsum' (length=11)
```

####$this Document::merge(Document $newDoc [, int $mode = Document::MERGE_CONFIG])
Merge `Document`(s). This method is chainable.
```php
$document = new Document('Lorem Ipsum dol sidur.....', ['title'=> 'Not A Random Title', 'layout' => 'grid']);
$newDoc = new Document('Lorem Ipsum.....', ['title'=> 'Random Title', 'category' => 'just another category']);

$document->merge($newDoc);

var_dump($document->getConfig()); 
//['title'=> 'Random Title', 'layout'=> 'grid', 'category' => 'just another category']
```
| Mode Constant         | Mode Description                                                             |
|-----------------------|------------------------------------------------------------------------------|
| MERGE_CONFIG          | Merge only config.                                                           |
| MERGE_CONTENT_REPLACE | Merge only content. Replaces current content with that from merging document |
| MERGE_CONTENT_APPEND  | Merge only content. Appends content from merging document to current one.    |
| MERGE_ALL_REPLACE     | Merge both config and content. Same as `MERGE_CONTENT_REPLACE`.              |
| MERGE_ALL_APPEND      | Merge both config and content. Same as `MERGE_CONTENT_APPEND`.               |

####$this Document::inherit(Document $parent [, int $mode = Document::INHERIT_CONFIG])
Inherit from `Document`(s). This method is chainable.
```php
$parent = new Document('Lorem Ipsum dol sidur.....', ['title'=> 'Not A Random Title', 'layout' => 'grid']);
$document = new Document('Lorem Ipsum.....', ['title'=> 'Random Title', 'category' => 'just another category']);

$document->inherit($parent);

var_dump($document->getConfig()); 
//['title'=> 'Random Title', 'layout'=> 'grid', 'category' => 'just another category']

```
| Mode Constant           | Mode Description                                                                 |
|-------------------------|----------------------------------------------------------------------------------|
| INHERIT_CONFIG          | Inherit only config.                                                             |
| INHERIT_CONTENT_REPLACE | Inherit only content. Replaces current content with that form parent document.   |
| INHERIT_CONTENT_APPEND  | Inherit only content. Prepends content from parent document to current document. |
| INHERIT_ALL_REPLACE     | Inherit both config and content. Same as `INHERIT_CONTENT_REPLACE`               |
| INHERIT_ALL_APPEND      | Inherit both config and content. Same as `INHERIT_CONTENT_APPEND`                |

###Array Access
Document can be used as an `array` for accessing header/config.
```php
echo $document["title"]."<br>";
$document["category"] = "Some Category";
echo $document["category"];
unset($document["category"]);
var_dump(isset($document["category"]));
```
output
```php
Random Title
Some Category
boolean false
```

###Property Access
Header/Config can also be accessed by property
```php
echo $document->title."<br>";
$document->category = "Some Category";
echo $document->category;
unset($document->category);
var_dump(isset($document->category));
```
output
```php
Random Title
Some Category
boolean false
```

###Document as string
Document can be used as string. It returns the document content/body.
```php
echo $document;
```
output
```
Lorem ipsum
```
##License
[MIT](LICENSE.md)
