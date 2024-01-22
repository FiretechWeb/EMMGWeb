#!/bin/bash
sh build_app.sh
rm -f ../emmg-deploy/backend/config/def.php
cp  ./remote/def.php ../emmg-deploy/backend/config/def.php
echo "APP deployed for remote. You must push now."