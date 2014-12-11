uppy
====

Media manager for Orchestra Platform 2

What is this package?
====
You can create albums and upload pictures within orchestra platform. With the following features:
- CSRF Protection
- ACL integration (Orchestral/Control)
- Event driven

Events
======
```php
Event::fire('uppy.(albums|pictures): (saved|saving|creating|created)', [($album|$picture), $input]);

```
Installation
============

Installation via composer
