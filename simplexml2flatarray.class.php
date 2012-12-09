<?php

/**
 * SimpleXML2FlatArray
 * 
 * Converts an XML document to several flat arrays containing values from
 * parent elements using SimpleXML.
 * 
 * Useful for storing xml data in a database.
 * 
 * Usage:
 * 
 * - Option 1: Load XML data from file and parse
 *      $data = new SimpleXML2FlatArray(simplexml_load_file('data.xml'));
 *      $data = $data->get();
 * 
 * - Option 2: Load XML from variable
 *      $data = new SimpleXML2FlatArray($xml);
 *      $data = $data->get();
 * 
 * @author  Kristoffer Rødsdalen Hagen <kristoffer.r.hagen@gmail.com>
 * @link    https://github.com/kristofferhagen/SimpleXML2FlatArray
 * @license http://opensource.org/licenses/mit-license.php
 */
class SimpleXML2FlatArray
{
    /**
     * Result container
     * 
     * Contains flat arrays
     */
    protected $rows = array();

    /**
     * Constructor
     */
    public function __construct(SimpleXMLElement $xml, $defaults = array())
    {
        $this->parse($xml, array(), $defaults); 
    }

    /**
     * Get result
     * 
     * @return array Resulting flat arrays
     */
    public function get()
    {
        return $this->rows;
    }
    
    /**
     * Parse XML
     * 
     * @return array Array containing values
     */
    private function parse($xml, $values = array(), $defaults = array())
    {
        // Get children of xml document
        $children = $xml->children();
        
        // Whether the children has children of their own
        $children_is_parent = FALSE;

        // Get each child and add to $values if it has no children of its own
        foreach ($children as $key => $child)
        {
            // Remove unnecessary whitespace from value of the child
            $val = trim((string) $child);

            // Add value to buffer
            if ($val != '')
            {
                $values[$key] = $val;
            }

            // If the child has children of its own, parse it recursively
            if ($child->count() > 0)
            {
                $children_is_parent = TRUE;
                $this->parse($child, $values, $defaults);
            }
        }

        // If the child has no children of its own, store the information
        // from $values buffer to $this->rows result container
        if (!$children_is_parent)
        {
            $this->rows[] = array_merge($defaults, $values);
        }
    }
}

