<?php
	class HeadObject{
		
		private $logo;
		private $facName;
		private $facStreet;
		private $facCity;
		private $facState;
		private $facPC;
		private $facPhone;
		private $fname;
		private $lname;
		private $genDate;
		private $dob;
		private $dos;
		private $chart;
		
		function getLogo(){
			return $this->logo;
		}
		
		function getFacName(){
			return $this->facName;
		}
		
		function getFacStreet(){
			return $this->facStreet;
		}
		
		function getFacCity(){
			return $this->facCity;
		}
		
		function getFacState(){
			return $this->facState;
		}
		
		function getFacPC(){
			return $this->facPC;
		}
		
		function getFacPhone(){
			return $this->facPhone;
		}
		
		function getFname(){
			return $this->fname;
		}
		
		function getLname(){
			return $this->lname;
		}
		
		function getGenDate(){
			return $this->genDate;
		}
		
		function getDob(){
			return $this->dob;
		}
		
		function getDos(){
			return $this->dos;
		}
		
		function getChart(){
			return $this->chart;
		}
		
		function setLogo($logo){
			$this->logo = $logo;
		}
		
		function setFacName($facName){
			$this->facName = $facName;
		}
		
		function setFacStreet($facStreet){
			$this->facStreet = $facStreet;
		}
		
		function setFacCity($facCity){
			$this->facCity = $facCity;
		}
		
		function setFacState($facState){
			$this->facState = $facState;
		}
		
		function setFacPC($facPC){
			$this->facPC = $facPC;
		}
		
		function setFacPhone($facPhone){
			$this->facPhone = $facPhone;
		}
		
		function setFname($fname){
			$this->fname = $fname;
		}
		
		function setLname($lname){
			$this->lname = $lname;
		}
		
		function setGenDate($genDate){
			$this->genDate = $genDate;
		}
		
		function setDob($dob){
			$this->dob = $dob;
		}
		
		function setDos($dos){
			$this->dos = $dos;
		}
		
		function setChart($chart){
			$this->chart = $chart;
		}
	}
?>