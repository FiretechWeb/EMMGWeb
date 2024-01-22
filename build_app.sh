#!/bin/bash
# Remove files in .out/ directory
find out/ -type f -delete

# Remove directories in .out/ directory (excluding those starting with a dot and .git)
find out/ -mindepth 1 -type d ! -name '.*' ! -name '.git' -exec rm -rf {} \;

echo "cleaned out folder."
cd frontend
npm run build
npm run export
cd ..
mv ./frontend/out/* ./out
cp -r ./backend/src ./out/backend
echo "site built and exported."