# Advanced Usage

### The `Option` Model

At the core of the Laravel Site Options package is the `Arandu\LaravelSiteOptions\Option` model, offering a powerful and expressive API for managing site options. Beyond the standard model methods, it includes specialized methods to make option management seamless:

#### `Option::set(string $key, mixed $value): void`

The `set()` method stores an option in the database and updates the cache if caching is enabled. It accepts the following parameters:

- **`$key`**: The key identifying the option.
- **`$value`**: The value to be stored for the option.

#### `Option::get(string $key, mixed $default = null): mixed`

The `get()` method retrieves an option from the database, with caching handled automatically if enabled. It accepts the following parameters:

- **`$key`**: The key identifying the option.
- **`$default`**: The fallback value returned if the option does not exist. This value takes precedence over any hard-coded default set in the configuration file.

#### `Option::has(string $key): bool`

The `has()` method checks for the existence of an option in the database. It accepts the following parameter:

- **`$key`**: The key identifying the option.

#### `Option::rm(string $key): void`

The `rm()` method removes an option from the database and updates the cache if caching is enabled. It accepts the following parameter:

- **`$key`**: The key identifying the option to be removed.

### Customizing the Database Table Name

By default, the package stores options in a table named `site_options`. If you need to change this table name, you can do so by modifying the `config/site-options.php` file. However, note that if you have already published the migration file, you will need to create a new migration to rename the table.

#### For Versions `<= 2.0.0`

In versions `<= 2.0.0`, the package’s migration file created a table based on the configuration file, allowing developers to easily customize the table name before deployment. However, this approach often made it unclear what the migration was doing since the table name was not explicit.

To rename the table in these versions, you must manually create a migration, as shown below:

```php
<?php

use Illuminate\Database\Migrations\Migration;

class MaybeRenameSiteOptionsTable extends Migration
{
    public function up()
    {
        $newTable = 'custom_table_name';
        $oldTable = 'site_options';

        if (Schema::hasTable($oldTable) && !Schema::hasTable($newTable)) {
            Schema::rename($oldTable, $newTable);
        }
    }

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

#### For Versions `>= 2.1.0`

Starting with version `2.1.0`, the package always creates a table named `site_options`, making it clearer and more straightforward for developers to rename it if necessary. To rename the table:

- Create a new migration to rename the table, or
- If you haven’t migrated yet, adjust the table name in both the `config/site-options.php` file and the published migration file.

### Serialization

Serialization is a crucial feature of the Laravel Site Options package, allowing complex data types to be stored as strings in the database. Here’s what you need to know:

1. **What is PHP Serialization?**
   - Serialization converts PHP variables (arrays, objects, etc.) into a string format that can be easily stored in a database.

2. **Usage in Laravel Site Options**
   - The package leverages serialization to store complex data structures like arrays and even simple data types. When you save an option, it serializes the data, and when you retrieve it, the package deserializes it back to its original form.

3. **Why Serialization?**
   - Serialization is a native PHP feature, making it a reliable way to store diverse data types. It also aligns with Laravel's caching mechanisms, making the data storage process more consistent and convenient.

4. **Recommendations and Best Practices**
   - While you can serialize almost any PHP type, it’s best to **avoid storing objects**. Serialized objects can reference external resources, which may lead to hard-to-debug issues when deserialized. Stick to storing primitive data types (like strings, integers, booleans) and arrays. Laravel provides tools to convert objects into arrays, which are safer to serialize.

5. **Security Considerations**
   - Be cautious with serialization as it can expose your application to security risks if serialized data is tampered with. Maliciously crafted serialized strings can lead to object injection vulnerabilities. Always ensure that serialized data is not exposed to untrusted sources.

6. **Handling Serialization in Laravel Site Options**
   - The package abstracts serialization and deserialization, so you don’t have to handle these processes manually. When you use `Option::set()` and `Option::get()`, the package takes care of the serialization and deserialization, ensuring a smooth and secure experience.

By following these guidelines and understanding how serialization works within the Laravel Site Options package, you can effectively and securely manage site settings and configurations.