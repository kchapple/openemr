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
    public function execute()
    {
        if ($GLOBALS['report_itemizing_temp_flag_and_id']) {
            $GLOBALS['report_itemized_test_id_iterator']++;
        }
        
        // Grab all imaging lab orders for the denominator
        // TODO use LOINC code or similar to narrow query to just imaging lab orders
        $sql = "SELECT * FROM " .
            "procedure_order PO " .
            "JOIN procedure_order_code PC ON PC.procedure_order_id = PO.procedure_order_id " .
            "JOIN procedure_report PR ON PR.procedure_order_id = PO.procedure_order_id " .
            "LEFT JOIN patient_data PD ON PD.pid = PO.patient_id " .
            "WHERE PR.date_collected >= ? AND PR.date_collected <= ?";
        
        $resource = sqlStatement( $statement, array( $this->_beginMeasurement, $this->_endMeasurement ) );
        
        // For the numerator, count all imaging lab orders that have a linked document
        $numeratorObjects = 0;
        $denominatorObjects = 0;
        while ( $row = sqlFetchArray( $resource ) ) {
            
            if ( $this->hasImageResult( $row ) ) {
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
        $result = new AmcResult( $this->_rowRule, $totalPatients, $denominatorObjects, 0, $numeratorObjects, $percentage );
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
        // TODO Implement function
        return true;
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
