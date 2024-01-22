#!/bin/bash
rm -rf ./out
cd frontend
npm run build
npm run export
cd ..
mv ./frontend/out ./out
cp -r ./backend/src ./out/backend