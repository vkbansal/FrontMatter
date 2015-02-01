---
---
#Document
Description of `VKBansal\FrontMatter\Document`.

##Constructor
The constructor.
**Description**

```php
Document::__construct([string $content [, array $header]])
```

**Parameters**
- `$content`: The body/content of the document as a string.
- `$header`: Config/Header for the document as an associative array.

**Usage**

```php
$config = [
    'title' => 'test',
    'layout' => 'layout.html'
];

$document = new Document('<body>Hello</body>', $config);
```
