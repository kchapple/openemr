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

class AMC_314g_1_2_19_Denominator implements AmcFilterIF
{
    public function getTitle()
    {
        return "AMC_314g_1_2_19 Denominator";
    }
    
    public function test( AmcObject $object ) 
    {
        return true;
    }
}
