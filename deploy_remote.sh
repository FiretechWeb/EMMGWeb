#!/bin/bash
sh build_app.sh
rm -f ./out/backend/config/def.php
cp  ./remote/def.php ./out/backend/config/def.php
echo "APP deployed for remote. You must push now."