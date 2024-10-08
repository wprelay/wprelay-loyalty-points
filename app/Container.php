<?php

namespace RelayWP\LPoints\App;

class Container
{
    public $bindings = [];

    public function set($key, $value)
    {
        if (isset($this->bindings[$key])) {
            return $this->bindings[$key];
        }


        $this->bindings[$key] = $value;
        return $this->bindings[$key];
    }

    public function get($key)
    {
        if (isset($this->bindings[$key])) {
            return $this->bindings[$key];
        }
    }
}

