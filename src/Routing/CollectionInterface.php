<?php

namespace Routing;

interface CollectionInterface extends \IteratorAggregate
{

    public function get();

    public function set(array $routes);

    public function merge(array $routes);

    public function has($path);

    public function route($path);
}
