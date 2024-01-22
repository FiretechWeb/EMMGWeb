#!/bin/bash

# Remove files and directories inside ../emmg-deploy/ directory (excluding .git)
find ../emmg-deploy/ -mindepth 1 ! -path '../emmg-deploy/.git*' -delete

echo "cleaned out folder."
cd frontend
npm run build
npm run export
cd ..
mv ./frontend/out/* ../emmg-deploy/
cp -r ./backend/src ../emmg-deploy/backend
echo "site built and exported."