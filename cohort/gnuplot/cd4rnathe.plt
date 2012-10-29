set terminal png nocrop enhanced truecolor font arial 12 size 1000,750 
	set output 'cd4rnathe.png'
	set style line 1 lt 1 lc rgbcolor '#273F6F' lw 1 pt 4 ps 1
	set style line 2 lt 1 lc rgbcolor '#B5444C' lw 1 pt 12 ps 1.2
	set title 'Patient '
	set key outside below
	set xdata time
	set timefmt '%Y-%m-%d'
	set format x '%Y'
	set x2tics mirror
	set x2data time
	set format x2 '%Y'
	set yrange [ -30 : 120 ]
	set y2tics 0, 0.5
	set ytics nomirror
	set y2range [ -0.15 : 1.8 ]
	unset autoscale y2
	set xlabel 'Years'
	set ylabel 'CD4 Count  (cells/{/Symbol m}l)'
	set y2label 'HIV-RNA  [log_{10}(copies/ml)]'
plot 'CD4.dat' using 1:2 axes x1y1 with linespoints linestyle 1 title 'CD4 Count', 'RNA.dat' using 1:2 axes x1y2 with linespoints linestyle 2 title 'HIV-RNA'