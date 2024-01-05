<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;


class EloquentDatabase extends Capsule
{
  public function __construct()
  {
    parent::__construct();

    parent::addConnection([
      'driver' => 'mysql',
      'host' => $_ENV["DATABASE_HOST"],
      'database' => $_ENV["DATABASE_NAME"],
      'username' => $_ENV["DATABASE_USER"],
      'password' => $_ENV["DATABASE_PASS"],
      'charset' => 'utf8',
      'collation' => 'utf8_unicode_ci',
      'prefix' => '',
    ]);
    parent::setEventDispatcher(new Dispatcher(new Container));
    parent::setAsGlobal();
    parent::bootEloquent();
  }
}
