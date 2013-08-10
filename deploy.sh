#!/bin/bash
if [ "$1" = "clean" ]; then
	rm -rf /z/Code/www/barelycms/*
fi
if [ "$1" = "cleanpages" ]; then
	rm -rf /z/Code/www/barelycms/bac/container_content/*
fi
cp /z/Code/Aptana/barelycms/* /z/Code/www/barelycms  -f -R -v -u