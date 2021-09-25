<?php

  namespace Doox911Opensource\ValueObjects\Tests\Instances;

  use function is_integer;
  use Doox911Opensource\ValueObjects\Classes\AbstractValueObject;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;

  /**
   * @property int $id
   * @method int getId()
   */
  final class CustomValueObject extends AbstractValueObject
  {
    #[CustomAttribute]
    protected int $id;

    /**
     * Для теста
     *
     * Правильно использовать либо методы, либо атрибуты.
     *
     * @throws ValueObjectsException
     */
    protected function idAssert(mixed $value): void
    {
      if (!is_integer($value) || $value < 1) {
        throw new ValueObjectsException('Invalid value');
      }
    }
  }
