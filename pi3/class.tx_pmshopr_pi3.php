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
 * Plugin 'Shopr* Teaser' for the 'pm_shopr' extension.
 *
 * @author	dkoehl <koehl@pm-newmedia.com>
 * @package	TYPO3
 * @subpackage	tx_pmshopr
 */
class tx_pmshopr_pi3 extends tslib_pibase {
    var $prefixId      = 'tx_pmshopr_pi3';		// Same as class name
    var $scriptRelPath = 'pi3/class.tx_pmshopr_pi3.php';	// Path to this script relative to the extension dir.
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
        $this->templatefile = 'typo3conf/ext/pm_shopr/pi3/template.html';


        $content = $this->makeList($this->getNextProducts());
        return $this->pi_wrapInBaseClass($content);
    }
    /*
     * Get future products
     *
     * @params  string  $res;
     */
    private function getNextProducts(){
		$where = " pid = ".$this->conf['pidlist']." AND deleted = 0 AND starttime > ".time()." ORDER BY starttime ASC";
        $sql = $GLOBALS["TYPO3_DB"]->exec_SELECTquery("*",$this->dbTableProducts,$where);
        while($row = $GLOBALS["TYPO3_DB"]->sql_fetch_assoc($sql)){
            $res[] = $row;
        }
        return $res;
    }
    /*
     * Makes listview from data
     *
     * @param   array   $items
     * @param   string  $res
     */
    private function makeList($items){
        if($this->conf['templateFile']){
            $this->tmplfile = $this->conf['templateFile'];
        } else {
            $this->tmplfile = $this->templatefile;
        }
 		$this->templateCode = $this->cObj->fileResource($this->tmplfile);
		$template['total'] = $this->cObj->getSubpart($this->templateCode,'###LISTTEMPLATE###');
        $markerArray['###LISTITEM###'] = '';
        for($i=0; $i<count($items); $i++){
            $markerArray['###LISTITEM###'] .= '<div class="pm_shopr_listitems">';
            $markerArray['###LISTITEM###'] .= '<h3>'.$items[$i]['titel']. '</h3>';
            $markerArray['###LISTITEM###'] .= '<img src="uploads/tx_pmshopr/'.$items[$i]['bild'].'" border="0" width="50" style="float:left;">';
            $markerArray['###LISTITEM###'] .= 'Startzeit: '.date("d.m.Y",$items[$i]['starttime']);
            $markerArray['###LISTITEM###'] .= '<h2>'.$this->conf['unit'].' '.$items[$i]['preis'].'</h2>';
            $markerArray['###LISTITEM###'] .= '</div>';
        }
		$content = $this->cObj->substituteMarkerArrayCached($template['total'], $markerArray, array());
        return $content;
    }
}
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pm_shopr/pi3/class.tx_pmshopr_pi3.php'])	{
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pm_shopr/pi3/class.tx_pmshopr_pi3.php']);
}

			?>