<?php
/**
 * Measure 22: Electronic Notes Numerator
 * 
 * Copyright (C) 2014 OEMR 501c3 www.oemr.org
 *
 * LICENSE: This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3
 * of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://opensource.org/licenses/gpl-license.php>;.
 *
 * @package OpenEMR
 * @author  Ken Chapple <ken@mi-squared.com>
 * @author  Medical Information Integration, LLC
 * @link    http://www.open-emr.org
 **/

class AMC_314g_1_2_22_Numerator implements AmcFilterIF
{
    public function getTitle()
    {
        return "AMC_314g_1_2_22 Numerator";
    }
    
    public function test( AmcPatient $patient, $beginDate, $endDate ) 
    {
		// The number of unique patients in the denominator who have at least one electronic
        // progress note from an eligible professional recorded as text-searchable data, which
        // we are considering any form (besides the new encounter form.)
        
        // An electronic note will populate the numerator if created, edited or signed by the EP 
        // or authorized provider of the EH/CAH before, during or after the reporting period as long as 
        // the patient for whom the note is created, was seen during the EHR reporting period.
        $encQry = "SELECT * FROM forms F ".
            "WHERE  F.formdir != 'newpatient' AND F.deleted = 0 AND F.pid = ? ";
        
        $check = sqlQuery( $encQry, array( $patient->id ) );
        if ( !empty( $check ) ){
            return true;
        }
        
        return false;
    }
}
