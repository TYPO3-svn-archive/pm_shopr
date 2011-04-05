<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 dkoehl <koehl@pm-newmedia.com>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
  * [CLASS/FUNCTION INDEX of SCRIPT]
  *
  * Hint: use extdeveval to insert/update function index above.
  */

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Shopr* Entertainment' for the 'pm_shopr' extension.
 *
 * @author	dkoehl <koehl@pm-newmedia.com>
 * @package	TYPO3
 * @subpackage	tx_pmshopr
 */
class tx_pmshopr_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_pmshopr_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_pmshopr_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'pm_shopr';	// The extension key.
	var $pi_checkCHash = true;

	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		$this->dbTableProducts = 'tx_pmshopr_products';
        $this->dbTableBookings = 'tx_pmshopr_bookings';
        $this->templatefile = 'EXT:pm_shopr/pi1/template.html';

        
        $item = $this->getActualProduct();

        if(t3lib_div::_POST()){
            if($this->saveOrder($item)){
                $this->showMsg('Bestellung erfolgreich', 'ok');
                echo '<meta http-equiv="refresh" content="2; url=index.php?id='.$this->conf['pid'].'/"> ';
            }
        }

        if($item){
            $content = $this->getShopTemplate($item);			// ausgabe
        } else {
            $content = '<h2><center>Kein Produkt vorhanden</center></h2>';
        }

        
		return $this->pi_wrapInBaseClass($content);
	}
	/*
	 * Gets the actually uses product
	 */
	private function getActualProduct(){
		$where = " uid =1 AND deleted = 0 ";
		$addWhere = 'pid = '. $this->conf['pidlist'] . ' ' . $this->cObj->enableFields($this->dbTableProducts);
		$sql = $GLOBALS["TYPO3_DB"]->exec_SELECTquery("*",$this->dbTableProducts,$addWhere);
		while($row = $GLOBALS["TYPO3_DB"]->sql_fetch_assoc($sql)){
			$data[] = $row;
		}
		foreach($data[0] as $key => $val){
			$res[$key] = $val;
		}
		return $res;
	}
	/*
	 * Renders the Template
	 */
	function getShopTemplate($item){
        if($this->conf['templateFile']){
            $this->tmplfile = $this->conf['templateFile'];
        } else {
            $this->tmplfile = $this->templatefile;
        }
 		$this->templateCode = $this->cObj->fileResource($this->tmplfile);
		$template['total'] = $this->cObj->getSubpart($this->templateCode,'###SHOPTEMPLATE###');
		$markerArray['###COUNTDOWN###'] = $this->countDown($item['endtime']);
		$markerArray['###TITLE###'] = $item['titel'];
		$markerArray['###DESC###'] = $item['beschreibung'];
		$markerArray['###IMAGE###'] = 'uploads/tx_pmshopr/'.$item['bild'];
		$markerArray['###PRICE###'] = $this->conf['unit'].' ' .$item['preis'];
        $markerArray['###RELATED###'] = '';
        if($GLOBALS["TSFE"]->fe_user->user["uid"]){
            if($this->checkSum($item)){
                $markerArray['###BOOKING###'] = $this->makeOrderForm($item['uid']);
            } else {
                $markerArray['###BOOKING###'] = '';
                $markerArray['###PRICE###'] = $this->soldOut();
            }

        } else {
            $markerArray['###BOOKING###'] = $this->gotoLogin($item['uid']);
        }

		$content = $this->cObj->substituteMarkerArrayCached($template['total'], $markerArray, array());

		return $content;
	}
	/*
	 * Generating JS for Countdown
	 * @param	string	$time
	 */
	private function countDown($endtime){
		$this->template = $this->cObj->fileResource('typo3conf/ext/pm_shopr/countdown.html');
		$template['total'] = $this->cObj->getSubpart($this->template,'###COUNTDOWNTMPL###');
		$markerArray['###ENDTIME###'] = $this->getEndTime($endtime);
		$content = $this->cObj->substituteMarkerArrayCached($template['total'], $markerArray, array());
		return $content;
	}
	/*
	 * Gets the end time of actuall product
	 */
	private function getEndTime($time){
        $time = 'var CountdownJahr = '.date("Y", $time).';
                var CountdownMonat = '.date("m", $time).';
                var CountdownTag = '.date("d", $time).';
                var CountdownStunde = '.date("H", $time).';
                var CountdownMinute = '.date("i", $time).';
                var CountdownSekunde = '.date("s", $time).';';
        return $time;
	}
	/*
	 * Generates the order form
	 */
	private function makeOrderForm($uid){
		$form = '<form name="form1" method="post" action="">
				  	<input type="hidden" name="productuid" value="'.$uid.'" id="hiddenField">
				    <input type="submit" name="button" id="button" value="Bestellen">
				</form>';
		return $form;
	}
    /*
     * Links to LoginPage defined by loginpid
     */
    private function gotoLogin($uid){
        $form = '<form name="form1" method="post" action="'.$this->pi_getPageLink($this->conf['loginpid'],"_blank",array("productuid" => $uid)).'">
				  	<input type="hidden" name="productuid" value="'.$uid.'" id="hiddenField">
				    <input type="submit" name="button" id="button" value="Erst Einloggen">
				</form>';
        return $form;
    }
    /*
     * SOLD OUT
     */
    private function soldOut(){
        $form = '<h2>Ausverkauft!</h2>';
        return $form;
    }
    /* SAVEORDERS
     *
     * Saves new bookings in relation Table
     * @param   String  $uid
     */
    private function saveOrder($item){
        if($this->checkSum($item)){
            $fields_values = array('user_uid' => $GLOBALS["TSFE"]->fe_user->user["uid"], 'pid' => $this->conf['pidlist'], 'product' => $item['uid'], 'tstamp' => time());
            $sql = $GLOBALS["TYPO3_DB"]->exec_INSERTquery($this->dbTableBookings,$fields_values);
            $this->countBookings($item);
            return true;
        }
        return false;

    }
    /* COUNT ORDERS
     *
     * Counter for bookings
     */
    private function countBookings($item){
        if($this->checkSum($item)){
            $counter = $item['counter']+1;
            $where = " uid = ".$item['uid']." ";
            $res = $GLOBALS["TYPO3_DB"]->exec_UPDATEquery($this->dbTableProducts,$where,array('counter'=>$counter));
            return $res;
        } else {
            return false;
        }

    }
    /*
     *  CheckSum
     *
     *  Checks availability of an product
     */
    private function checkSum($item){
        if($item['counter'] == $item['anzahl']){
            return false;
        } else {
            return true;
        }

    }

    /*
     *  Makes status messages
     *  color: red / green
     */
    public function showMsg($msg, $status){
        if($status == 'ok'){
            echo '<div style="background-color:#fff; padding:10px; width:auto; margin:10px; border:2px solid green; color:green; font-size:18px; text-align:center;">';
            echo $msg;
            echo '</div>';
        }
    }
}
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pm_shopr/pi1/class.tx_pmshopr_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pm_shopr/pi1/class.tx_pmshopr_pi1.php']);
}

?>