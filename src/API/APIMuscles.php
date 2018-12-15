<?php

namespace WebProjectFitness\API;

use WebProjectFitness\Model\BDD;
use WebProjectFitness\Model\BDTables;

class APIMuscles extends API {

    private $declaredFunctions = [
        'get-list' => [
            'method' => 'POST',
            'params' => [
                'muscle' => [
                    'require' => true,
                    'type' => 'string'
                ]
            ]
        ],
        'get-exercise' => [
            'method' => 'POST',
            'params' => [
                'id' => [
                    'required' => true,
                    'type' => 'int'
                ]
            ]
        ]
    ];

    public function __construct() {
        parent::__construct( $this->declaredFunctions );
    }

    public function getList( $data ) {
        $query = "SELECT " . BDTables::EXERCISE . ".id, title FROM " . BDTables::EXERCISE .
            " LEFT JOIN " . BDTables::MUSCLES . " ON " . BDTables::MUSCLES . ".id = " . BDTables::EXERCISE . ".muscle
                     WHERE " . BDTables::MUSCLES . ".muscle = :muscle";
        $query = BDD::instance()->prepare( $query );
        $query->execute( $data );

        $this->returnJson( json_encode( $query->fetchAll() ) );
    }

    public function getExercise( $data ) {
        $query = "SELECT `title`, `video`, `description` FROM " . BDTables::EXERCISE .
            "   WHERE `id` = :id";
        $query = BDD::instance()->prepare( $query );
        $query->execute( $data );

        $this->returnJson( json_encode( $query->fetch() ) );
    }

}