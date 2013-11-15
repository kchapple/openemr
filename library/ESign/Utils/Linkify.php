<?php

use ESign\Signature;

/**
 * Copyright (C) 2013 OEMR 501c3 www.oemr.org
 *
 * Utility to linkify
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

require_once $GLOBALS['srcdir'].'/ESign/Signature.php';

class Utils_Linkify
{
    public static function signatureType( $type )
    {
        $html = $type;
        if ( strpos( $type, Signature::TYPE_AMENDMENT ) !== false ) {
            $link = xl(Signature::TYPE_AMENDMENT, 'r', "<a href='javascript;' class='esign-amendment-link'>", "</a>" );
            $html = str_replace( Signature::TYPE_AMENDMENT, $link, $type );
        } 
        
        return $html;
    }
}
