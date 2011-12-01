<?php
// Copyright (C) 2009 Rod Roark <rod@sunsetsystems.com>
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.

require_once("../../globals.php");
require_once("$srcdir/api.inc");
require_once("$srcdir/forms.inc");
require_once("$srcdir/options.inc.php");
require_once("$srcdir/patient.inc");
require_once("$srcdir/formdata.inc.php");

$CPR = 4; // cells per row

$pprow = array();

if (! $encounter) { // comes from globals.php
 die("Internal error: we do not seem to be in an encounter!");
}

function end_cell() {
  global $item_count, $cell_count;
  if ($item_count > 0) {
    echo "</td>";
    $item_count = 0;
  }
}

function end_row() {
  global $cell_count, $CPR;
  end_cell();
  if ($cell_count > 0) {
    for (; $cell_count < $CPR; ++$cell_count) echo "<td></td>";
    echo "</tr>\n";
    $cell_count = 0;
  }
}

function end_group() {
  global $last_group;
  if (strlen($last_group) > 0) {
    end_row();
    echo " </table>\n";
    echo "</div>\n";
  }
}

$formname = formData('formname', 'G');
$subset = formData('subset','G');
$formid   = 0 + formData('id', 'G');
if(!$formid && $formname == 'LBF006'){
    $tmp = sqlQuery("SELECT form_id FROM forms WHERE " .
      "encounter = $encounter AND formdir = 'LBF006' LIMIT 0,1");
    $formid = $tmp['form_id'];    
}
$tmp = sqlQuery("SELECT title FROM list_options WHERE " .
  "list_id = 'lbfnames' AND option_id = '$formname'");
$formtitle = $tmp['title'];

$newid = 0;

// If Save was clicked, save the info.
//
if ($_POST['bn_save']) {
  $sets = "";
  $grpSet = " ";
  if(isset($_REQUEST["subset"])){
    if($_REQUEST["subset"] == "all"){
          $grpSet = " and group_name not in ('BIMPRESSION PLAN I','CIMPRESSION PLAN II','DIMPRESSION PLAN III','EIMPRESSION PLAN IV','GE_Sign') ";
    }    
    if($_REQUEST["subset"] == "iplan"){
        $grpSet = " and group_name in ('BIMPRESSION PLAN I','CIMPRESSION PLAN II','DIMPRESSION PLAN III','EIMPRESSION PLAN IV') ";
    }
    if($_REQUEST["subset"] == "geSign"){
        $grpSet = " and group_name = 'GE_Sign' ";
    }    
  }
  $sqlQuery = "SELECT * FROM layout_options WHERE form_id = '$formname' AND uor > 0 AND field_id != '' AND edit_options != 'H' ";
  $sqlQuery .= $grpSet;
  $sqlQuery .= " ORDER BY group_name, seq";
  /*$fres = sqlStatement("SELECT * FROM layout_options " .
    "WHERE form_id = '$formname' AND uor > 0 AND field_id != '' AND " .
    "edit_options != 'H' " .
    "ORDER BY group_name, seq");*/
    $fres = sqlStatement($sqlQuery);
  while ($frow = sqlFetchArray($fres)) {
    $field_id  = $frow['field_id'];
    $value = get_layout_form_value($frow);
    if ($formid) { // existing form
      if ($value === '') {
        $query = "DELETE FROM lbf_data WHERE " .
          "form_id = '$formid' AND field_id = '$field_id'";
      }
      else {
        $query = "REPLACE INTO lbf_data SET field_value = '$value', " .
          "form_id = '$formid', field_id = '$field_id'";
      }
      sqlStatement($query);
    }
    else { // new form
      if ($value !== '') {
        $tquery = "";
        if ($newid) {
          sqlStatement("INSERT INTO lbf_data " .
            "( form_id, field_id, field_value ) " .
            " VALUES ( '$newid', '$field_id', '$value' )");
            $tquery = "INSERT INTO lbf_data ( form_id, field_id, field_value ) VALUES ( '$newid', '$field_id', '$value' )";
        }
        else {
          $newid = sqlInsert("INSERT INTO lbf_data " .
            "( field_id, field_value ) " .
            " VALUES ( '$field_id', '$value' )");
            $tquery = "INSERT INTO lbf_data ( field_id, field_value ) VALUES ( '$field_id', '$value' )";
        }
      }
      // Note that a completely empty form will not be created at all!
    }
  }

  if (!$formid && $newid) {
    addForm($encounter, $formtitle, $newid, $formname, $pid, $userauthorized);
  }

  formHeader("Redirecting....");
  formJump();
  formFooter();
  exit;
}

$fname = "../../../custom/LBF/$formname.plugin.php";
if (file_exists($fname)) include_once($fname);

$enrow = sqlQuery("SELECT p.fname, p.mname, p.lname, fe.date FROM " .
  "form_encounter AS fe, forms AS f, patient_data AS p WHERE " .
  "p.pid = '$pid' AND f.pid = '$pid' AND f.encounter = '$encounter' AND " .
  "f.formdir = 'newpatient' AND f.deleted = 0 AND " .
  "fe.id = f.form_id LIMIT 1");
?>
<html>
<head>
<?php html_header_show();?>
<link rel=stylesheet href="<?echo $css_header;?>" type="text/css">
<style>

td, input, select, textarea {
 font-family: Arial, Helvetica, sans-serif;
 font-size: 10pt;
}

div.section {
 border: solid;
 border-width: 1px;
 border-color: #0000ff;
 margin: 0 0 0 10pt;
 padding: 5pt;
}

</style>

<style type="text/css">@import url(../../../library/dynarch_calendar.css);</style>
<link type="text/css" href="../../../library/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="../../../library/jsnew/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="../../../library/jsnew/jquery-ui-1.8.16.custom.min.js"></script>
<!-- <script type="text/javascript" src="../../../library/js/jquery.js"></script> -->
<script>
$(function() {
	var cache = {},
		lastXhr;
	$( "#form_IPN_B09" ).autocomplete({
		minLength: 2,
		source: function( request, response ) {
			var term = request.term;
			if ( term in cache ) {
				response( cache[ term ] );
				return;
			}
			lastXhr = $.getJSON( "<?php echo $GLOBALS['webroot']; ?>/interface/forms/LBF/search.php", request, function( data, status, xhr ) {
				cache[ term ] = data;
				if ( xhr === lastXhr ) {
					response( data );
				}
			});
		}
	});
});
</script>
<script>
$(function() {
	var cache = {},
		lastXhr;
	$( "#form_IPN_B15" ).autocomplete({
		minLength: 2,
		source: function( request, response ) {
			var term = request.term;
			if ( term in cache ) {
				response( cache[ term ] );
				return;
			}
			lastXhr = $.getJSON( "<?php echo $GLOBALS['webroot']; ?>/interface/forms/LBF/searchmed.php", request, function( data, status, xhr ) {
				cache[ term ] = data;
				if ( xhr === lastXhr ) {
					response( data );
				}
			});
		}
	});
});
</script>
<script>
$(function() {
	var cache = {},
		lastXhr;
	$( "#form_PLA_5" ).autocomplete({
		minLength: 2,
		source: function( request, response ) {
			var term = request.term;
			if ( term in cache ) {
				response( cache[ term ] );
				return;
			}
			lastXhr = $.getJSON( "<?php echo $GLOBALS['webroot']; ?>/interface/forms/LBF/search.php", request, function( data, status, xhr ) {
				cache[ term ] = data;
				if ( xhr === lastXhr ) {
					response( data );
				}
			});
		}
	});
});
</script>
<script>
$(function() {
	var cache = {},
		lastXhr;
	$( "#form_PLA_13" ).autocomplete({
		minLength: 2,
		source: function( request, response ) {
			var term = request.term;
			if ( term in cache ) {
				response( cache[ term ] );
				return;
			}
			lastXhr = $.getJSON( "<?php echo $GLOBALS['webroot']; ?>/interface/forms/LBF/searchmed.php", request, function( data, status, xhr ) {
				cache[ term ] = data;
				if ( xhr === lastXhr ) {
					response( data );
				}
			});
		}
	});
});
</script>
<script>
$(function() {
	var cache = {},
		lastXhr;
	$( "#form_PLB_5" ).autocomplete({
		minLength: 2,
		source: function( request, response ) {
			var term = request.term;
			if ( term in cache ) {
				response( cache[ term ] );
				return;
			}
			lastXhr = $.getJSON( "<?php echo $GLOBALS['webroot']; ?>/interface/forms/LBF/search.php", request, function( data, status, xhr ) {
				cache[ term ] = data;
				if ( xhr === lastXhr ) {
					response( data );
				}
			});
		}
	});
});
</script>
<script>
$(function() {
	var cache = {},
		lastXhr;
	$( "#form_PLB_13" ).autocomplete({
		minLength: 2,
		source: function( request, response ) {
			var term = request.term;
			if ( term in cache ) {
				response( cache[ term ] );
				return;
			}
			lastXhr = $.getJSON( "<?php echo $GLOBALS['webroot']; ?>/interface/forms/LBF/searchmed.php", request, function( data, status, xhr ) {
				cache[ term ] = data;
				if ( xhr === lastXhr ) {
					response( data );
				}
			});
		}
	});
});
</script>
<script>
$(function() {
	var cache = {},
		lastXhr;
	$( "#form_PLC_5" ).autocomplete({
		minLength: 2,
		source: function( request, response ) {
			var term = request.term;
			if ( term in cache ) {
				response( cache[ term ] );
				return;
			}
			lastXhr = $.getJSON( "<?php echo $GLOBALS['webroot']; ?>/interface/forms/LBF/search.php", request, function( data, status, xhr ) {
				cache[ term ] = data;
				if ( xhr === lastXhr ) {
					response( data );
				}
			});
		}
	});
});
</script>
<script>
$(function() {
	var cache = {},
		lastXhr;
	$( "#form_PLC_13" ).autocomplete({
		minLength: 2,
		source: function( request, response ) {
			var term = request.term;
			if ( term in cache ) {
				response( cache[ term ] );
				return;
			}
			lastXhr = $.getJSON( "<?php echo $GLOBALS['webroot']; ?>/interface/forms/LBF/searchmed.php", request, function( data, status, xhr ) {
				cache[ term ] = data;
				if ( xhr === lastXhr ) {
					response( data );
				}
			});
		}
	});
});
</script>
<script>
    function getCustTimestamp(){
        var currentTime = new Date();
        var month = currentTime.getMonth() + 1;
        var day = currentTime.getDate();
        var year = currentTime.getFullYear();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        if (minutes < 10){
            minutes = "0" + minutes
        }
        var ts = month + "/" + day + "/" + year + " at " + hours + ":" + minutes;
        document.getElementById("form_timestorage").value = ts;
    }
</script>
<script type="text/javascript" src="../../../library/dialog.js"></script>
<script type="text/javascript" src="../../../library/textformat.js"></script>
<script type="text/javascript" src="../../../library/dynarch_calendar.js"></script>
<script type="text/javascript" src="../../../library/dynarch_calendar_en.js"></script>
<script type="text/javascript" src="../../../library/dynarch_calendar_setup.js"></script>

<script language="JavaScript">

var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';

// Supports customizable forms.
function divclick(cb, divid) {
 var divstyle = document.getElementById(divid).style;
 if (cb.checked) {
  divstyle.display = 'block';
 } else {
  divstyle.display = 'none';
 }
 return true;
}

// This is for callback by the find-code popup.
// Appends to or erases the current list of related codes.
function set_related(codetype, code, selector, codedesc) {
 var frc = document.getElementById('form_related_code');
 var s = frc.value;
 if (code) {
  if (s.length > 0) s += ';';
  s += codetype + ':' + code;
 } else {
  s = '';
 }
 frc.value = s;
}

// This invokes the find-code popup.
function sel_related() {
 dlgopen('<?php echo $rootdir ?>/patient_file/encounter/find_code_popup.php', '_blank', 500, 400);
}

<?php if (function_exists($formname . '_javascript')) call_user_func($formname . '_javascript'); ?>

</script>
</head>

<body <?php echo $top_bg_line; ?> topmargin="0" rightmargin="0" leftmargin="2" bottommargin="0" marginwidth="2" marginheight="0">
<form method="post" action="<?php echo $rootdir ?>/forms/LBF/new.php?formname=<?php echo $formname ?>&id=<?php echo $formid ?>"
 onsubmit="return top.restoreSession()">
<?php
    if(isset($_REQUEST["subset"])){
        echo "<input type='hidden' name='subset' id='subset' value='".$_REQUEST["subset"]."'/>";
    }
?>
<p class='title' style='margin-top:8px;margin-bottom:8px;text-align:center'>
<?php
  echo "$formtitle " . xl('for') . ' ';
  echo $enrow['fname'] . ' ' . $enrow['mname'] . ' ' . $enrow['lname'];
  echo ' ' . xl('on') . ' ' . substr($enrow['date'], 0, 10);
?>
</p>

<?php
  $shrow = getHistoryData($pid);
      $iplanHeaders = array("BIMPRESSION PLAN I","CIMPRESSION PLAN II","DIMPRESSION PLAN III","EIMPRESSION PLAN IV");
      $sigHeaders = array("GE_Sign");
      if(isset($_REQUEST["subset"])){
        $headInc = "'BIMPRESSION PLAN I','CIMPRESSION PLAN II','DIMPRESSION PLAN III','EIMPRESSION PLAN IV'";
        if($_REQUEST["subset"] == "iplan"){
            $fres = sqlStatement("SELECT * FROM layout_options WHERE form_id = '$formname' AND uor > 0 and group_name in (".$headInc.") ORDER BY group_name, seq");
        }
        if($_REQUEST["subset"] == "geSign"){
            $fres = sqlStatement("SELECT * FROM layout_options WHERE form_id = '$formname' AND uor > 0 and group_name = 'GE_Sign' ORDER BY group_name, seq");
        }
        if($_REQUEST["subset"] == "all"){
            $headInc = "'BIMPRESSION PLAN I','CIMPRESSION PLAN II','DIMPRESSION PLAN III','EIMPRESSION PLAN IV','GE_Sign'";
            $fres = sqlStatement("SELECT * FROM layout_options WHERE form_id = '$formname' AND uor > 0 and group_name not in (".$headInc.") ORDER BY group_name, seq");
        }            
    }else{
  $fres = sqlStatement("SELECT * FROM layout_options " .
    "WHERE form_id = '$formname' AND uor > 0 " .
    "ORDER BY group_name, seq");
    } 
  
  //}

  $last_group = '';
  $cell_count = 0;
  $item_count = 0;
  $display_style = 'block';

  while ($frow = sqlFetchArray($fres)) {
    $this_group = $frow['group_name'];
    $titlecols  = $frow['titlecols'];
    $datacols   = $frow['datacols'];
    $data_type  = $frow['data_type'];
    $field_id   = $frow['field_id'];
    $list_id    = $frow['list_id'];

    $currvalue  = '';

    if ($frow['edit_options'] == 'H') {
      // This data comes from static history
      if (isset($shrow[$field_id])) $currvalue = $shrow[$field_id];
    } else {
      if ($formid) {
        $pprow = sqlQuery("SELECT field_value FROM lbf_data WHERE " .
          "form_id = '$formid' AND field_id = '$field_id'");
        if (!empty($pprow)) $currvalue = $pprow['field_value'];
      }
      else {
        // New form, see if there is a custom default from a plugin.
        $fname = $formname . '_default_' . $field_id;
        if (function_exists($fname)) {
          $currvalue = call_user_func($fname);
        }
      }
    }

    // Handle a data category (group) change.
    if (strcmp($this_group, $last_group) != 0) {
      end_group();
      $group_seq  = 'lbf' . substr($this_group, 0, 1);
      $group_name = substr($this_group, 1);
      $last_group = $this_group;
      echo "<br /><span class='bold'><input type='checkbox' name='form_cb_$group_seq' value='1' " .
        "onclick='return divclick(this,\"div_$group_seq\");'";
      if ($display_style == 'block') echo " checked";
      echo " /><b>" . xl_layout_label($group_name) . "</b></span>\n";
      echo "<div id='div_$group_seq' class='section' style='display:$display_style;'>\n";
      echo " <table border='0' cellpadding='0' width='100%'>\n";
      $display_style = 'none';
    }

    // Handle starting of a new row.
    if (($titlecols > 0 && $cell_count >= $CPR) || $cell_count == 0) {
      end_row();
      echo " <tr>";
    }

    if ($item_count == 0 && $titlecols == 0) $titlecols = 1;

    // Handle starting of a new label cell.
    if ($titlecols > 0) {
      end_cell();
      echo "<td valign='top' colspan='$titlecols' width='1%' nowrap";
      echo ($frow['uor'] == 2) ? " class='required'" : " class='bold'";
      if ($cell_count == 2) echo " style='padding-left:10pt'";
      echo ">";
      $cell_count += $titlecols;
    }
    ++$item_count;

    echo "<b>";
    if ($frow['title']) echo (xl_layout_label($frow['title']) . ":"); else echo "&nbsp;";
    echo "</b>";

    // Handle starting of a new data cell.
    if ($datacols > 0) {
      end_cell();
      echo "<td valign='top' colspan='$datacols' class='text'";
      if ($cell_count > 0) echo " style='padding-left:5pt'";
      echo ">";
      $cell_count += $datacols;
    }

    ++$item_count;

    if ($frow['edit_options'] == 'H')
      echo generate_display_field($frow, $currvalue);
    else
      generate_form_field($frow, $currvalue);
  }

  end_group();
?>

<p style='text-align:center'>
<input type='submit' name='bn_save' value='Save' />
&nbsp;
<input type='button' value='Cancel' onclick="top.restoreSession();location='<?php echo $GLOBALS['form_exit_url']; ?>'" />
&nbsp;
</p>

</form>

<!-- include support for the list-add selectbox feature -->
<?php include $GLOBALS['fileroot'] . "/library/options_listadd.inc"; ?>

<script language="JavaScript">
<?php echo $date_init; ?>
<?php
if (function_exists($formname . '_javascript_onload')) {
  call_user_func($formname . '_javascript_onload');
}
// TBD: If $alertmsg, display it with a JavaScript alert().
?>
</script>

</body>
</html>