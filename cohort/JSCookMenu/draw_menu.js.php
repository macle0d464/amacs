<? session_start(); ?>
var pageurl = window.location.href;
pageurl = pageurl.substr(24, pageurl.length);
pageurl = pageurl.substr(0, pageurl.indexOf(".php"));
var extra = "?code=" + "<? echo $_SESSION['PatientCode'] ?>";

var cohortMenu =
[
	[null,'���������','index.php',null,null
	],
	[null,'����������� ��������','demographic.php'+extra,'_self',null
	],	
	[null,'������� HIV',null,null,null,		
		[null,'������ �����','clinical_status.php'+extra,'_self',null],
		[null,'������� ���������','atomic.php'+extra,'_self',null],
		[null,'IRIS','iris.php'+extra,'_self',null],
		[null,'�������� ��� ������','hiv_resistance.php'+extra,'_self',null],
		_cmSplit,
		[null,'���������',null,null,null,
			[null,'�������������','/cohort/aimatologikes.php'+extra,null,null],
			[null,'������������','/cohort/anosologikes.php'+extra,null,null],
			[null,'����������','/cohort/bioximikes.php'+extra,'_self',null],
			[null,'���������','/cohort/iologikes.php'+extra,'_self',null],
			[null,'����������','/cohort/orologikes.php'+extra,'_self',null],
			[null,'������ �����','/cohort/ourwn.php'+extra,'_self',null],
			[null,'������ ������������','/cohort/other_exams.php'+extra,'_self',null],			
		],
		_cmSplit,
		[null,'���������',null,null,null,
			[null,'�������������','/cohort/antiretro.php'+extra,null,null],
			[null,'�������������','/cohort/prophylactic.php'+extra,'_self',null],
			[null,'\'A����','/cohort/alles.php'+extra,'_self',null]
		]		
	],
	[null,'������������ HBV & HCV',null,null,null,
		[null,'���������� �����������','coinfection.php'+extra,'_self',null],
		_cmSplit,
		[null,'������������ HBV',null,null,null,
			[null,'������� ���������','hbv_clinical_status.php'+extra,'_self',null],
			[null,'�������� �������������','hbv_iolog_observe.php'+extra,'_self',null],
			[null,'��������� \'������','hbv_istology.php'+extra,'_self',null],
			[null,'���������','hbv_other_treatments.php'+extra,'_self',null]
		],
		[null,'������������ HCV',null,null,null,
			[null,'������� ���������','hcv_clinical_status.php'+extra,'_self',null],
			[null,'�������� �������������','hcv_iolog_observe.php'+extra,'_self',null],
			[null,'��������� \'������','hcv_istology.php'+extra,'_self',null],
			[null,'���������','hcv_other_treatments.php'+extra,'_self',null]
		]
	],
	[null,'�������� Follow Up',null,null,null,		
		[null,'������ ��������','main.php'+extra,'_self',null],
		[null,'��������� ���������','last_state.php'+extra,'_self',null],
		[null,'�������� �� ����������','hospitalization.php'+extra,'_self',null]
	],
	[null,'Reports',null,null,null,		
		[null,'CD4, HIV-RNA & ART Report','cd4_rna_art_report.php'+extra,'_self',null]
	]		
/*	[null,'���������',null,null,null,
//		[null, '������', 'general.php', '_self', null],
//		[null, '�����������', 'preferencess.php', '_self', null],
		[null, '�������� ������ ��������', null, null, null,
			[null, '������������� ��������� (HIV)', 'antiretro_reasons_insert.php', null],
			[null, '������������� ��������� (HIV)', 'prophylactic_reasons_insert.php', null],
			[null, '\'����� ��������� (HBV - HCV)', 'hbv_reasons_insert.php', '_self', null],
		],
		[null, '�������� ���������', null, null, null,
			[null, '������������� ��������� (HIV)', 'prophylactic_reasons_insert.php', null],
			[null, '\'����� ��������� (HIV)', 'antiretro_reasons_insert.php', null]			
		],
		[null, '�������� ����� ������� ��������� ���������', 'hbv_reasons_insert.php', '_self', null],
		[null, '������ ICD-10 �������', 'find_code.php', '_self', null],
		[null, '����� ICD-10 �������', 'icd10_list.php', '_self', null],
		[null, 'QUERY', 'query.php', '_self', null]
	],
	[null,'�������',null,null,null,
		['<img src="images/help.png" />', '������', 'help.php', null,null],
		['<img src="images/help.png" />', '��� ���� �� ������', 'help.php?page='+pageurl, null,null]
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
