var cohortMenu =
[
	[null,'������ ������','index.php','_self',null],
	[null,'N��� �������','newpatient.php','_self','���������� ���� ���� �������� ��� ���� ���������'],
	[null,'������� �������','existing_patient.php','_self',null],
	[null,'�������� ������','delete_patient.php','_self',null],			
	[null,'���������',null,null,null,
//		[null, '������', 'general.php', '_self', null],
		[null, '������� ���������', 'setup.php', '_self', null],
		[null, '�������� �����', 'add_race.php', null],
		[null, '�������� ������ ��������', null, null, null,
			[null, '������������� ��������� (HIV)', 'antiretro_reasons_insert.php', null],
			[null, '������������� ��������� (HIV)', 'prophylactic_reasons_insert.php', null],
			[null, '\'����� ��������� HBV', 'hbv_reasons_insert.php', '_self', null],
			[null, '\'����� ��������� HCV', 'hcv_reasons_insert.php', '_self', null],
		],
		[null, '�������� ��� IRIS', null, null, null,
			[null, '�������� ������', 'iris_type_insert.php', null],
			[null, '�������� �������������', 'iris_ant_insert.php', null]		
		],
		[null, '�������� ���������', null, null, null,
			[null, '������������� ��������� (HIV)', 'prophylactic_therapies_insert.php', null],
			[null, '\'����� ��������� (HIV)', 'other_therapies_insert.php', null]			
		],
		[null, '�������� ������� ��������� ���������', null, null, null,
			[null, '������� ��� HIV', 'hiv_io_insert.php', '_self', null],
			[null, '������� ��� HBV', 'hbv_io_insert.php', '_self', null],
			[null, '������� ��� HCV', 'hcv_io_insert.php', '_self', null]		
		],
		[null, '������ ICD-10 �������', 'find_code.php', '_self', null],
		[null, '����� ICD-10 �������', 'icd10_list.php', '_self', null],
	]
];


cmDraw ('CohortMenu', cohortMenu, 'hbr', cmThemeOffice, 'ThemeOffice'); 
