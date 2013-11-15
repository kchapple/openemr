<?php

namespace ESign;

/**
 * Copyright (C) 2013 OEMR 501c3 www.oemr.org
 *
 * Signature class 
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
 * @link    http://www.mi-squared.com
 **/

class Signature
{
    const TYPE_SIG = 'sig';
    const TYPE_AMENDMENT = 'amendment';
    const TYPE_LOCK = 'lock';
    
    private $id;
    private $type;
    private $uid;
    private $firstName;
    private $lastName;
    private $datetime;
    private $hash;
    private $amendment = null;
    
    public function __construct( $id, $type, $uid, $firstName, $lastName, $datetime, $hash, $amendment = null )
    {
        $this->id = $id;
        $this->type = $type;
        $this->uid = $uid;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->datetime = $datetime;
        $this->hash = $hash;
        $this->amendment = $amendment;
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
    
    public function getType()
    {
        return $this->type;
    }
    
    public function getAmendment()
    {
        return $this->amendment;
    }
}
