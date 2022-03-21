<?php
    namespace xbweb;

    abstract class BasicObject {
        /**
         * Getter
         * @param string $name  Parameter name
         * @return mixed
         */
        function __get($name) {
            return property_exists($this, '_'.$name) ? $this->{'_'.$name} : null;
        }

        /**
         * Setter
         * @param string $name   Parameter name
         * @param mixed  $value  Parameter value
         * @return mixed
         */
        function __set($name, $value) {
            if (method_exists($this, "set_{$name}")) return $this->{"set_{$name}"}($value);
            return null;
        }
    }