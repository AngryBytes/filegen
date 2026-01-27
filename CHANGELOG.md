# Changelog

## 0.5.2

- Compatible with Symfony 6, 7 and 8.

## 0.5.1

### PHP support

- Added support for PHP `8.5`.

## 0.5.0

### PHP support

- Dropped support for PHP `8.1` and lower.
- Added support for PHP `8.4`.
- Compatible with Symfony 6 and 7.

## 0.4.0

### PHP support

- Dropped support for PHP `8.0` and lower.
- Added support for PHP `8.3`.

## 0.3.1

### PHP support

- Added support for PHP `8.2`.

## 0.3.0

### PHP support

- Dropped support for PHP `7.3`.
- Added support for PHP `8.1`.

### 3rd party updates

- Updated `symfony/filesystem` to version `5`.

### Breaking changes

- The `Naneau\FileGen\Directory::scan(string $path)` method now returns `null`
  instead of `false`, if no child node is found.

## 0.2.0

### PHP support

- Dropped support for PHP `7.2`.
- Added support for PHP `8.0`.

### 3rd party updates

- Updated `symfony/filesystem` to version `4`.

## 0.1.0

### PHP support

- Dropped support for PHP `7.1`.
- Added support for PHP `7.2`, `7.3` and `7.4`.

### 3rd party updates

- Updated `symfony/filesystem` to version `4.4`.

## 0.0.5

### PHP support

- Dropped support for PHP `5.5`, `5.4` and `5.3`.
- Dropped support for HHVM.
- Added support for PHP `7.1`.

### 3rd party updates

- Updated `symfony/filesystem` to version `3`.

### Renamed logic

- Renamed `Naneau\FileGen\File\Contents\String` to `Naneau\FileGen\File\Contents\StringBased`
  as `String` is a reserved keyword in PHP `7`.
