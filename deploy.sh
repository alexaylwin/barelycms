#!/bin/bash
if [ "$1" = "clean" ]; then
	rm -rf /C/wamp/www/barelyacms*
fi
cp /c/Users/A/Documents/GitHub/barelycms/* /c/wamp/www/barelyacms  -f -R -v -u
