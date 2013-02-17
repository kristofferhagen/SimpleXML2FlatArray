<?php

namespace KristofferHagen\Library\SimpleXML2FlatArray;

/**
 * SimpleXML2FlatArray
 * 
 * Converts an XML document to several flat arrays containing values from
 * parent elements using SimpleXML.
 * 
 * Useful for storing xml data in a database.
 * 
 * @author  Kristoffer Rødsdalen Hagen <kristoffer.r.hagen@gmail.com>
 * @link    https://github.com/kristofferhagen/SimpleXML2FlatArray
 * @license http://opensource.org/licenses/mit-license.php
 */
class SimpleXML2FlatArray implements \Iterator
{
    /**
     * SimpleXMLElement Object
     */
    protected $xml;

    /**
     * Defaults
     */
    protected $defaults = array();

    /**
     * Result container
     * 
     * Contains flat arrays
     */
    protected $rows = array();

    /**
     * Constructor
     */
    public function __construct(\SimpleXMLElement $xml, $defaults = array())
    {
        $this->xml      = $xml;
        $this->defaults = $defaults;
    }

    /**
     * Get result
     * 
     * @return array Resulting flat arrays
     */
    public function get()
    {
        // Only parse xml if we havent already
        if ($this->rows === array())
        {
            $this->parse($this->xml, $this->defaults);
        }

        return $this->rows;
    }

    /**
     * Parse XML
     * 
     * @return void
     */
    private function parse($xml, $values = array())
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
                $this->parse($child, $values);
            }
        }

        // If the child has no children of its own, store the information
        // from $values buffer to $this->rows result container
        if (!$children_is_parent)
        {
            $this->rows[] = $values;
        }
    }

    /*
     * Iteration functions
     */
    public function rewind()
    {
        // Make sure the xml is parsed before the loop
        $this->get();

        reset($this->rows);
    }

    public function current()
    {
        return current($this->rows);
    }

    public function key()
    {
        return key($this->rows);
    }

    public function next()
    {
        return next($this->rows);
    }

    public function valid()
    {
        $key = key($this->rows);
        return ($key !== NULL && $key !== FALSE);
    }
}
