#!/bin/bash
if [ "$1" = "clean" ]; then
	rm -rf /C/wamp/www/barelyacms*
fi
cp /z/Code/Aptana/barelycms/* /z/Code/www/barelycms  -f -R -v -u
