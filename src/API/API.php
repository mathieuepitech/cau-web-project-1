<?php

namespace base\API;

use base\Controller\Controller;

class API extends Controller{

    private $declaredFunctions = [];

    /**
     * API constructor.
     * @param array $declaredFunctions
     */
    public function __construct(array $declaredFunctions) {
        parent::__construct();
        $this->declaredFunctions = $declaredFunctions;
    }

    /**
     * @return array
     */
    public function getDeclaredFunctions() {
        return $this->declaredFunctions;
    }
}

?>