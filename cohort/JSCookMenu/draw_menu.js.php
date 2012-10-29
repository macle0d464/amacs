<? session_start(); ?>
var pageurl = window.location.href;
pageurl = pageurl.substr(24, pageurl.length);
pageurl = pageurl.substr(0, pageurl.indexOf(".php"));
var extra = "?code=" + "<? echo $_SESSION['PatientCode'] ?>";

var cohortMenu =
[
	[null,'Επιστροφή','index.php',null,null
	],
	[null,'Δημογραφικά Στοιχεία','demographic.php'+extra,'_self',null
	],	
	[null,'Λοίμωξη HIV',null,null,null,		
		[null,'Στάδιο νόσου','clinical_status.php'+extra,'_self',null],
		[null,'Κλινική Κατάσταση','atomic.php'+extra,'_self',null],
		[null,'IRIS','iris.php'+extra,'_self',null],
		[null,'Υπότυπος και Αντοχή','hiv_resistance.php'+extra,'_self',null],
		_cmSplit,
		[null,'Εξετάσεις',null,null,null,
			[null,'Αιματολογικές','/cohort/aimatologikes.php'+extra,null,null],
			[null,'Ανοσολογικές','/cohort/anosologikes.php'+extra,null,null],
			[null,'Βιοχημικές','/cohort/bioximikes.php'+extra,'_self',null],
			[null,'Ιολογικές','/cohort/iologikes.php'+extra,'_self',null],
			[null,'Ορολογικές','/cohort/orologikes.php'+extra,'_self',null],
			[null,'Γενική Ούρων','/cohort/ourwn.php'+extra,'_self',null],
			[null,'Λοιπές παρακλινικές','/cohort/other_exams.php'+extra,'_self',null],			
		],
		_cmSplit,
		[null,'Θεραπείες',null,null,null,
			[null,'Αντιρετροϊκές','/cohort/antiretro.php'+extra,null,null],
			[null,'Προφυλακτικές','/cohort/prophylactic.php'+extra,'_self',null],
			[null,'\'Aλλες','/cohort/alles.php'+extra,'_self',null]
		]		
	],
	[null,'Συλλοιμώξεις HBV & HCV',null,null,null,
		[null,'Καταχώρηση Συλλοίμωξης','coinfection.php'+extra,'_self',null],
		_cmSplit,
		[null,'Συλλοιμώξεις HBV',null,null,null,
			[null,'Κλινική Κατάσταση','hbv_clinical_status.php'+extra,'_self',null],
			[null,'Ιολογική Παρακολούθηση','hbv_iolog_observe.php'+extra,'_self',null],
			[null,'Ιστολογία \'Ηπατος','hbv_istology.php'+extra,'_self',null],
			[null,'Θεραπείες','hbv_other_treatments.php'+extra,'_self',null]
		],
		[null,'Συλλοιμώξεις HCV',null,null,null,
			[null,'Κλινική Κατάσταση','hcv_clinical_status.php'+extra,'_self',null],
			[null,'Ιολογική Παρακολούθηση','hcv_iolog_observe.php'+extra,'_self',null],
			[null,'Ιστολογία \'Ηπατος','hcv_istology.php'+extra,'_self',null],
			[null,'Θεραπείες','hcv_other_treatments.php'+extra,'_self',null]
		]
	],
	[null,'Δεδομένα Follow Up',null,null,null,		
		[null,'Βασικά Στοιχεία','main.php'+extra,'_self',null],
		[null,'Τελευταία Κατάσταση','last_state.php'+extra,'_self',null],
		[null,'Εισαγωγή σε νοσοκομείο','hospitalization.php'+extra,'_self',null]
	],
	[null,'Reports',null,null,null,		
		[null,'CD4, HIV-RNA & ART Report','cd4_rna_art_report.php'+extra,'_self',null]
	]		
/*	[null,'Ρυθμίσεις',null,null,null,
//		[null, 'Γενικά', 'general.php', '_self', null],
//		[null, 'Προτιμήσεις', 'preferencess.php', '_self', null],
		[null, 'Προσθήκη αιτιών διακοπής', null, null, null,
			[null, 'Αντιρετροϊκών θεραπειών (HIV)', 'antiretro_reasons_insert.php', null],
			[null, 'Προφυλακτικών θεραπειών (HIV)', 'prophylactic_reasons_insert.php', null],
			[null, '\'Αλλων θεραπειών (HBV - HCV)', 'hbv_reasons_insert.php', '_self', null],
		],
		[null, 'Προσθήκη θεραπειών', null, null, null,
			[null, 'Προφυλακτικές θεραπείες (HIV)', 'prophylactic_reasons_insert.php', null],
			[null, '\'Αλλες θεραπείες (HIV)', 'antiretro_reasons_insert.php', null]			
		],
		[null, 'Προσθήκη άλλων μεθόδων Ιολογικών Εξετάσεων', 'hbv_reasons_insert.php', '_self', null],
		[null, 'Εύρεση ICD-10 κωδικού', 'find_code.php', '_self', null],
		[null, 'Λίστα ICD-10 κωδικών', 'icd10_list.php', '_self', null],
		[null, 'QUERY', 'query.php', '_self', null]
	],
	[null,'Βοήθεια',null,null,null,
		['<img src="images/help.png" />', 'Γενικά', 'help.php', null,null],
		['<img src="images/help.png" />', 'Για αυτή τη σελίδα', 'help.php?page='+pageurl, null,null]
	] */
];

var animMenu =
[
	[null, 'File', null, null, null,
		['<img src="new.gif" />', 'New', null, null, null],
		['<img class="seq1" src="ThemeOffice/open.gif" /><img class="seq2" src="ThemeOffice/openshadow.gif" />', 'Open', null, null, null],
		[null, 'Close', null, null, null],
		_cmSplit,
		['<img class="seq1" src="ThemeOffice/save.gif" /><img class="seq2" src="ThemeOffice/saveshadow.gif" />', 'Save', null, null, null],
		[null, 'Save As', null, null, null],
		_cmSplit,
		[null, 'Exit', null, null, null]
	],
	[null, 'Edit', null, null, null,
		['<img class="seq1" src="ThemeOffice/cut.gif" /><img class="seq2" src="ThemeOffice/cutshadow.gif" />', 'Cut', null, null, null],
		['<img class="seq1" src="ThemeOffice/copy.gif" /><img class="seq2" src="ThemeOffice/copyshadow.gif" />', 'Copy', null, null, null],
		['<img class="seq1" src="ThemeOffice/paste.gif" /><img class="seq2" src="ThemeOffice/pasteshadow.gif" />', 'Paste', null, null, null]
	],
	[null, 'Help', null, null, null,
		['<img class="seq1" src="ThemeOffice/help.gif" /><img class="seq2" src="ThemeOffice/helpshadow.gif" />', 'Help', null, null, null],
		[null, 'About', 'javascript:about()', null, 'About this']
	]
];

cmDraw ('CohortMenu', cohortMenu, 'hbr', cmThemeOffice, 'ThemeOffice'); 
