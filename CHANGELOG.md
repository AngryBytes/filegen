# Changelog

## 0.1.1

### PHP support
* Dropped support for PHP `7.1`.
* Added support for PHP `7.2`, `7.3` and `7.4`.

### 3rd party updates
* Updated `symfony/filesystem` to version `4.4`.

## 0.1.0

**Note:** Broken release, use `0.1.1` instead.

## 0.0.5

### PHP support
* Dropped support for PHP `5.5`, `5.4` and `5.3`.
* Dropped support for HHVM.
* Added support for PHP `7.1`.

### 3rd party updates
* Updated `symfony/filesystem` to version `3`.

### Renamed logic
* Renamed `Naneau\FileGen\File\Contents\String` to `Naneau\FileGen\File\Contents\StringBased` 
  as `String` is a reserved keyword in PHP `7`.
