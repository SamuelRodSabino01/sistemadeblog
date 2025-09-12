<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Configurações de Upload de Imagens
    |--------------------------------------------------------------------------
    |
    | Aqui você pode configurar as opções padrão para upload e processamento
    | de imagens no sistema de blog.
    |
    */

    'max_file_size' => 5 * 1024 * 1024, // 5MB em bytes

    'allowed_mimes' => [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp'
    ],

    'allowed_extensions' => [
        'jpg',
        'jpeg',
        'png',
        'gif',
        'webp'
    ],

    /*
    |--------------------------------------------------------------------------
    | Dimensões das Imagens
    |--------------------------------------------------------------------------
    |
    | Configure as dimensões máximas para diferentes tipos de imagens.
    |
    */

    'dimensions' => [
        'posts' => [
            'max_width' => 1200,
            'max_height' => 800,
            'thumbnail_width' => 400,
            'thumbnail_height' => 300,
        ],
        'categories' => [
            'max_width' => 800,
            'max_height' => 600,
            'thumbnail_width' => 300,
            'thumbnail_height' => 200,
        ],
        'users' => [
            'max_width' => 400,
            'max_height' => 400,
            'thumbnail_width' => 150,
            'thumbnail_height' => 150,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Caminhos de Upload
    |--------------------------------------------------------------------------
    |
    | Define os caminhos onde as imagens serão armazenadas.
    |
    */

    'paths' => [
        'posts' => 'images/posts',
        'categories' => 'images/categories',
        'users' => 'images/users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Qualidade da Imagem
    |--------------------------------------------------------------------------
    |
    | Define a qualidade de compressão das imagens (0-100).
    |
    */

    'quality' => 85,

    /*
    |--------------------------------------------------------------------------
    | Criar Thumbnails Automaticamente
    |--------------------------------------------------------------------------
    |
    | Define se os thumbnails devem ser criados automaticamente.
    |
    */

    'auto_thumbnail' => true,

];