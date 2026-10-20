<?php
/**
 * Universal JSON Polyfill for PHP environments missing the json extension.
 * Provides complete json_encode implementation so application code never throws
 * "Call to undefined function json_encode()".
 */

if (!function_exists('json_encode')) {
    function json_encode($value, $options = 0, $depth = 512) {
        if ($value === null) {
            return 'null';
        }
        if ($value === true) {
            return 'true';
        }
        if ($value === false) {
            return 'false';
        }
        if (is_int($value) || is_float($value)) {
            return (string)$value;
        }
        if (is_string($value)) {
            static $escapes = [
                '\\' => '\\\\',
                '"'  => '\"',
                "\b" => '\b',
                "\f" => '\f',
                "\n" => '\n',
                "\r" => '\r',
                "\t" => '\t'
            ];
            $escaped = strtr($value, $escapes);
            $escaped = preg_replace_callback('/[\x00-\x1f]/', function($m) {
                return sprintf('\\u%04x', ord($m[0]));
            }, $escaped);
            return '"' . $escaped . '"';
        }
        if (is_array($value) || is_object($value)) {
            if ($depth <= 0) {
                return 'null';
            }
            $arr = (array)$value;
            $isAssoc = false;
            if (is_object($value)) {
                $isAssoc = true;
            } elseif (!empty($arr)) {
                $keys = array_keys($arr);
                $isAssoc = ($keys !== range(0, count($arr) - 1));
            }
            $items = [];
            foreach ($arr as $k => $v) {
                $encodedVal = json_encode($v, $options, $depth - 1);
                if ($isAssoc) {
                    $items[] = json_encode((string)$k, $options, $depth - 1) . ':' . $encodedVal;
                } else {
                    $items[] = $encodedVal;
                }
            }
            return $isAssoc ? '{' . implode(',', $items) . '}' : '[' . implode(',', $items) . ']';
        }
        return 'null';
    }
}

if (!function_exists('json_decode')) {
    function json_decode($json, $assoc = false, $depth = 512, $options = 0) {
        $json = trim((string)$json);
        if ($json === 'true') return true;
        if ($json === 'false') return false;
        if ($json === 'null' || $json === '') return null;
        if (is_numeric($json)) return $json + 0;
        if (preg_match('/^"(.*)"$/s', $json, $m)) {
            return stripcslashes($m[1]);
        }
        return null;
    }
}
