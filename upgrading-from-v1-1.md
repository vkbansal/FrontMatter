---
---
#Upgrading from v1.1

##Format change
Since **v1.2**, The following format for json is depricated. Will be removed in **v1.3**
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
;;;
```
The following is the new format to be followed.
```
--- json
{
    "layout": "custom",
    "my_list": [
      "one",
      "two",
      "three"
    ]
}
---
Main Title
-----
### Subtilte

Lorem ipsum......
```

##Parser::dump() signature change
```php
Parser::dump($document, true);
```
will be replaced by
```php
Parser::dump($document, Parser::DUMP_JSON);
```