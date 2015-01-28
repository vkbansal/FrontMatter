#Inherit
Inherit from `Document`(s).

##Description
```php
$this Document::inherit(Document $parent [, int $mode = Document::INHERIT_CONFIG])
```
##Parameters
- `$parent` : The document to be inherited from.
- `$mode`: Mode to be used while inheritin. Default mode `Document::INHERIT_CONFIG`

##Modes

| Mode Constant           | Mode Description                                                                 |
|-------------------------|----------------------------------------------------------------------------------|
| INHERIT_CONFIG          | Inherit only config.                                                             |
| INHERIT_CONTENT_REPLACE | Inherit only content. Replaces current content with that form parent document.   |
| INHERIT_CONTENT_APPEND  | Inherit only content. Prepends content from parent document to current document. |
| INHERIT_ALL_REPLACE     | Inherit both config and content. Same as `INHERIT_CONTENT_REPLACE`               |
| INHERIT_ALL_APPEND      | Inherit both config and content. Same as `INHERIT_CONTENT_APPEND`                |

##Return Value
- Current instance of document (`$this`). Makes Method Chainable.

##Usage
```php
$parent = new Document('Lorem Ipsum dol sidur.....', ['title'=> 'Not A Random Title', 'layout' => 'grid']);
$document = new Document('Lorem Ipsum.....', ['title'=> 'Random Title', 'category' => 'just another category']);

$document->inherit($parent);

$document->getConfig();
//['title'=> 'Random Title', 'layout'=> 'grid', 'category' => 'just another category']

```
