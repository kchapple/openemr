<?php
/**
 * Measure 19: Secure Messaging
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

class AMC_314g_1_2_19 extends AbstractAmcObjectReport
{   
    public function fetchPopulation()
    {
        // Collect patients in the population we're counting only
        $patientString = $this->commaDelimPatientPopString();
        
        // Grab all UNIQUE patients seen in the range for the demonator
        $sql = "SELECT P.DOB, P.pid, N.id AS note_id  FROM
                ( SELECT P.DOB, P.pid
                  FROM form_encounter FE
                  JOIN patient_data P ON FE.pid = P.pid
                  WHERE FE.date >= ? AND FE.date <= ?
                  AND PO.patient_id IN ( $patientString )
                  GROUP BY P.pid
                ) P
            LEFT OUTER JOIN pnotes N ON N.user = P.pid";
                
        $resource = sqlStatement( $sql, array( $tempBeginMeasurement, $this->_endMeasurement ) );
        
        // For the numerator, count all imaging lab orders that have a linked document
        $objects = array();
        while ( $row = sqlFetchArray( $resource ) ) {
            $patient = new AmcPatient( $row['pid'], $row['DOB'] );
            $object = new AmcObject( $patient, $row );
            $objects[]= $objects;
        }
        
        return $objects;
    }
    
    
    public function getTitle()
    {
        return "AMC_314g_1_2_19";
    }
    
    public function createNumerator()
    {
        return new AMC_314g_1_2_19_Numerator();
    }
}
