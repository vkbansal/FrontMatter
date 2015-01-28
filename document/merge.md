---
---
#Merge
Merge other document into current document.

##Description
```php
$this Document::merge(Document $newDoc [, int $mode = Document::MERGE_CONFIG])
```
##Parameters
- `$newDoc` : The document to be merged in.
- `$mode`: Mode to be used while merging. Default mode `Document::MERGE_CONFIG`

##Modes

| Mode Constant         | Mode Description                                                             |
|-----------------------|------------------------------------------------------------------------------|
| MERGE_CONFIG          | Merge only config.                                                           |
| MERGE_CONTENT_REPLACE | Merge only content. Replaces current content with that from merging document |
| MERGE_CONTENT_APPEND  | Merge only content. Appends content from merging document to current one.    |
| MERGE_ALL_REPLACE     | Merge both config and content. Same as `MERGE_CONTENT_REPLACE`.              |
| MERGE_ALL_APPEND      | Merge both config and content. Same as `MERGE_CONTENT_APPEND`.               |

##Return Value
- Current instance of document (`$this`). Makes Method Chainable.

##Usage
```php
$document = new Document('Lorem Ipsum dol sidur.....', ['title'=> 'Not A Random Title', 'layout' => 'grid']);
$newDoc = new Document('Lorem Ipsum.....', ['title'=> 'Random Title', 'category' => 'just another category']);

$document->merge($newDoc);

$document->getConfig();
//['title'=> 'Random Title', 'layout'=> 'grid', 'category' => 'just another category']
```
