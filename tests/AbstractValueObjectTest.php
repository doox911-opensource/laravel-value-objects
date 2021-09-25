<?php

  namespace Doox911Opensource\ValueObjects\Tests;

  use ReflectionException;
  use Orchestra\Testbench\TestCase;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;
  use Doox911Opensource\ValueObjects\Tests\Instances\CustomValueObjectInstance;

  class AbstractValueObjectTest extends TestCase
  {

    /**
     * Невалидный объект-значение(VO)
     *
     * @throws ReflectionException
     */
    public function testInvalid()
    {
      $this->expectException(ValueObjectsException::class);

      CustomValueObjectInstance::invalidNew();
    }

    /**
     * Доступность свойства VO
     *
     * @throws ValueObjectsException
     * @throws ReflectionException
     */
    public function testId()
    {
      $instance = CustomValueObjectInstance::new(100);

      $this->assertEquals(100, $instance->id);
    }

    /**
     * Доступность метода VO
     *
     * @throws ValueObjectsException
     * @throws ReflectionException
     */
    public function testMethodId()
    {
      $instance = CustomValueObjectInstance::new(100);

      $this->assertEquals(100, $instance->getId());
    }

    /**
     * VO в массив
     *
     * @throws ValueObjectsException
     * @throws ReflectionException
     */
    public function testToArray()
    {
      $instance = CustomValueObjectInstance::new(100);

      $this->assertSame(['id' => 100], $instance->toArray());
    }

    /**
     * VO в массив для сохранения в БД(без поля id)
     *
     * @throws ValueObjectsException
     * @throws ReflectionException
     */
    public function testToArrayFromStore()
    {
      $instance = CustomValueObjectInstance::new(1);

      $this->assertSame([], $instance->toArrayFromStore());
    }
  }
