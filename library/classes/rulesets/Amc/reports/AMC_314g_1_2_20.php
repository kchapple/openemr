<?php
/**
 * Measure 20: Imaging
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

class AMC_314g_1_2_20 extends AbstractAmcObjectReport
{
    public function fetchPopulation()
    {
        // Collect patients in the population we're counting only
        $patientString = $this->commaDelimPatientPopString();
        
        // Grab all imaging lab orders results for the demonator
        // Use procedure type "units" to narrow query to just imaging lab order results
        $sql = "SELECT P.DOB, P.pid, RES.units, RES.document_id FROM " .
                "procedure_result RES " .
                "JOIN procedure_report REP ON REP.procedure_report_id = RES.procedure_report_id " .
                "JOIN procedure_order PO ON PO.procedure_order_id = REP.procedure_order_id " .
                "JOIN patient_data P ON PO.patient_id = P.pid " .
                "WHERE REP.date_collected >= ? AND REP.date_collected <= ? " .
                "AND RES.units = ? " .
                "AND P.pid IN ( $patientString ) ";
        
        error_log( $sql );
        $resource = sqlStatement( $sql, array( $this->getBeginMeasurement(), $this->_endMeasurement, "Image" ) );
        
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
        return "AMC_314g_1_2_20";
    }
    
    public function createNumerator()
    {
        return new AMC_314g_1_2_20_Numerator();
    }
    
    public function createDenominator()
    {
        return new AMC_314g_1_2_20_Denominator();
    }
}
