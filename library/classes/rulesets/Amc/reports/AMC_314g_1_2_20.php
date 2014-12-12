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

class AMC_314g_1_2_20 extends AbstractAmcReport
{
    public function getObjectToCount()
    {
        return "imaging_labs";
    }
    
    public function execute()
    {
        if ($GLOBALS['report_itemizing_temp_flag_and_id']) {
            $GLOBALS['report_itemized_test_id_iterator']++;
        }
        
        // Collect patients in the population we're counting only
        $patientString = "";
        $count = 0;
        foreach ( $this->_amcPopulation as $patient ) {
            $patientString .= $patient->id;
            if ( $count < count( $this->_amcPopulation ) - 1 ) {
                $patientString .= ",";
            }
            $count++;
        }
        error_log($patientString);
        
        // Fix empty begin date
        $tempBeginMeasurement = "";
        if ( empty($this->_beginMeasurement) ) {
            $tempBeginMeasurement = "1901-01-01";
        }
        else {
            $tempBeginMeasurement = $this->_beginMeasurement;
        }
        
        // Grab all imaging lab orders results for the demonator
        // Use procedure type "units" to narrow query to just imaging lab order results
        $sql = "SELECT RES.units, RES.document_id, PO.patient_id FROM " .
            "procedure_result RES " .
            "JOIN procedure_report REP ON REP.procedure_report_id = RES.procedure_report_id " .
            "JOIN procedure_order PO ON PO.procedure_order_id = REP.procedure_order_id " .
            "WHERE REP.date_collected >= ? AND REP.date_collected <= ? " .
            "AND RES.units = ? " .
            "AND PO.patient_id IN ( $patientString ) ";
        
        error_log( $sql );
        $resource = sqlStatement( $sql, array( $tempBeginMeasurement, $this->_endMeasurement, "Image" ) );
        
        // For the numerator, count all imaging lab orders that have a linked document
        $numeratorObjects = 0;
        $denominatorObjects = 0;
        while ( $row = sqlFetchArray( $resource ) ) {
            
            if ( $this->hasImageResult( $row ) ) {
                
                // Has a linked image/document in the result, increment numerator
                $numeratorObjects++;
            
                // If itemization is turned on, then record the "passed" item
                if ($GLOBALS['report_itemizing_temp_flag_and_id']) {
                    insertItemReportTracker( $GLOBALS['report_itemizing_temp_flag_and_id'], $GLOBALS['report_itemized_test_id_iterator'], 1, $row['patient_id'] );
                }
            
            } else {
            
                // If itemization is turned on, then record the "failed" item
                if ($GLOBALS['report_itemizing_temp_flag_and_id']) {
                    insertItemReportTracker( $GLOBALS['report_itemizing_temp_flag_and_id'], $GLOBALS['report_itemized_test_id_iterator'], 0, $row['patient_id'] );
                }
            
            }
            
            $denominatorObjects++;
        }
        
        $percentage = calculate_percentage( $denominatorObjects, 0, $numeratorObjects );
        $result = new AmcResult( $this->_rowRule, count($this->_amcPopulation), $denominatorObjects, 0, $numeratorObjects, $percentage );
        $this->_resultsArray[]= $result;
    }
    
    /**
     * 
     * @param array $row result row from procedure query
     * @return boolean
     * 
     * Returns true if the imaging procedure order in the $row
     * parameter has an associated linked document containing
     * imaging results.
     */
    protected function hasImageResult( $row )
    {
        // See if there is a linked document by searching for a document in procedure results
        if ( $row['document_id'] ) {
            return true;
        }
        
        return false;
    }
    
    public function getTitle()
    {
        return "AMC_314g_1_2_20";
    }

    public function createDenominator() 
    {
        
    }
    
    public function createNumerator()
    {
        
    }
}
