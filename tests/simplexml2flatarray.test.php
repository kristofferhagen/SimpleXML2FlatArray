<?php

require '../simplexml2flatarray.class.php';

class SimpleXML2FlatArray_Test extends PHPUnit_Framework_TestCase
{
    /**
     * Test SimpleXML2FlatArray::get() output is correct array
     */
    public function testGetArrayOutputIsCorrectArray()
    {
        $expected_array = array(
            array(
                "child" => "child1 value",
                "child11" => "child11 value",
                "child12" => "child12 value",
                "testDefault" => "testDefault value"
            ),
            array(
                "child" => "child2 value",
                "child21" => "child21 value",
                "child22" => "child22 value",
            )
        );
        
        $xml = simplexml_load_file('testfile.xml');
        $data = new SimpleXML2FlatArray($xml);
        $data = $data->get();

        $this->assertInternalType('array', $data);
        $this->assertEquals($expected_array, $data);
    }
    
    /**
     * Test get with default value
     */
    public function testGetWithDefaultValue()
    {
        $expected_array = array(
            array(
                "child" => "child1 value",
                "child11" => "child11 value",
                "child12" => "child12 value",
                "testDefault" => "testDefault value"
            ),
            array(
                "child" => "child2 value",
                "child21" => "child21 value",
                "child22" => "child22 value",
                "testDefault" => "testDefault value"
            )
        );
        
        $xml = simplexml_load_file('testfile.xml');
        $data = new SimpleXML2FlatArray($xml, array(
            "testDefault" => "testDefault value"
        ));
        $data = $data->get();

        $this->assertInternalType('array', $data);
        $this->assertEquals($expected_array, $data);
    }
}
