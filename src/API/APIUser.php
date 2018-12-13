<?php

namespace WebProjectFitness\API;

class APIUser extends API {

    private $declaredFunctions = [
        'insert' => [
            'method' => 'POST',
            'params' => [
                'name' => [
                    'required' => true,
                    'type' => 'string'
                ]
            ]
        ],
    ];

    public function __construct() {
        parent::__construct( $this->declaredFunctions );
    }

}