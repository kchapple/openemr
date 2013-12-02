<?php 
/**
 * Signature log view script for form module
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
?>
<div id='esign-signature-log-<?php echo attr( $this->logId ); ?>' class='esign-signature-log-container'>
    <table class="esign-signature-log-table">
        <tr>
            <td colspan=4 class='body_title' style='text-align:center;'><?php echo xlt('eSign Log'); ?></td>
        </tr>
        
        <?php if ( !$this->verified ) { ?>
        <tr>
            <td colspan=4 style='text-align:center;color:red;'><?php echo xlt('The data integrity test failed for this form'); ?></td>
        </tr>
        <?php } ?>
        
        <?php foreach ( $this->signatures as $signature ) { ?>
        <tr>
            <td><?php echo text( $signature->getFirstName() ); ?></td> 
            <td><?php echo text( $signature->getLastName() ); ?></td> 
            <td><?php echo Utils_Linkify::signatureType( $signature->getType() ); ?></td> 
            <td><?php echo text( $signature->getDatetime() ); ?></td>
        </tr>
        <?php if ( $signature->getAmendment() ) { ?>
        <tr class='esign-log-amendment-row' style='display: none;'>
            <td colspan=4 style='text-align:left;padding:8px;background-color:#FEDF98;;'>
            <?php echo text( $signature->getAmendment() ); ?>
            </td>
        </tr>
        <?php } ?>
        <?php } ?>
        
        <?php if ( count( $this->signatures ) === 0 ) { ?>
        <tr>
            <td><?php echo xlt('No signatures on file'); ?></td>
        </tr>
        <?php } ?>

    </table>
</div>
