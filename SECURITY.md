## Best Practices

When using `laravel-site-options`, it's crucial to ensure the security of data, especially when dealing with sensitive information. Here are some guidelines:

1. **Validate Input**: Laravel Eloquent does a great job of protecting against SQL injection, but it's still important to validate user input to prevent other types of attacks.

2. **Limit Access**: Restrict access to sensitive options. Only allow trusted administrators to manage these settings.

3. **Use Environment Variables**: For highly sensitive data like API keys, consider storing them in environment variables instead of the database.

4. **Regular Audits**: Periodically review your site options to ensure that no sensitive data is exposed unnecessarily.

5. **Responsibility**: Remember, securing the data inputted through this package is the responsibility of the developer. Use Laravel's built-in security features to enhance protection.

## Vulnerabilities

**If you discover any security-related issue, please email to bruno@arandutech.com.br instead of using the issue tracker.**
