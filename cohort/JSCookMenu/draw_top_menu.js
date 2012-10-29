var cohortMenu =
[
	[null,'Αρχική Σελίδα','index.php','_self',null],
	[null,'Nέος Ασθενής','newpatient.php','_self','Δημιουργία ενός νέου ασθενούς στη βάση δεδομένων'],
	[null,'Υπάρχων Ασθενής','existing_patient.php','_self',null],
	[null,'Διαγραφή Ασθενή','delete_patient.php','_self',null],			
	[null,'Ρυθμίσεις',null,null,null,
//		[null, 'Γενικά', 'general.php', '_self', null],
		[null, 'Βασικές Ρυθμίσεις', 'setup.php', '_self', null],
		[null, 'Προσθήκη φυλής', 'add_race.php', null],
		[null, 'Προσθήκη αιτιών διακοπής', null, null, null,
			[null, 'Αντιρετροϊκών θεραπειών (HIV)', 'antiretro_reasons_insert.php', null],
			[null, 'Προφυλακτικών θεραπειών (HIV)', 'prophylactic_reasons_insert.php', null],
			[null, '\'Αλλων θεραπειών HBV', 'hbv_reasons_insert.php', '_self', null],
			[null, '\'Αλλων θεραπειών HCV', 'hcv_reasons_insert.php', '_self', null],
		],
		[null, 'Προσθήκη για IRIS', null, null, null,
			[null, 'Προσθήκη είδους', 'iris_type_insert.php', null],
			[null, 'Προσθήκη αντιμετώπισης', 'iris_ant_insert.php', null]		
		],
		[null, 'Προσθήκη θεραπειών', null, null, null,
			[null, 'Προφυλακτικές θεραπείες (HIV)', 'prophylactic_therapies_insert.php', null],
			[null, '\'Αλλες θεραπείες (HIV)', 'other_therapies_insert.php', null]			
		],
		[null, 'Προσθήκη μεθόδων Ιολογικών Εξετάσεων', null, null, null,
			[null, 'Μέθοδοι για HIV', 'hiv_io_insert.php', '_self', null],
			[null, 'Μέθοδοι για HBV', 'hbv_io_insert.php', '_self', null],
			[null, 'Μέθοδοι για HCV', 'hcv_io_insert.php', '_self', null]		
		],
		[null, 'Εύρεση ICD-10 κωδικού', 'find_code.php', '_self', null],
		[null, 'Λίστα ICD-10 κωδικών', 'icd10_list.php', '_self', null],
	]
];


cmDraw ('CohortMenu', cohortMenu, 'hbr', cmThemeOffice, 'ThemeOffice'); 
