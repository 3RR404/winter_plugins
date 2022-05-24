# CORS

Allows cross origin resource sharing

base configuration, allowed methods 'n headers

## JWT Auth

!!! JWT Auth plugin only !!!

paste this to .htaccess

```
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
```