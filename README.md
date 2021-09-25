# Laravel объекты-значение

## Требования

`PHP ^8`

## Установка

- Добавить репозиторий(или `git@github.com:doox911-opensource/laravel-value-objects.git`);
  ```json
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/doox911-opensource/laravel-value-objects.git"
    }
  ]
  ```
- Добавить зависимость: `composer require doox911-opensource/laravel-value-objects`;

## Использование

### Создание объекта-значение

```php

use Doox911Opensource\ValueObjects\Classes\AbstractValueObject;

final class MyValueObject extends AbstractValueObject
{

    protected $id;
}
```

### Получение значения свойства объекта-значение

```php
$MyValueObject = new MyValueObject([
  'id' => 1,
]);

$MyValueObject->id; //1
$MyValueObject->getId(); //1
```

## Проверка входящих значений для свойств

### Через метод
```php

use Doox911Opensource\ValueObjects\Classes\AbstractValueObject;
use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;

final class MyValueObject extends AbstractValueObject
{

    protected $id;
    
    /**
     * Валидатор
     *
     * Вызовется автоматически
     *
     * @throws ValueObjectsException
     */
    protected function idAssert($id): void
    {
      if (!is_integer($id) || $id < 1) {
        throw new ValueObjectsException('Invalid property id');
      }
    }
}
```
> Имя assert-метода формируется из префикса имени свойства в `camelCase` и суффикса `Assert`.

### Через атрибуты
```php

use Doox911Opensource\ValueObjects\Classes\AbstractValueObject;

final class MyValueObject extends AbstractValueObject
{
    #[MyAssert]
    protected $id;
}
```
> Атрибут должен реализовывать интерфейс `ValueObjectAssertAttributeContract`.