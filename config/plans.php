<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Positive Words
    |--------------------------------------------------------------------------
    |
    | Estas palabras indican "true" y se usan para verificar
    | si una característica del plan en particular está habilitada.
    |
    */
    'positive_words' => [
        'Y',
        'YES',
        'TRUE',
        'UNLIMITED',
    ],

    /*
    |--------------------------------------------------------------------------
    | Features
    |--------------------------------------------------------------------------
    |
    | El corazón de este paquete. Aquí especificará todas las características disponibles
    | para sus planes.
    |
    */
    'features' => [
        'SAMPLE_SIMPLE_FEATURE',
        'SAMPLE_DEFINED_FEATURE' => [
            'resettable_interval' => 'month',
            'resettable_count' => 2
        ],
    ],
];
