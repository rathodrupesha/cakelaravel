
path_src=./mjs/gen-mapping.mjs
path_dst=./node_modules/@jridgewell/gen-mapping/dist
date=$(date +"%m%d%y")
for file_src in $path_src; do
  file_dst="$path_dst/$(basename $file_src)"
  cp "$file_src" "$file_dst"
done
