<?php

  namespace Doox911Opensource\ValueObjects\Providers;

  use Illuminate\Support\ServiceProvider;
  use Doox911Opensource\ValueObjects\Classes\AbstractValueObject;
  use Doox911Opensource\ValueObjects\Contracts\ValueObjectsContract;

  class ValueObjectServiceProvider extends ServiceProvider
  {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->singleton(ValueObjectsContract::class, AbstractValueObject::class);
    }
  }
