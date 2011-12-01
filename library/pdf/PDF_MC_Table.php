<?php
include_once('fpdf.php');
include_once('headObject.php');

class PDF_MC_Table extends FPDF
{
var $widths;
var $aligns;
var $sizes;
var $hObj;

function PDF_MC_Table($hObj){
	$this->FPDF();
	$this->hObj = $hObj;
}
function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function setSizes($s){
	$this->sizes = $s;
}

function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //$orFontSize = $this->FontSize;
    $orFont = $this->fonts;
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        if($this->sizes[$i]){
        	$size = $this->sizes[$i];
        	$sArray = explode(",", $size);
        	$this->SetFont($sArray[0],$sArray[1],$sArray[2]);
        }else{
        	$this->SetFont("arial","",8);
        	//$this->SetFont($orFont);
        }
        /*$s = isset($this->sizes[$i])? $this->sizes[$i] : $orFontSize;
        $this->SetFontSize($s);*/
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        //$this->Rect($x,$y,$w,$h);
        /*$this->SetXY($x, $y);
        $this->Cell($w,$h,$data[$i]);*/
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //$this->SetFontSize($orFontSize);
    //$this->SetFont($orFont);
    //Go to the next line
    $this->Ln($h);
}

/*Two Adjacent Tables*/
function TwoRow($data1,$gap,$data2){
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data1);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data1[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data1);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data1[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
	$x=$this->GetX();
    $y=$this->GetY();
	$this->SetXY($x+$gap,$y);
	for($i=0;$i<count($data2);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data2[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger){
        $this->AddPage($this->CurOrientation);
		$this->SetXY(10,35);
	}
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}


function Header(){
	$ho = new HeadObject();
	$ho = $this->hObj;
    	//$this->Image('logo.png',10,8,33);
      	$this->SetFont('arial','B',12);
      	$this->SetXY(10, 10);
		//$this->SetTextColor(144,144,144);
		//$this->SetDrawColor(164,164,164);
		$this->Write(10,$ho->getFacName());
		$this->SetFont('arial','',9);
		$this->SetXY(10, 17);
		$this->Write(8,$ho->getFacStreet());
		$this->SetXY(10, 21);
		$this->Write(8,$ho->getFacCity().", ".$ho->getFacState()." ".$ho->getFacPC());
		$this->SetXY(10, 25);
      	$this->Write(8,$ho->getFacPhone());
      	$this->SetXY(150, 17);
      	$this->SetFont('arial','B',9);
      	$this->Write(8,$ho->getFname()." ".$ho->getLname());
      	$this->SetXY(150, 21);
      	$this->SetFont('arial','',9);
      	//$this->Write(8,"Generated On ".$ho->getGenDate());
      	$this->Write(8,"Chart Number ".$ho->getChart());
      	$this->SetXY(150, 25);
      	$this->Write(8,"Date Of Birth ".$ho->getDob());
      	
      	$this->Line(10, 32, 200, 32);
		//$this->Cell(0,10,$ho->getFacName(),1,0,'L');
	}

	function Footer(){
    	$this->SetXY(10,-10);
      	$this->SetFont('Helvetica','I',10);
      	$this->Write (5, 'www.openmedpractice.com');
      	$this->SetXY(160,-10);//
      	$this->Write (5, "Page ".$this->PageNo()." of {nb}");
    }
}
?>