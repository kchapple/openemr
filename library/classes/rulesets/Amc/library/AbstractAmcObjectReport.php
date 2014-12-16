<?php
/**
 * Abstract AMC Object report
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

class AbstractAmcObjectReport extends AbstractAmcReport
{
    public abstract function fetchPopulation();
    
    public function commaDelimPatientPopString()
    {
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
        
        return $patientString;
    }
    
    public function execute()
    {
        $this->onBeginExecute();
        
        $population = $this->fetchPopulation();
    
        $numerator = $this->createNumerator();
        $denominator = $this->createDenominator();
        
        $numeratorObjects = 0;
        $denominatorObjects = 0;
        foreach ( $population as $object ) {
    
            if ( $denominator->test( $object ) ) {
                
                if ( $numerator->test( $object ) ) {
        
                    $numeratorObjects++;
        
                    $this->onNumeratorPass( $object->getPatient() );
        
                } else {
        
                    $this->onNumeratorFail( $object->getPatient() );
                    
                }
        
                $denominatorObjects++;
            }
        }
    
        $percentage = calculate_percentage( $denominatorObjects, 0, $numeratorObjects );
        $result = new AmcResult( $this->_rowRule, count($this->_amcPopulation), $denominatorObjects, 0, $numeratorObjects, $percentage );
        $this->_resultsArray[]= $result;
    }
    
    public function getObjectToCount()
    {
        return null;
    }
}
