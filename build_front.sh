#!/bin/bash
cd frontend
npm run build
npm run export
cd ..
mv ./frontend/out/* ../emmg-deploy/
echo "site built and exported."