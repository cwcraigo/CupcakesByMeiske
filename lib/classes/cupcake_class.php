<?php

/* ************************************************************************
* AUTHOR:  Craig W. Christensen
* DATE:    December 16, 2012
* DESCRIPTION: Cupcake Class for CupcakesByMeiske.cwcraigo.com.
************************************************************************ */
session_start();

class Cupcake
{
	// Data Fields
	public $cupcake_flavor;
	// public $cupcake_color;
	public $frosting_color;
	public $filling_flavor;
	public $decoration;
	public $session_id = 0;

	// Constructor
	public function __construct($session_id)
	{
		if($session_id == 0) {
			$this->cupcake_flavor = 'Vanilla';
			$this->frosting_color = 'White';
			$this->filling_flavor = 'Strawberry';
			$this->decoration 		= 'Sprinkles';
		}
		$this->session_id 		= $session_id;
	}

	// Getters
	public function getCupcakeFlavor() {
		return $this->cupcake_flavor;
	}
	// public function getCupcakeColor() {
	// 	return $this->cupcake_color;
	// }
	public function getCupcakeFrostingColor() {
		return $this->frosting_color;
	}
	public function getCupcakeFillingFlavor() {
		return $this->filling_flavor;
	}
	public function getCupcakeDecoration() {
		return $this->decoration;
	}
	public function getCupcakeSessionId() {
		return $this->session_id;
	}

	// Setters
	public function setCupcakeFlavor($cupcake_flavor) {
		$this->cupcake_flavor = $cupcake_flavor;
	}
	// public function setCupcakeColor($cupcake_color) {
	// 	$this->cupcake_color = $cupcake_color;
	// }
	public function setCupcakeFrostingColor($frosting_color) {
		$this->frosting_color = $frosting_color;
	}
	public function setCupcakeFillingFlavor($filling_flavor) {
		$this->filling_flavor = $filling_flavor;
	}
	public function setCupcakeDecoration($decoration) {
		$this->decoration = $decoration;
	}
	public function setCupcakeSessionId($session_id) {
		$this->session_id = $session_id;
	}
	public function setCupcake($cupcake_flavor,$filling_flavor,$decoration,$frosting_color) {
		$this->cupcake_flavor = $cupcake_flavor;
		$this->filling_flavor = $filling_flavor;
		$this->decoration 		= $decoration;
		$this->frosting_color = $frosting_color;
	}

	// toString
	public function toStringCupcake() {
		$string = 'Cupcake: '.$this->cupcake_flavor;
		// if ($this->cupcake_flavor == '<br/>Vanilla') {
		// 	$string .= '<br/>Cupcake Color: '.$this->cupcake_color;
		// }
		$string .= '<br/>Color: '.$this->frosting_color.
					 		 '<br/>Filling: '.$this->filling_flavor.
					 		 '<br/>Decoration: '.$this->decoration.
					 		 '<br/>Session ID: '.$this->session_id;
		return $string;
	}


} // end Class

$myCupcake = new Cupcake($_SESSION['session_id']);
?>