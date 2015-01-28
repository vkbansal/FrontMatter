#Validate
Checks if given content has valid structure. It automatically handles formats.

**Description**
```php
boolean Parser::isValid(string $content)
```
**Parameters**
- `$content`: `string` to be validated.
**Return Values**
- `true`: if content is valid.
- `false`: if content is invalid.

**Usage**
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
