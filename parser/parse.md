#Parse
Parses given input.

**Description**
```php
Document Parser::parse(string $input)
```

**Parameters**
- `$input`: string to be parsed


**Return Value**
- An instance of [Document](./Document)


**Usage**
```php
<?php
require '../vendor/autoload.php';

use VKBansal\FrontMatter\Parser;
use VKBansal\FrontMatter\Document;

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

$doc->getConfig(); // ['layout' => 'custom', 'my_list' => ['one', 'two', 'three']]
$doc->getContent(); //Main Title\n-----\n### Subtilte\n\nLorem ipsum......
```
