doctrine-dbal-datetime-default-tz
=========================

A Doctine DBAL [Custom Mapping Type](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/cookbook/custom-mapping-types.html) allowing the use of PHP DateTime objects automatically set to the system's default timezone.

Install via composer:

    composer require avoran/doctrine-dbal-datetime-default-tz:~1.0

Add the custom type before instantiating your entity manager:

```php
use Doctrine\DBAL\Types\Type;
Type::addType('datetime_default_tz', 'Avoran\Doctrine\DBAL\Types\DateTimeDefaultTzType');
```
