<?php

namespace MiniFrame\Di;

class DiImpl implements Di
{
    protected $items = [];

    /**
     * @param $name
     * @return mixed|null
     */
    public function reloadShared($name)
    {
        return $this->get($name, true);
    }

    /**
     * @param $name
     * @param bool $reloadShared
     * @return mixed|null
     */
    public function get($name, $reloadShared = false)
    {
        if (isset($this->items[$name])) {
            if ($this->items[$name]['shared_object'] != null && $reloadShared == false) {
                return $this->items[$name]['shared_object'];
            }

            $value = call_user_func_array($this->items[$name]['value'], [$this]);
            if ($this->items[$name]['is_shared']) {
                $this->items[$name]['shared_object'] = $value;
            }
            return $value;
        }
        return null;
    }

    /**
     * @param $name
     * @param $value
     * @param bool $isShared
     * @return mixed|void
     */
    public function set($name, $value, $isShared = false)
    {
        $this->items[$name] = [
            'value' => $value,
            'is_shared' => $isShared,
            'shared_object' => null
        ];

        if (!is_callable($value)) {
            $this->items[$name]['shared_object'] = $value;
        }
    }
}
