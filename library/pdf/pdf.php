<?php
	require('fpdf.php');
	require_once('headObject.php');
	
	class PDF extends FPDF{
		private $hObj;
		function PDF($hObj){
			$this->FPDF();
			$this->hObj = $hObj;
			//$this->Header();
			//$this->Footer();
		}
		
		function Header(){
			global $title;
			
			//$this->Image($hObj->getLogo(),10,8,33);
			//Arial bold 15
			//$this->SetFont('Arial','B',15);
$this->SetFont('Times','',12);
			//Colors of frame, background and text
			$this->SetDrawColor(0,80,180);
			$this->SetFillColor(230,230,0);
			$this->SetTextColor(220,50,50);
			//Thickness of frame (1 mm)
			$this->SetLineWidth(1);
			//Title
			
			$this->Cell(0,20,$this->hObj->getFacName(),1,1,'C',1);
			//Line break
			$this->Ln(10);
		}
		
		function Footer(){
			//Position at 1.5 cm from bottom
			$this->SetY(-15);
			//Arial italic 8
			$this->SetFont('Arial','I',8);
			//Text color in gray
			$this->SetTextColor(128);
			//Page number
			$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
		}
	}
?>