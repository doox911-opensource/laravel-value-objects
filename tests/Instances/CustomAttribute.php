<?php

  namespace Doox911Opensource\ValueObjects\Tests\Instances;

  use Attribute;
  use function is_integer;
  use Doox911Opensource\ValueObjects\Contracts\ValueObjectAssertAttributeContract;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;

  #[Attribute(Attribute::TARGET_PROPERTY)]
  final class CustomAttribute implements ValueObjectAssertAttributeContract
  {

    /**
     * @throws ValueObjectsException
     * @see ValueObjectAssertAttributeContract::assert()
     */
    public function assert(mixed $value): void
    {
      if (!is_integer($value) || $value < 1) {
        throw new ValueObjectsException('Invalid value');
      }
    }
  }
