## Advanced Usage

### The `Option` Model

The package is built around the `Arandu\LaravelSiteOptions\Option` model, which provides a fluent, expressive API for managing site options. Besides default Model methods, it also provides the following methods:

#### `Option::set(string $key, mixed $value): void`

The `set()` method stores an option in the database, and reflects changes in cache if enabled. It accepts the following parameters:

 - `$key`: The option key.
 - `$value`: The option value.

#### `Option::get(string $key, mixed $default = null): mixed`

The `get()` method retrieves an option from the database, and caches it if enabled. It accepts the following parameters:

 - `$key`: The option key.
 - `$default`: The default value to return if the option does not exist. If provided, will override the hard-coded default value set in the config file.

#### `Option::has(string $key): bool`

The `has()` method checks if an option exists in the database. It accepts the following parameters:

 - `$key`: The option key.

#### `Option::rm(string $key): void`

The `rm()` method removes an option from the database, and reflects changes in cache if enabled. It accepts the following parameters:

 - `$key`: The option key.

### Changing the Database Table Name

The package stores options in a database table named `site_options` by default. You can change this table name by editing the `config/site-options.php` file. However, if you have already published the package's migration file, you will need to rename the table in a new migration.

For versions `<= 2.0.0`, the migration included with Laravel Site Options creates a table based on the `config/site-options.php` file. This approach had the advantage of allowing developers to easily customize the table name and columns, but only if the developer did this before distributing or deploying their code. It was difficult to understand what the migration was doing, as the table name was not explicit.

This has been changed in `>= 2.1.0` versions, and the migration will always create a table named `site_options`, which makes renaming the table way more understandable to developers.

#### Renaming in `<= 2.0.0` Versions

If you have changed the config file to use a different table name, new installations will work fine, but you will need to rename the table in existing installations. To do so, you can create a new migration that renames the table, like this:

```php
<?php

use Illuminate\Database\Migrations\Migration;

class MaybeRenameSiteOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $newTable = 'custom_table_name';
        $oldTable = 'site_options';

        if (Schema::hasTable($oldTable) && !Schema::hasTable($newTable)) {
            Schema::rename($oldTable, $newTable);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $newTable = 'custom_table_name';
        $oldTable = 'site_options';

        if (Schema::hasTable($newTable) && !Schema::hasTable($oldTable)) {
            Schema::rename($newTable, $oldTable);
        }
    }
}
```

#### Renaming in `>= 2.1.0` Versions

Create a new migration to rename the table, or if you haven't migrated yet, change the table name in the `config/site-options.php` file and in the migration published by the package.

### Serialization

PHP serialization is a fundamental aspect of the Laravel Site Options package. It enables the storage of a wide range of data types in a serialized format, which is essential for storing complex data structures as a string in the database. Here are key points about PHP serialization in this context:

1. **What is PHP Serialization?**: Serialization in PHP involves converting PHP variables (like arrays, objects, etc.) into a single string representation. This process allows complex data types to be easily stored and retrieved from a storage medium like a database.

2. **Usage in Laravel Site Options**: The package utilizes PHP serialization to store and retrieve various data types. For example, you can store an array of settings, and the package will serialize this array to store it in the database. When retrieving, it deserializes the string back into a PHP array.

3. **Why serialization?**: We chose serialization because it is a native PHP feature, and it allows storing complex data types in a single string. Serialization is also used by Laravel cache drivers, which makes it even more convenient to use in this package. If something can be cached, it can be stored as an option.

3. **Recommendations and Best Practices**: While serialization allows storing almost any PHP type, it's advisable to **avoid storing objects as options**. Objects can have references to resources outside their structure, leading to potential issues when deserialized, such as bugs that are difficult to identify and fix. Instead, it's recommended to store primitive data types (strings, integers, booleans) and arrays. Laravel has several tools to transform objects into arrays, which can be stored safely.

4. **Security Considerations**: Serialization can pose security risks, especially if the serialized data is tampered with. This can lead to object injection vulnerabilities if the application attempts to unserialize a maliciously crafted string. It's crucial to ensure that serialized data is not exposed to untrusted sources.

5. **Handling Serialization in Laravel Site Options**: The package handles the serialization and deserialization processes internally, abstracting these complexities from the end-user. When you use `Option::set()` and `Option::get()`, the package automatically serializes and deserializes the data, respectively.

By understanding and adhering to these practices regarding PHP serialization, developers can use Laravel Site Options effectively and securely, leveraging its capabilities to manage site settings and configurations efficiently.
