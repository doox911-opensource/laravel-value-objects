<?php

  namespace Doox911Opensource\ValueObjects\Contracts;

  interface ValueObjectAssertAttributeContract
  {

    /**
     * @param mixed $value Устанавливаемое значение
     */
    public function assert(mixed $value): void;
  }
