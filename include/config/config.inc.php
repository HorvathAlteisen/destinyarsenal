<?php

namespace config;

class Config {

    private $_pathToConfig;
    private $_configArr = array();

    public function __construct(string $pathToConfig) {

        $this->_parse($pathToConfig);

    }

    private function _parse(string $pathToConfig) : void {

        $f = file_get_contents($pathToConfig);

        $this->_configArr = json_decode($f, true);

    }

    public function get($key) {

        $keys = explode('.', $key);
        $base = &$this->_configArr;
        $size = sizeof($keys)-1;

        for($i = 0; $i < $size; $i++) {
            $currentKey = $keys[$i];
            if(is_array($base[$currentKey]) && array_key_exists($currentKey, $base)) {
                $base = &$base[$currentKey]; 
            } else {
                return null;
            }
        }

        $currentKey = $keys[$size];
		if (array_key_exists($currentKey, $base)) {
            $value = &$base[$currentKey];

			return $value;
		}
		else {
			// We want to avoid a traditional PHP error when referencing
			// non-existent keys, so we'll silently return null as an
			// alternative ;)
			return null;
		}
    }
}
?>