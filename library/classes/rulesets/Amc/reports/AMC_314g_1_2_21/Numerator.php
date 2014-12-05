<?php
/**
 * Measure 21: Family Health History
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
class AMC_314g_1_2_21_Numerator implements AmcFilterIF
{
    public function getTitle()
    {
        return "AMC_314g_1_2_21 Numerator";
    }
    
    public function test( AmcPatient $patient, $beginDate, $endDate )
    {
        // The number of patients in the denominator with a structured data entry for one or more 
        // first-degree relatives (parents, siblings, and offspring)
        $statement = "SELECT `history_mother`, `dc_mother`, `history_father`, `dc_father`, `history_siblings`, `dc_siblings`, `history_offspring`, `dc_offspring`
                FROM `history_data` WHERE `pid`=? ORDER BY id DESC LIMIT 1";
        
        $history = sqlQuery( $statement, array( $patient->id ) );
        
        $found = false;
        foreach ( $history as $key => $value ) {
            if ( strpos( $key, "history" ) === 0 &&
                strtolower( $value ) == "unknown" ) {
                // "unknown" entry in freeform text field
                $found = true;
                break;
            } else if ( strpos( $key, "dc" ) === 0 &&
                strlen( $value ) > 0 ) {
                // diagnosis code in "Diagnosis Code" field
                $found = true;
                break;
            }
        }
        
        return $found;
    }
}
