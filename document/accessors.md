---
---
#Accessors
The following are additional ways of accessing header/config and content of a document.

##Array Access
Document can be used as an `array` for accessing header/config.
```php
echo $document["title"]; // 'Random Title'
$document["category"] = "Some Category";
echo $document["category"];// 'Some Category'
unset($document["category"]);
var_dump(isset($document["category"]));//false
```

##Property Access
Header/Config can also be accessed by property
```php
echo $document->title;// 'Random Title'
$document->category = "Some Other Category";
echo $document->category;// 'Some Other Category'
unset($document->category);
var_dump(isset($document->category));//false
```

##Document as string
Document can be used as string. It returns the document content/body.
```php
echo $document;// `Lorem ipsum`
```
