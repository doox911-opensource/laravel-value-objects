<?php

  namespace Doox911Opensource\ValueObjects\Classes;

  use Throwable;
  use ReflectionClass;
  use ReflectionProperty;
  use Illuminate\Support\Str;
  use function method_exists;
  use function get_class_vars;
  use function property_exists;
  use Doox911Opensource\ValueObjects\Contracts\ValueObjectsContract;
  use Doox911Opensource\ValueObjects\Exceptions\ValueObjectsException;

  abstract class AbstractValueObject implements ValueObjectsContract
  {

    /**
     * @param array $properties Свойства
     * @throws ValueObjectsException
     */
    public function __construct(array $properties)
    {
      $class = new ReflectionClass(static::class);

      foreach ($class->getProperties() as $property) {

        /**
         * Если переданное имя свойства существует в классе:
         * * Проверяем;
         * * Инициализируем.
         */
        if (isset($properties[$property->name])) {

          /**
           * Проверка входящих данных
           */
          $this
            ->runAssertMethod($property, $properties[$property->name])
            ->runAssertAttribute($property, $properties[$property->name]);

          $this->{$property->name} = $properties[$property->name];
        } else {
          $this->setDefaultProperty($property->name);
        }
      }
    }

    /**
     * @param string $method Метод
     * @param array $arguments Аргументы
     * @return void
     * @throws ValueObjectsException
     */
    public static function __callStatic(string $method, array $arguments)
    {
      throw new ValueObjectsException('Static methods are not available');
    }

    /**
     * Получить имя свойства
     *
     * @param string $method Метод
     * @return string
     */
    private static function getPropertyName(string $method): string
    {
      $length = Str::length($method);
      $property = Str::substr($method, 3, $length);

      return Str::camel($property);
    }

    /**
     * Получить имя свойства из метода
     *
     * @param string $method Имя метода
     * @return string
     */
    private static function getPropertyNameFromMethod(string $method): string
    {
      $camel_property = self::getPropertyName($method);

      return Str::snake($camel_property);
    }

    /**
     * Преобразование в массив
     *
     * @return array
     */
    final public function toArray(): array
    {
      $items = [];

      $properties = get_class_vars(static::class);

      foreach ($properties as $key => $value) {
        $items[$key] = $this->{$key};
      }

      return $items;
    }

    /**
     * Массив для сохранения в базу данных
     *
     * Удалён уникальный идентификатор.
     * Баг в laravel @link https://stackoverflow.com/q/67092809/10876086
     *
     * @return array
     */
    final public function toArrayFromStore(): array
    {
      $items = $this->toArray();

      unset($items['id']);

      return $items;
    }

    /**
     * Отдаём только существующие свойства
     *
     * @param string $property Свойство
     * @return mixed
     * @throws ValueObjectsException
     */
    public function __get(string $property)
    {
      if (!property_exists($this, $property)) {
        throw new ValueObjectsException("Property [$property] does not exist");
      }

      return $this->{$property};
    }

    /**
     * Запрещаем создание новых свойств
     *
     * @param string $name Имя свойства
     * @param mixed $value Значение свойства
     * @throws ValueObjectsException
     */
    public function __set(string $name, mixed $value)
    {
      throw new ValueObjectsException('Forbidden');
    }

    /**
     * @param string $method Метод
     * @param array $arguments Аргументы
     * @return mixed
     * @throws ValueObjectsException
     */
    public function __call(string $method, array $arguments)
    {
      $property = self::getPropertyNameFromMethod($method);

      if (property_exists($this, $property)) {
        return $this->{$property};
      } else {
        throw new ValueObjectsException("Method [$method] does not exist");
      }
    }

    /**
     * @param $name
     * @throws ValueObjectsException
     */
    public function __isset($name)
    {
      throw new ValueObjectsException('Method forbidden');
    }

    /**
     * @param $name
     * @throws ValueObjectsException
     */
    public function __unset($name)
    {
      throw new ValueObjectsException('Any deletion is forbidden');
    }

    /**
     * Установить свойства по умолчанию
     *
     * Если есть свойство, которые необходимо установить по умолчанию, переопределите метод
     *
     * @param string $property Имя свойства домена
     * @throws ValueObjectsException
     */
    protected function setDefaultProperty(string $property)
    {
      throw new ValueObjectsException("Property $property must be initialization");
    }

    /**
     * Проверка входных данных через атрибуты
     *
     * @param ReflectionProperty $property Свойство класса
     * @param mixed $value Устанавливаемое значение
     * @throws ValueObjectsException
     */
    private function runAssertAttribute(ReflectionProperty $property, mixed $value): static
    {
      foreach ($property->getAttributes() as $attribute) {
        try {
          if (method_exists($attribute->getName(), 'assert')) {
            $attribute
              ->newInstance()
              ->assert($value);
          }
        } catch (Throwable $e) {
          throw new ValueObjectsException($e->getMessage());
        }
      }

      return $this;
    }

    /**
     * Проверка входных данных через метод
     *
     * @param ReflectionProperty $property Свойство класса
     * @param mixed $value Устанавливаемое значение
     * @return $this
     */
    private function runAssertMethod(ReflectionProperty $property, mixed $value): static
    {
      $validator = $property->name . 'Assert';

      if (method_exists($this, $validator)) {
        $this->{$validator}($value);
      }

      return $this;
    }
  }
