#Dump
Convert a document to frontmatted string.

**Description**
```php
string Parser::dump(Document $document [, boolean $asJSON])
```
**Parameters**
- `$document`: Document to be converted. An Instance of [Document](./Document).
- `$asJSON`: (optional) A boolean. Its default value is `false` which outputs `YAML`. If it's set to `true`, output will be in `JSON` format.

**Return Value**
- Frontmatted `string`

**Usage**
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
