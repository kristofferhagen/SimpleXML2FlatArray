SimpleXML2FlatArray
===================
Converts an XML document to several flat arrays containing values from parent
elements using SimpleXML.

Useful for storing xml data in a database.

Usage
-----
First of all, you need to create a SimpleXML object. You can do this in one of several ways:
```php
// Load from file
$simplexml = simplexml_load_file('data.xml');

// Load from string
$simplexml = simplexml_load_string($xml_string);
```
It is also possible to load from a DOM node. For more information on creating a SimpleXML object,
see [this documentation page](http://www.php.net/manual/en/ref.simplexml.php).

The following code reads the `$simplexml` object created above into a flat array `$data`:
```php
$xml = new SimpleXML2FlatArray($simplexml);

$data = $xml->get();
```
