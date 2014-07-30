<?php
require_once "large_integer.php";
class Large_IntegerTest extends PHPUnit_Framework_TestCase {

    /**
     * @dataProvider constructorProvider
     */
    public function testConstructor($str) {
        $eMessage = null;
        try {
            new LargeInteger($str);
        } catch(Exception $e) {
            $eMessage = $e->getMessage();
        }
        echo $eMessage;
        $this->assertEquals($eMessage, 'Only positive numbers allowed');
    }

    public function constructorProvider() {
        return array(
            array("-1"),
            array("1a"),
            array("a1"),
            array(" b2")
        );
    }

    /**
     * @dataProvider getValueProvider
     */
    public function testGetValue($str, $expected) {
        $a = new LargeInteger($str);
        $this->assertEquals($a->get_value(), $expected);
    }

    public function getValueProvider() {
        return array(
            array("1", "1"),
            array("000000000000000000000000001", "1"),
            array("00000000000000100000000000000000000000000000000000000000000000000000000000000000000000000000000000", "100000000000000000000000000000000000000000000000000000000000000000000000000000000000"),
            array("11111111111111111111111111111111111111111199999999999999999999999999999999999999999999999999999999", "11111111111111111111111111111111111111111199999999999999999999999999999999999999999999999999999999"),
            array("10192987982364592695619562225694529346927365926259256925693692768540000000000000", "10192987982364592695619562225694529346927365926259256925693692768540000000000000")
        );
    }

    /**
     * @dataProvider equalToProvider
     */
    public function testEqualto($a, $b) {
        $a = new LargeInteger($a);
        $b = new LargeInteger($b);
        $res = $a->equal_to($b);
        $this->assertTrue($res);
    }

    public function equalToProvider() {
        return array(
            array("1", "1"),
            array("000000000001", "1"),
            array("11155555555555555555555555555555555555555555555555555555555555555555500000000000000000000", "11155555555555555555555555555555555555555555555555555555555555555555500000000000000000000"),
            array("000000000000000000000000000000000000000010000000000000000000000001", "000000000000000000000000000000000000000010000000000000000000000001")
        );
    }

    /**
     * @dataProvider notEqualToProvider
     */
    public function testNotEqualTo($a, $b) {
        $a = new LargeInteger($a);
        $b = new LargeInteger($b);
        $res = $a->not_equal_to($b);
        $this->assertTrue($res);
    }

    public function notEqualToProvider() {
        return array(
            array("1", "2"),
            array("000000000001", "12"),
            array("111555555555555555255555555555555555555555555555555555555555555555555500000000000000000000", "11155555555555555555555555555555555555555555555555555555555555555555500000000000000000000"),
            array("0000000000000000000200000000000000000000010000000000000000000000001", "000000000000000000000000000000000000000010000000000000000000000001")
        );
    }

    /**
     * @dataProvider greaterThanProvider
     */
    public function testGreaterThan($a, $b) {
        $a = new LargeInteger($a);
        $b = new LargeInteger($b);
        $res = $a->greater_than($b);
        $this->assertTrue($res);
    }

    public function greaterThanProvider() {
        return array(
            array("222222220011111000", "000002222222222220"),
            array("222222220011111000", "2222222222220"),
            array("2", "1"),
            array("02", "0001"),
            array("03000000000000000", "0002000000000000000"),
            array("1111111111111111111111111111111111111111111111111111111111111111111111111", "111111111111111111111111111111111111111111111111111111111111111101")
        );
    }

    /**
     * @dataProvider lessThanProvider
     */
    public function testLessThan($a, $b) {
        $a = new LargeInteger($a);
        $b = new LargeInteger($b);
        $res = $a->less_than($b);
        $this->assertTrue($res);
    }

    public function lessThanProvider() {
        return array(
            array("1", "2"),
            array("0001", "02"),
            array("0002000000000000000", "03000000000000000"),
            array("111111111111111111111111111111111111111111111111111111111111111101", "1111111111111111111111111111111111111111111111111111111111111111111111111")
        );
    }

    /**
     * @dataProvider greaterOrEqualThanProvider
     */
    public function testGreaterOrEqual($a, $b) {
        $a = new LargeInteger($a);
        $b = new LargeInteger($b);
        $res = $a->greater_or_equal_than($b);
        $this->assertTrue($res);
    }

    public function greaterOrEqualThanProvider() {
        return array(
            array("1", "1"),
            array("0001", "01"),
            array("2222222222220", "0011111000"),
            array("2222222222222222222222111111111111111111111111111111111111111111111111111111111111111101", "1111111111111111111111111111111111111111111111111111111111111111111111111")
        );
    }

    /**
     * @dataProvider lesserOrEqualThanProvider
     */
    public function testLesserOrEqual($a, $b) {
        $a = new LargeInteger($a);
        $b = new LargeInteger($b);
        $res = $a->less_or_equal_than($b);
        $this->assertTrue($res);
    }

    public function lesserOrEqualThanProvider() {
        return array(
            array("1", "1"),
            array("0001", "01"),
            array("2222222222220", "222222220011111000"),
            array("2222222222222222222222111111111111111111111111111111111111111111111111111111111111111101", "66666666666666666666666666666666666666666666666666666666666666666666666661111111111111111111111111111111111111111111111111111111111111111111111111")
        );
    }

    /**
     * @dataProvider addProvider
     */
    public function testAdd($a, $b, $expected) {
        $a = new LargeInteger($a);
        $b = new LargeInteger($b);
        $this->assertEquals($a->add($b)->get_value(), $expected);
    }

    public function addProvider() {
        return array(
            array("0000000000000000000000001", "1", "2"),
            array("0000000000000000000000003", "1000", "1003"),
            array("1", "100000000000000000000000000000000000000", "100000000000000000000000000000000000001"),
            array("11111111111111111111111111", "22222222222222222222222222", "33333333333333333333333333"),
        );
    }
}