SimpleXML2FlatArray
===================
Converts an XML document to several flat arrays containing values from parent
elements using SimpleXML.

Useful for storing xml data in a database.

Usage
-----
Option 1: Load XML data from file and parse
```php
$data = new SimpleXML2FlatArray(simplexml_load_file('data.xml'));
$data = $data->get();
```

Option 2: Load XML from variable
```php
$data = new SimpleXML2FlatArray(simplexml_load_string($xml));
$data = $data->get();
```
