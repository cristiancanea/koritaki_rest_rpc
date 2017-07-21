<?php
namespace koritaki\Response;

abstract class AbstractResponse {
    protected $_data;

    public function __construct( ) {
        $this->_data = [];
    }

    /**
     * set data - args:
     * 1: value/array
     * 2: key , value
     */
    public function set() {
        $args = func_get_args();
        if (count($args) == 1) {
            //array
            if (is_array($args[0])) {
                $this->_data = array_merge_recursive($this->_data, $args[0]);
            } else {
                //not array
                $this->_data[] = $args[0];
            }
        } elseif (count($args) == 2) {
            //key - value
            $this->_data[ $args[0] ] = $args[1];
        }
        return $this;
    }

    /**
     * Get response data by magic
     * @param $key
     * @return mixed
     */
    public function __get($key) {
        return $this->_data[$key];
    }

    abstract public function output();
}