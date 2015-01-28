---
---
#Changelog

##v1.3.1
- Updated dependencies
    - `symfony/yaml` => '2.6.*'

- Updated dev dependencies
    - `phpunit/phpunit` => '4.4.*'
    - `phpspec/phpspec` => '2.1.*'

##v1.3.0
- Removed deprecated features.

##v1.2.0
- Changed how formats are parsed. see [#9](./issues/9).
- `json` format using `;;;` has been deprecated. `Parser::parse()` and `Parser::dump($document, true)` will still work. **Will be Removed in v1.3**.
- Added `ini` support.
- `Parser::dump()` signature updated.

##v1.1.1
- Made methods chaninable

##v1.1.0
- Added `Parser::isValid()`
- Added `Document::merge()`
- Added `Document::inherit()`

##v1.0.0
- Header/Config can now also be accessed via properties

##v0.1.1
- Updated `symfony/yaml` requirement

##v0.1.0
- Initial release
