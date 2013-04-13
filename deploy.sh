#!/bin/bash
if [ "$1" = "clean" ]; then
	rm -rf /z/Code/www/barelycms/*
fi
cp /z/Code/Aptana/barelycms/* /z/Code/www/barelycms/  -f -R -v -u
