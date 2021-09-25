<?php

  namespace Doox911Opensource\ValueObjects\Tests\Instances;

  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;

  final class CustomValueObjectInstance
  {

    /**
     * @throws ValueObjectsException
     */
    public static function new(mixed $id): CustomValueObject
    {
      return new CustomValueObject([
        'id' => $id,
      ]);
    }

    /**
     * @throws ValueObjectsException
     */
    public static function invalidNew(): CustomValueObject
    {
      return new CustomValueObject([
        'id' => '1',
      ]);
    }
  }
