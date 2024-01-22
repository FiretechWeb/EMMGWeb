#!/bin/bash
rm -f uwamp/bin/apache/conf/httpd.conf
cp uwamp/bin/apache/conf/httpd_dev.conf uwamp/bin/apache/conf/httpd.conf
attrib +r uwamp/bin/apache/conf/httpd.conf
uwamp/UwAmp.exe &
cd frontend
npm run dev