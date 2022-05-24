<?php

return [
    'origin' => '*', // domain where originates from fetch data
    'headers' => 'Authorization, Content-Type, Origin, Accept-Language, Content-Language', // allows headers
    'methods' => 'GET, HEAD, POST, PUT, DELETE, CONNECT, OPTIONS, TRACE, PATCH' // allowed methods
    /* 'credentials' => 'true' // response with credentials / default value is false */
];
