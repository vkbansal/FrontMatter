#Changelog

All the changes can be found below. Order used:
 - Added
 - Changed
 - Deprecated
 - Removed
 - Fixed
 - Security

##[master]

##v1.3.2

### Changed
 - Updated dependencies
   - `symfony/yaml` => '2.7.*'

 - Updated dev dependencies
   - `phpunit/phpunit` => '4.7.*'

##v1.3.1

### Changed
 - Updated dependencies
   - `symfony/yaml` => '2.6.*'

 - Updated dev dependencies
   - `phpunit/phpunit` => '4.4.*'
   - `phpspec/phpspec` => '2.1.*'

##v1.3.0

### Removed
 - Removed deprecated features.

##v1.2.0

### Added
 - Added `ini` support.

### Changed
- Changed how formats are parsed. see [#9](./issues/9).
- `Parser::dump()` signature updated.

### Deprecated
- `json` format using `;;;` has been deprecated. `Parser::parse()` and `Parser::dump($document, true)` will still work. **Will be Removed in v1.3**.


##v1.1.1

### Added
- Made methods chaninable

##v1.1.0

### Added
 - Added `Parser::isValid()`
 - Added `Document::merge()`
 - Added `Document::inherit()`

##v1.0.0

### Added
 - Header/Config can now also be accessed via properties

##v0.1.1

### Changed
 - Updated `symfony/yaml` requirement

##v0.1.0
- Initial release
