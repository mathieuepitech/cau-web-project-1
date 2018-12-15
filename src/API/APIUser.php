<?php

namespace WebProjectFitness\API;

use WebProjectFitness\Model\BDTables;
use WebProjectFitness\Model\Model;

class APIUser extends API
{

    private $declaredFunctions = [
        'create' => [
            'method' => 'POST',
            'params' => [
            ]
        ],
        'modify' => [
            'method' => 'POST',
            'params' => [
                'user_id' => [
                    'required' => true,
                    'type' => 'string'
                ],
                'name' => [
                    'required' => true,
                    'type' => 'string'
                ]
            ]
        ],
        'favorite-delete' => [
            'method' => 'POST',
            'params' => [
                'id_user' => [
                    'required' => true,
                    'type' => 'string'
                ],
                'id_exercise' => [
                    'required' => true,
                    'type' => 'int'
                ]
            ]
        ],
        'favorite-add' => [
            'method' => 'POST',
            'params' => [
                'id_user' => [
                    'required' => true,
                    'type' => 'string'
                ],
                'id_exercise' => [
                    'required' => true,
                    'type' => 'int'
                ]
            ]
        ],
        'training-add' => [
            'method' => 'POST',
            'params' => [
                'id_user' => [
                    'required' => true,
                    'type' => 'string'
                ],
                'id_exercise' => [
                    'required' => true,
                    'type' => 'int'
                ], 'id_order' => [
                    'required' => true,
                    'type' => 'int'
                ]
            ]
        ],
        'training-delete' => [
            'method' => 'POST',
            'params' => [
                'id_user' => [
                    'required' => true,
                    'type' => 'string'
                ],
                'id_exercise' => [
                    'required' => true,
                    'type' => 'int'
                ], 'id_order' => [
                    'required' => true,
                    'type' => 'int'
                ]
            ]
        ],
        'training-change-order' => [
            'method' => 'POST',
            'params' => [
                'id_user' => [
                    'required' => true,
                    'type' => 'string'
                ],
                'id_exercise' => [
                    'required' => true,
                    'type' => 'int'
                ], 'id_order' => [
                    'required' => true,
                    'type' => 'int'
                ],
                'new_order' => [
                    'required' => true,
                    'type' => 'int'
                ]
            ]
        ]


    ];

    public function __construct()
    {
        parent::__construct($this->declaredFunctions);
    }


    //functions for user table.
    public function create($data)
    {
        $bytes = null;
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil(6 / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil(6 / 2));
        }
        $id = substr(bin2hex($bytes), 0, 6);
        Model::insert(BDTables::USER, [
            "name" => "",
            "user_id" => $id
        ]);
        $this->returnJson(['id' => $id]);
    }

    public function modify($data)
    {
        Model::update(BDTables::USER, ['name' => $data['name']], "user_id", $data['user_id']);
        $this->returnJson(['name' => $data['name'], 'id' => $data['user_id']]);
    }


    //Functions for favorite table.
    public function favoriteAdd($data)
    {
        Model::insert(BDTables::FAVORITE, ['id_user' => $data['id_user'], 'id_exercise' => $data['id_exercise']]);
        $this->returnJson(['id_user' => $data['id_user'], 'id_exercise' => $data['id_exercise']]);
    }

    public function favoriteDelete($data)
    {
        Model::delete(BDTables::FAVORITE, ['id_user' => $data['id_user'], 'id_exercise' => $data['id_exercise']]);
        $this->returnJson(['id_user' => $data['id_user'], 'id_exercise' => $data['id_exercise']]);

    }

    //functions for training table
    public function trainingAdd($data)
    {
        Model::insert(BDTables::TRAINING, ['id_user' => $data['id_user'], 'id_exercise' => $data['id_exercise'], 'id_order' => $data['id_order']]);
        $this->returnJson(['id_user' => $data['id_user'], 'id_exercise' => $data['id_exercise'], 'id_order' => $data['id_order']]);
    }

    public function trainingDelete($data)
    {
        Model::delete(BDTables::TRAINING, ['id_user' => $data['id_user'], 'id_exercise' => $data['id_exercise'], 'id_order' => $data['id_order']]);

        $this->returnJson(['id_user' => $data['id_user'], 'id_exercise' => $data['id_exercise'], 'id_order' => $data['id_order']]);
    }

    public function trainingChangeOrder($data)
    {
        Model::update_order(BDTables::TRAINING, ['id_user' => $data['id_user'], 'id_order' => $data['id_order'], 'id_exercise' => $data['id_exercise'] ], $data['new_order']);

        $this->returnJson(['id_user' => $data['id_user'], 'id_exercise' => $data['id_exercise'], 'id_order' => $data['id_order'], 'new_order' => $data['new_order']]);
    }

}