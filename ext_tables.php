<?php
				if (!defined ('TYPO3_MODE')) {
					die ('Access denied.');
				}
			$TCA['tx_pmshopr_products'] = array (
				'ctrl' => array (
		'title'     => 'LLL:EXT:pm_shopr/locallang_db.xml:tx_pmshopr_products',		
					'label'     => 'titel',	
					'tstamp'    => 'tstamp',
					'crdate'    => 'crdate',
					'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
			'starttime' => 'starttime',	
			'endtime' => 'endtime',
						),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_pmshopr_products.gif',
				),
			);

			$TCA['tx_pmshopr_bookings'] = array (
				'ctrl' => array (
		'title'     => 'LLL:EXT:pm_shopr/locallang_db.xml:tx_pmshopr_bookings',		
					'label'     => 'uid',	
					'tstamp'    => 'tstamp',
					'crdate'    => 'crdate',
					'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY product',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
						),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_pmshopr_bookings.gif',
				),
			);


					t3lib_div::loadTCA('tt_content');
					$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


				t3lib_extMgm::addPlugin(array(
					'LLL:EXT:pm_shopr/locallang_db.xml:tt_content.list_type_pi1',
					$_EXTKEY . '_pi1',
					t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
				),'list_type');


				if (TYPO3_MODE == 'BE') {
					$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_pmshopr_pi1_wizicon'] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_pmshopr_pi1_wizicon.php';
				}


					t3lib_div::loadTCA('tt_content');
					$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi2']='layout,select_key';


				t3lib_extMgm::addPlugin(array(
					'LLL:EXT:pm_shopr/locallang_db.xml:tt_content.list_type_pi2',
					$_EXTKEY . '_pi2',
					t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
				),'list_type');


					t3lib_div::loadTCA('tt_content');
					$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi3']='layout,select_key';


				t3lib_extMgm::addPlugin(array(
					'LLL:EXT:pm_shopr/locallang_db.xml:tt_content.list_type_pi3',
					$_EXTKEY . '_pi3',
					t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
				),'list_type');


				if (TYPO3_MODE == 'BE') {
					$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_pmshopr_pi3_wizicon'] = t3lib_extMgm::extPath($_EXTKEY).'pi3/class.tx_pmshopr_pi3_wizicon.php';
				}

t3lib_extMgm::addStaticFile($_EXTKEY,'static/pm_shopr/', 'pm_shopr');
				?>