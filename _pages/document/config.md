#Config
##Get Config
Returns config value(s).

**Description**
```php
mixed Document::getConfig([string $varName]);
```
**Parameters**
- `$varName`: Name of the config value to be retrieved (optional).

**Return Values**
- If no argument is provided, it'll return entire config.
- If an agrument is provided, it'll return corresponding value.

**Usage**
```php
$document->getConfig('title'); //'title'
$document->getConfig(); //['title' => 'test', 'layout' => 'layout.html']
```

##Set Config
This method sets config value(s).

**Description**
```php
$this Document::setConfig(mixed $prop [, mixed $value])
```

**parameters**
- `$prop`: If an (associative) `array` is provided, entire config will be overwritten. If a `string` is provided, second argument will be its value.
- `value`: Value to be assigned to `$prop`. Only applicable if `$prop` is string. Default value is `null`

**Return Value**
- Current instance of document (`$this`). Makes Method Chainable.

**Usage**
```php
$document->setConfig('title', 'Another Title');
$document->getConfig(); //['title' => 'Another Title', 'layout' => 'layout.html']

$document->setConfig(['title'=> 'Random Title', 'category' => 'yet another category']);
$document->getConfig();//['title'=> 'Random Title', 'category' => 'yet another category']
```
