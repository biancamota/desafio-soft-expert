<?php

return [
    ['GET', '/', [\App\Controllers\Api::class, 'getDetails']],
    ['GET', '/products', [\App\Controllers\Product::class, 'getAll']],
    ['GET', '/products/{id:\d+}', [\App\Controllers\Product::class, 'getById']],
    ['POST', '/products', [\App\Controllers\Product::class, 'save']],
    ['PUT', '/products/{id:\d+}', [\App\Controllers\Product::class, 'update']],
    ['DELETE', '/products/{id:\d+}', [\App\Controllers\Product::class, 'delete']],
    ['GET', '/categories', [\App\Controllers\Category::class, 'getAll']],
    ['GET', '/categories/{id:\d+}', [\App\Controllers\Category::class, 'getById']],
    ['GET', '/payment-methods', [\App\Controllers\Category::class, 'getAll']],
    ['GET', '/payment-methods/{id:\d+}', [\App\Controllers\Category::class, 'getById']],
    ['GET', '/user/{id:\d+}', [\App\Controllers\User::class, 'getById']],
    ['GET', '/sales', [\App\Controllers\Sales::class, 'getAll']],
    ['GET', '/sales/{id:\d+}', [\App\Controllers\Sales::class, 'getById']],
    ['POST', '/sales', [\App\Controllers\Sales::class, 'save']],
    ['PUT', '/sales/{id:\d+}', [\App\Controllers\Sales::class, 'update']],
    ['DELETE', '/sales/{id:\d+}', [\App\Controllers\Sales::class, 'delete']],
];
