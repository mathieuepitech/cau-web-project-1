<?php

namespace WebProjectFitness\Controller\Site;

use WebProjectFitness\Controller\ControllerSite;

class Index extends ControllerSite {

	/**
	 * Index constructor.
	 */
	public function __construct() {
		parent::__construct();

		$this->addHead( [
		] );

		$this->addFooter( [

		] );

		$this->addData( [] );
		$this->view();
	}
}

?>