<?php

namespace ESign;

/**
 * Signature class 
 * 
 * Copyright (C) 2013 OEMR 501c3 www.oemr.org
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

class Signature
{
    const ESIGN_NOLOCK = 0;
    const ESIGN_LOCK = 1;
    
    private $id;

    private $isLock = null;
    private $uid;
    private $firstName;
    private $lastName;
    private $datetime;
    private $hash;
    private $amendment = null;
    
    public function __construct( $id, $isLock, $uid, $firstName, $lastName, $datetime, $hash, $amendment = null )
    {
        $this->id = $id;
        $this->isLock = $isLock;
        $this->uid = $uid;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->datetime = $datetime;
        $this->hash = $hash;
        $this->amendment = $amendment;
    }
    
    public function getClass()
    {
       $class = "";
       if ( $this->isLock() === true ) {
           $class .= " locked";
       }
       
       return $class;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUid()
    {
        return $this->uid;
    }

    public function setUid($uid)
    {
        $this->uid = $uid;
    }
    
    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }
    
    public function getDatetime()
    {
        return $this->datetime;
    }
    
    public function isLock()
    {
        if ( $this->isLock > 0 ) {
            return true;
        }
        
        return false;
    }
    
    public function getAmendment()
    {
        return $this->amendment;
    }
}
