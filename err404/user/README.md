## Configuration

1. Generate JWT secret key
   ```bash
   php artisan jwt:secret
   ```
2. Insert the key into ENV variables
   ```
   RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
   ```
3. Allow Authorisation in `.htaccess`

## JWT ENV variables
- `JWT_SECRET`
    - Secret key will be used for Symmetric algorithms only (HMAC)
    - default: config('app.key')
- `JWT_TTL`
    - Time (in minutes) that the token will be valid for
    - default: 60 (1 hour)
- `JWT_REFRESH_TTL`
    - Time (in minutes) that the token can be refreshed
    - default: 20160 (2 weeks)

## Issues
- [x] add fields  name / phone / street line 1-2 / country / city / state / zip (invoice/shipping)
- [x] add company fields company_name / ico / dic / ic_dph
