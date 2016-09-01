#!/bin/bash
for (( i = 1; i <= $1; i++  )); do wget --load-cookies cookies.txt -U 'Mozilla/5.0 (X11; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0' "http://dangeru.rf.gd/thread/$i.txt"; done
