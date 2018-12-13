<?php

namespace WebProjectFitness\API;

use WebProjectFitness\Model\BDTables;
use WebProjectFitness\Model\Model;

class APIUser extends API {

    private $declaredFunctions = [
        'create' => [
            'method' => 'GET',
            'params' => [
//                'id' => [
//                    'required' => true,
//                    'type' => 'string'
//                ]
            ]
        ]
    ];

    public function __construct() {
        parent::__construct( $this->declaredFunctions );
    }

    public function create( $data ) {
        Model::insert( BDTables::USER, [
            "name" => "Mathi",
            "user_id" => "bite"
        ] );
        $this->returnJson( [ 'body' => 'truc' ] );
    }

}