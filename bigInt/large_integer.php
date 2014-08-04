<?php
class LargeInteger {
    private $bigInt = null;
    private $res = array();
    private $rest = 0;

    public function __construct($intStr) {
        $intStr = trim($intStr);
        if(!ctype_digit($intStr) || strcmp($intStr, "0") < 1) throw new Exception('Only positive numbers allowed');
        $this->bigInt = ltrim($intStr, "0");
    }

    public function get_value() {
        return $this->bigInt;
    }

    public function equal_to(LargeInteger $toCompare) {
        return $this->bigInt == $toCompare->get_value();
    }

    public function not_equal_to(LargeInteger $toCompare) {
        return !$this->equal_to($toCompare);
    }

    public function greater_than(LargeInteger $toCompare) {
        return $this->_isGreater($toCompare);
    }

    public function less_than(LargeInteger $toCompare) {
        return !($this->greater_than($toCompare) || $this->equal_to($toCompare));
    }

    public function greater_or_equal_than(LargeInteger $toCompare) {
        return $this->equal_to($toCompare) || $this->greater_than($toCompare);
    }

    public function less_or_equal_than(LargeInteger $toCompare) {
        return !$this->greater_than($toCompare);
    }

    public function add(LargeInteger $second_object) {
        $res = $this->_doAdd($this, $second_object);
        return new LargeInteger($res);
    }

    private function _isGreater(LargeInteger $b) {
        $a = $this->bigInt;
        $b = $b->get_value();
        if(strlen($a) > strlen($b)) {
            $b = str_split(str_pad($b, strlen($a), "0", STR_PAD_LEFT));
            $a = str_split($a);
        } else {
            $a = str_split(str_pad($a, strlen($b), "0", STR_PAD_LEFT));
            $b = str_split($b);
        }
        foreach($a as $i => $v) {
            $res = false;
            if($v < $b[$i]) {
                $res = false;
                break;
            } elseif($v > $b[$i]) {
                $res = true;
                break;
            }
        }
        return $res;
    }

    private function _array_reverse(Array $arr) {
        $res = array();
        $j = 0;
        for($i = count($arr); $i--;) {
            $res[$j] = $arr[$i];
            $j++;
        }
        return $res;
    }

    private function _doAdd(LargeInteger $a, LargeInteger $b) {
        $a = $a->get_value();
        $b = $b->get_value();
        $res = null;
        if(strlen($a) > strlen($b)) {
            $iterable = $a;
            $second = $b;
        } else {
            $iterable = $b;
            $second = $a;
        }
        $second = str_split(str_pad($second, strlen($iterable), "0", STR_PAD_LEFT));
        $iterable = str_split($iterable);
        for($i = count($iterable); $i--;) {
            $toRes = $iterable[$i] + $second[$i] + $this->rest;
            $this->rest = 0;
            if($toRes > 9) {
                $arr = str_split((string) $toRes);
                $toRes = $arr[1];
                $this->rest = $arr[0];
            }
            $this->res[] = $toRes;
        }
        $this->res[count($this->res) -1] = $this->res[count($this->res) - 1] + $this->rest;
        $res = implode("", $this->_array_reverse($this->res));
        $this->res = 0;
        return $res;
    }
}