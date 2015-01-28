---
---
#Content
##Get Content
Returns the body/content of the document.

**Description**
```php
string Document::getContent()
```

**Return Value**
- the body/content of the document as string.

**Usage**
```php
$document->getContent();//'<body>Hello</body>'
```

##Set Content
Sets the body/content of the document.

**Description**
```php
$this Document::setContent(string $content)
```
**Parameters**
- `$content`: The body/content of the document as a string.

**Return Value**
- Current instance of document (`$this`). Makes Method Chainable.

**Usage**
```php
$document->setContent('Lorem ipsum');
$document->getContent();//'Lorem ipsum'
```
