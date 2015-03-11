[![Latest Stable Version](https://img.shields.io/packagist/v/vkbansal/FrontMatter.svg?style=flat-square)](https://packagist.org/packages/vkbansal/frontmatter)
[![Build Status](https://img.shields.io/travis/vkbansal/FrontMatter.svg?style=flat-square)](https://travis-ci.org/vkbansal/FrontMatter)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/vkbansal/FrontMatter.svg?style=flat-square)](https://scrutinizer-ci.com/g/vkbansal/FrontMatter/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/vkbansal/FrontMatter.svg?style=flat-square)](https://scrutinizer-ci.com/g/vkbansal/FrontMatter/?branch=master)
[![Code Climate](https://img.shields.io/codeclimate/github/vkbansal/FrontMatter.svg?style=flat-square)](https://codeclimate.com/github/vkbansal/FrontMatter)
[![License](https://img.shields.io/badge/Licence-MIT-brightgreen.svg?style=flat-square)](https://packagist.org/packages/vkbansal/frontmatter)
[![Dependency Status](https://www.versioneye.com/user/projects/5476a723dfc6586ee7000102/badge.svg?style=flat)](https://www.versioneye.com/user/projects/5476a723dfc6586ee7000102)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/8723ff04-60ac-43b2-b432-18fae0829979/big.png)](https://insight.sensiolabs.com/projects/8723ff04-60ac-43b2-b432-18fae0829979)
#FrontMatter
Frontmatter allows page-specific variables to be included at the top of a template using the YAML or JSON format.

##Requirements
 - PHP >= 5.4

##Installation
Create or update your composer.json and run `composer update`
```bash
$ composer require vkbansal/frontmatter
```
##Supported Formats

- YAML
- JSON
- INI

## Quick usage
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
### Subtitle

Lorem ipsum......
EOF
);

var_dump($doc->getConfig()); // ['layout' => 'custom', 'my_list' => ['one', 'two',  'three']]
var_dump($doc->getContent());
/*
Main Title
-----
### Subtitle

Lorem ipsum.....
*/
```
For more detailed usage see [website](https://vkbansal.github.io/FrontMatter/)

##License
[MIT](LICENSE.md)

##Changelog
[Changelog](CHANGELOG.md)
