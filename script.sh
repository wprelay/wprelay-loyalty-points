pack_type=${1:-pro}

# Print the value of custom argument
echo "Pack Type: $pack_type"

echo "RelayWP Loyalty Points"
current_dir="$PWD"

copy_folder() {
  echo "copying folder"
  cd $current_dir/..

  pack_folder=$PWD"/compressed_pack"

  folder_name="wprelay-loyalty-points"

  compress_plugin_folder=$pack_folder"/$folder_name"
  if [ -d "$pack_folder" ]; then
    rm -r "$pack_folder"
  fi
  mkdir "$pack_folder"

  mkdir "$compress_plugin_folder"

  # shellcheck disable=SC2054

  move_dir=("app" "src" "resources" "vendor" "wprelay-loyalty-points.php")

  # Ensure the destination directory exists
  mkdir -p "$compress_plugin_folder"

  # Loop through the directories and files
  for dir in "${move_dir[@]}"; do
    src="$current_dir/$dir"
    dest="$compress_plugin_folder"
    
    # Check if the source is a directory and copy recursively
    if [ -d "$src" ]; then
      mkdir -p "$dest"
      cp -r "$src" "$dest"
    else
      # If it's a file, copy without the -r option
      cp "$src" "$dest"
    fi
  done

  cd "$current_dir"
}

zip_folder() {
  cd "$current_dir"
  cd ..
  pack_compress_folder=$PWD"/compressed_pack"
  mkdir -p $pack_compress_folder
  cd "$pack_compress_folder"

  zip_name="wprelay-loyalty-points"

  zip -r "$zip_name".zip $zip_name -x "*/.*" -q 2> zip_error.log
  echo "Zip Created"
}

echo "Copy Folder:"
copy_folder
echo
echo
echo
echo "Zip Folder:"
zip_folder
