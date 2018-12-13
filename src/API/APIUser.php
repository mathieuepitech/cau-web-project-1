<?php

namespace WebProjectFitness\API;

class APIUser extends API {

    private $declaredFunctions = [
        'create' => [
            'method' => 'POST',
            'params' => [
                'id' => [
                    'required' => true,
                    'type' => 'string'
                ]
            ]
        ]
    ];

    public function __construct() {
        parent::__construct( $this->declaredFunctions );
    }

    public function create( $data ) {
        $this->returnJson( [ 'body' => 'truc', 'id' => $data[ 'id' ] ] );
    }

}