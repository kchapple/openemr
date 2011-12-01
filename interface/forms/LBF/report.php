<?php
// Copyright (C) 2009 Rod Roark <rod@sunsetsystems.com>
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.

include_once("../../globals.php");
include_once($GLOBALS["srcdir"] . "/api.inc");

// This function is invoked from printPatientForms in report.inc
// when viewing a "comprehensive patient report".  Also from
// interface/patient_file/encounter/forms.php.
//
function lbf_report($pid, $encounter, $cols, $id, $formname,$printable="",$pdf="") {
	if($printable){
		if($printable == "HPI"){
			require_once($GLOBALS["srcdir"] . "/HpiPdf.php");
		}else{
			require_once($GLOBALS["srcdir"] . "/reportOptions.inc.php");
		}
	}else{
		require_once($GLOBALS["srcdir"] . "/options.inc.php");
	}

	if(!$printable){
		echo "<table>\n";
	}

	// echo "<tr><td>Coming from here $formname</td></tr>";

	$arr = array();
	$fres = sqlStatement("SELECT field_id, field_value FROM lbf_data WHERE form_id = '$id'");
	while ($frow = sqlFetchArray($fres)) {
		$arr[$frow['field_id']] = $frow['field_value'];
	}
	if($printable == "HPI"){
		printHPIReport($pdf,$encounter,$pid);
	}else{
		if($printable != ""){
			display_layout_rows($formname, $arr,"",$pdf);
		}else{
			display_layout_rows($formname, $arr);
			echo "<tr><td>&nbsp;</td></tr>";
		}
		
	}

	if(!$printable){
		echo "</table>\n";
	}
}
?>