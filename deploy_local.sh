#!/bin/bash
# Remove files and directories inside ../emmg-deploy/ directory (excluding .git)
find ../emmg-deploy/ -mindepth 1 ! -path '../emmg-deploy/.git*' -delete

echo "cleaned emmg-deploy folder."

sh build_backend.sh
rm -f uwamp/bin/apache/conf/httpd.conf
cp uwamp/bin/apache/conf/httpd_build.conf uwamp/bin/apache/conf/httpd.conf
attrib +r uwamp/bin/apache/conf/httpd.conf
uwamp/UwAmp.exe &

sleep 10

sh build_front.sh
echo "APP deployed at http://localhost"