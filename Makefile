
phpt_bin          = pear run-tests

empty:
	

phpt: empty
	rm -f phpt/*.out
	rm -f phpt/*.diff
	rm -f phpt/*.php
	rm -f phpt/*.exp
	rm -f phpt/*.log
	${phpt_bin} phpt