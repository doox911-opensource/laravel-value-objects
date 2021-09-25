<?php

  namespace Doox911Opensource\ValueObjects\Contracts;

  interface ValueObjectsContract
  {

    /**
     * Преобразование в массив
     *
     * @return array
     */
    public function toArray(): array;
  }
