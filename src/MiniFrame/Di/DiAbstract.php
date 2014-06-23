<?php

namespace MiniFrame\Di;

abstract class DiAbstract implements IDi
{
    /**
     * @var array
     */
    protected $items = array();

    /**
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        if (isset($this->items[$name])) {
            $value = $this->items[$name];

            if (is_string($value)) {
                $this->items[$name] = new $value($this);
            }

            if (is_callable($value)) {
                $this->items[$name] = call_user_func_array($value, array($this));
            }

            return $this->items[$name];
        }

        return null;
    }

    /**
     * @param $name
     * @param $value
     * @return $this|mixed
     */
    public function set($name, $value)
    {
        $this->items[$name] = $value;
        return $this;
    }
}
