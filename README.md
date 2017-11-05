# Wordpress - Shared autoloader #

A simple mu-plugin, built to offer a shared psr4 autoloader amongst custom plugins, to avoid adding in autoloaders for 
each.

## Usage ##

Add into wp-content/mu-plugins directory.

In the custom plugin that will use it:

```php
// First param is the base namespace to register
// Second param is the absolute path to the source
JbSharedAutoloader::register(
    'Custom\\PluginNamespace\\',
    __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR
);
```

For example:
Plugin called my-custom-plugin, located in wp-content/plugins/my-custom-plugin:

In wp-content/plugins/my-custom-plugin/my-custom-plugin.php (main plugin file):
```
JbSharedAutoloader::register(
    'MyCustomPlugin\\',
    __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR
);
```
The second parameter would equate to {absolute path to wp-content}/wp-content/my-custom-plugin/src.
Therefore everything under the src directory will come under the MyCustomPlugin namespace.