Compact
=======

[![Build Status][]](https://travis-ci.org/phine/lib-compact)
[![Coverage Status][]](https://coveralls.io/r/phine/lib-compact)
[![Latest Stable Version][]](https://packagist.org/packages/phine/compact)
[![Total Downloads][]](https://packagist.org/packages/phine/compact)

A PHP library for compacting the contents of files.

Requirement
-----------

- PHP >= 5.3.3
- [Phine Exception] >= 1.0.0

Installation
------------

Via [Composer][]:

    $ composer require "phine/compact=~1.0"

Usage
-----

The Compact library provides a consistent way of compacting files and their
contents. The purpose of the library is simply to reduce the size of the
contents without affecting how it is used. For example, compacting a JSON
file would involve removing any excess whitespace that was used for "pretty
printing".

```php
use Phine\Compact\Json;

$compactor = new Json();

echo $compactor->compactFile('example.json');

// which is also the same as

echo $compactor->compactContents(file_get_contents('example.json'));
```

Assuming we had this in `example.json`:

```json
{
    "name": 123
}
```

The contents would then be compacted to:

```json
{"name":123}
```

### Bundled Compactors

The library also includes the following compactor classes:

- `Phine\Compact\Json` &mdash; For compacting JSON files.
- `Phine\Compact\Php` &mdash; For compacting PHP files.
- `Phine\Compact\Xml` &mdash; For compacting XML files.

### Creating a Compactor

The library includes an interface that all bundled classes implement. An
abstract class is also included, which all bundled compactor classes extend.
When you create your own compactor class, you will want to extend the
`Phine\Compact\AbstractCompact` class.

```php
use Phine\Compact\AbstractCompact;

/**
 * Simply trims all lines.
 */
class Trim extends AbstractCompact
{
    /**
     * {@inheritDoc}
     */
    public function compactContents($contents)
    {
        $contents = preg_replace('/^\s+/m', '', $contents);
        $contents = preg_replace('/\s+$/m', '', $contents);

        return $contents;
    }
}
```

When extending the `AbstractCompact` class, the `compactFile()` method will
already be implemented for you. It will rely on the `compactContents()` method
to compact the contents after it has been read from the file.

Documentation
-------------

You can find the API [documentation here][].

License
-------

This library is available under the [MIT license](LICENSE).

[Build Status]: https://travis-ci.org/phine/lib-compact.png?branch=master
[Coverage Status]: https://coveralls.io/repos/phine/lib-compact/badge.png
[Latest Stable Version]: https://poser.pugx.org/phine/compact/v/stable.png
[Total Downloads]: https://poser.pugx.org/phine/compact/downloads.png
[Phine Exception]: https://github.com/phine/lib-exception
[Phine Observer]: https://github.com/phine/lib-observer
[Phine Path]: https://github.com/phine/lib-path
[Composer]: http://getcomposer.org/
[documentation here]: http://phine.github.io/lib-compact
