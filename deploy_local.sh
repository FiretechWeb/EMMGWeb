#!/bin/bash
sh build_app.sh
rm -f uwamp/bin/apache/conf/httpd.conf
cp uwamp/bin/apache/conf/httpd_build.conf uwamp/bin/apache/conf/httpd.conf
attrib +r uwamp/bin/apache/conf/httpd.conf
uwamp/UwAmp.exe &
echo "APP deployed at http://localhost"