<?php

namespace ESign;

/**
 * Copyright (C) 2013 OEMR 501c3 www.oemr.org
 *
 * Abstract implementation of SignableIF which represents a signable row
 * in the database.
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

require_once $GLOBALS['srcdir'].'/ESign/SignableIF.php';
require_once $GLOBALS['srcdir'].'/ESign/Signature.php';
require_once $GLOBALS['srcdir'].'/ESign/Utils/Verification.php';

abstract class DbRow_Signable implements SignableIF
{   
    private $_signatures = array();
    private $_tableId = null;
    private $_tableName = null;
    private $_verificaiton = null;

    public function __construct( $tableId, $tableName )
    {
        $this->_tableId = $tableId;
        $this->_tableName = $tableName;
        $this->_verificaiton = new Utils_Verification();
    }
    
    public function getSignatures()
    {
        $this->_signatures = array();
        
        $statement = "SELECT E.id, E.tid, E.table, E.uid, U.fname, U.lname, E.datetime, E.type, E.amendment, E.hash FROM esign_signatures E ";
        $statement .= "JOIN users U ON E.uid = U.id ";
        $statement .= "WHERE E.tid = ? AND E.table = ? ";
        $statement .= "ORDER BY E.datetime DESC";
        $result = sqlStatement( $statement, array( $this->_tableId, $this->_tableName ) );
        
        while ( $row = sqlFetchArray( $result ) ) {
            $signature = new Signature( $row['id'], $row['type'], $row['uid'], $row['fname'], $row['lname'], $row['datetime'], $row['hash'], $row['amendment'] );
            $this->_signatures[]= $signature;
        }
        
        return $this->_signatures;
    }
    
    /**
     * Get the hash of the last signature of type LOCK.
     * 
     * This is used for comparison with a current hash to
     * verify data integrity.
     * 
     * @return sha1|empty string
     */
    protected function getLastLockHash()
    {
        $statement = "SELECT E.tid, E.table, E.hash FROM esign_signatures E ";
        $statement .= "WHERE E.tid = ? AND E.table = ? AND E.type LIKE ? ";
        $statement .= "ORDER BY E.datetime DESC LIMIT 1";
        $testLock = "%".Signature::TYPE_LOCK."%";
        $row = sqlQuery( $statement, array( $this->_tableId, $this->_tableName, $testLock ) );
        $hash = '';
        if ( $row && isset($row['hash']) ) {
            $hash = $row['hash'];
        }
        return $hash;
    }
    
    public function getTableId()
    {
        return $this->_tableId;
    }
    
    public function renderForm()
    {
        include 'views/esign_signature_log.php';
    }
    
    public function isLocked()
    {
        $statement = "SELECT E.type FROM esign_signatures E ";
        $statement .= "WHERE E.tid = ? AND E.table = ? AND E.type LIKE ? ";
        $statement .= "ORDER BY E.datetime DESC LIMIT 1 ";
        $testLock = "%".Signature::TYPE_LOCK."%";
        $row = sqlQuery( $statement, array( $this->_tableId, $this->_tableName, $testLock ) );
        if ( strpos( $row['type'], Signature::TYPE_LOCK ) !== false ) {
            return true;
        }
        
        return false;
    }

    public function sign( $userId, $lock = false, $amendment = null )
    {
        $statement = "INSERT INTO `esign_signatures` ( `tid`, `table`, `uid`, `datetime`, `type`, `hash`, `amendment` ) ";
        $statement .= "VALUES ( ?, ?, ?, NOW(), ?, ?, ? ) ";
        
        // Make type string
        $type = Signature::TYPE_SIG;
        if ( $lock ) {
            $type .= ",".Signature::TYPE_LOCK;
        }
        if ( $amendment ) {
            $type .= ",".Signature::TYPE_AMENDMENT;
        }
        
        $hash = $this->_verificaiton->hash( $this );
        
        $id = sqlInsert( $statement, array( 
                $this->_tableId, 
                $this->_tableName, 
                $userId, 
                $type, 
                $hash,
                $amendment ) );
        
        if ( $id === false ) {
            throw new \Exception( "Error occured while attempting to insert a signature into the database." );
        }
        
        return $id;
    }
    
    public function verify()
    {
        // Check to see if this form is locked (either individually, or by the parent encounter)
        if ( $this->isLocked() ) {
            // Form is locked, so if it has any signatures, make sure it hasn't been edited since lock
            if ( count( $this->getSignatures() ) ) {
                $lastLockHash = $this->getLastLockHash();
                // If this form was locked by parent encounter, there may have never been an explicit 
                // lock on it. We ignore the hash if there was no explicit lock TODO make more secure.
                if ( $lastLockHash ) {
                    $currentHash = $this->_verificaiton->hash( $this );
                    if ( $lastLockHash != $currentHash ) {
                        return false;
                    }
                }
            }
        }
        
        return true;
    }
}

