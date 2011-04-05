<?php
				if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

			$TCA['tx_pmshopr_products'] = array (
				'ctrl' => $TCA['tx_pmshopr_products']['ctrl'],
				'interface' => array (
					'showRecordFieldList' => 'hidden,starttime,endtime,titel,beschreibung,bild,preis,anzahl,counter'
				),
				'feInterface' => $TCA['tx_pmshopr_products']['feInterface'],
				'columns' => array (
		'hidden' => array (		
							'exclude' => 1,
							'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
							'config'  => array (
								'type'    => 'check',
								'default' => '0'
							)
						),
		'starttime' => array (		
							'exclude' => 1,
							'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
							'config'  => array (
								'type'     => 'input',
								'size'     => '8',
								'max'      => '20',
								'eval'     => 'date',
								'default'  => '0',
								'checkbox' => '0'
							)
						),
		'endtime' => array (		
							'exclude' => 1,
							'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
							'config'  => array (
								'type'     => 'input',
								'size'     => '8',
								'max'      => '20',
								'eval'     => 'date',
								'checkbox' => '0',
								'default'  => '0',
								'range'    => array (
									'upper' => mktime(3, 14, 7, 1, 19, 2038),
									'lower' => mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))
								)
							)
						),
		'titel' => array (		
							'exclude' => 0,		
							'label' => 'LLL:EXT:pm_shopr/locallang_db.xml:tx_pmshopr_products.titel',		
							'config' => array (
				'type' => 'input',	
				'size' => '30',
							)
						),
		'beschreibung' => array (		
							'exclude' => 0,		
							'label' => 'LLL:EXT:pm_shopr/locallang_db.xml:tx_pmshopr_products.beschreibung',		
							'config' => array (
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
				'wizards' => array(
											'_PADDING' => 2,
					'RTE' => array(
												'notNewRecords' => 1,
												'RTEonly'       => 1,
												'type'          => 'script',
												'title'         => 'Full screen Rich Text Editing|Formatteret redigering i hele vinduet',
												'icon'          => 'wizard_rte2.gif',
												'script'        => 'wizard_rte.php',
											),
										),
							)
						),
		'bild' => array (		
							'exclude' => 0,		
							'label' => 'LLL:EXT:pm_shopr/locallang_db.xml:tx_pmshopr_products.bild',		
							'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_pmshopr',
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
							)
						),
		'preis' => array (		
							'exclude' => 0,		
							'label' => 'LLL:EXT:pm_shopr/locallang_db.xml:tx_pmshopr_products.preis',		
							'config' => array (
				'type' => 'input',	
				'size' => '30',
							)
						),
		'anzahl' => array (		
							'exclude' => 0,		
							'label' => 'LLL:EXT:pm_shopr/locallang_db.xml:tx_pmshopr_products.anzahl',		
							'config' => array (
				'type'     => 'input',
									'size'     => '4',
									'max'      => '4',
									'eval'     => 'int',
									'checkbox' => '0',
									'range'    => array (
										'upper' => '1000',
										'lower' => '10'
									),
									'default' => 0
							)
						),
		'counter' => array (		
							'exclude' => 0,		
							'label' => 'LLL:EXT:pm_shopr/locallang_db.xml:tx_pmshopr_products.counter',		
							'config' => array (
				'type'     => 'input',
									'size'     => '4',
									'max'      => '4',
									'eval'     => 'int',
									'checkbox' => '0',
									'range'    => array (
										'upper' => '1000',
										'lower' => '10'
									),
									'default' => 0
							)
						),
				),
				'types' => array (
					'0' => array('showitem' => 'hidden;;1;;1-1-1, titel, beschreibung;;;richtext[]:rte_transform[mode=ts], bild, preis, anzahl, counter')
				),
				'palettes' => array (
					'1' => array('showitem' => 'starttime, endtime')
				)
			);



			$TCA['tx_pmshopr_bookings'] = array (
				'ctrl' => $TCA['tx_pmshopr_bookings']['ctrl'],
				'interface' => array (
					'showRecordFieldList' => 'hidden,user_uid,product'
				),
				'feInterface' => $TCA['tx_pmshopr_bookings']['feInterface'],
				'columns' => array (
		'hidden' => array (		
							'exclude' => 1,
							'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
							'config'  => array (
								'type'    => 'check',
								'default' => '0'
							)
						),
		'user_uid' => array (		
							'exclude' => 0,		
							'label' => 'LLL:EXT:pm_shopr/locallang_db.xml:tx_pmshopr_bookings.user_uid',		
							'config' => array (
				'type' => 'group',	
				'internal_type' => 'db',	
				'allowed' => 'fe_users',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
							)
						),
		'product' => array (		
							'exclude' => 0,		
							'label' => 'LLL:EXT:pm_shopr/locallang_db.xml:tx_pmshopr_bookings.product',		
							'config' => array (
				'type' => 'group',	
				'internal_type' => 'db',	
				'allowed' => 'tx_pmshopr_products',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
							)
						),
				),
				'types' => array (
					'0' => array('showitem' => 'hidden;;1;;1-1-1, user_uid, product')
				),
				'palettes' => array (
					'1' => array('showitem' => '')
				)
			);
				?>