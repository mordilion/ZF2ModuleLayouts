ZF2ModuleLayouts
=================

Version 1.0

Introduction
------------

ZF2ModuleLayouts is a simple module to build module specified layouts.

Usage
-----

Create a new config file under "config/autoload" with the following specify:

```php
<?php

return array(
    'module_layouts' => array(
        'ModuleName' => 'layout/layout.phtml',
    ),
);
```

A simple module to build module specified layouts