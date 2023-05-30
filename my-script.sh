name=$(date +"%Y%m%d_%H%M%S")
filename="backup_$name"
result=$(gdrive --service-account ../../credentials.json mkdir $filename)
folderId=$(echo "$result" | awk '{print $2}')
mysqldump -h mariadb -u thec_theciu -p4OM@e*Ebow-n^jEy thec_theciu > backup.sql
gdrive --service-account ../../credentials.json upload ../../backup.sql --parent $folderId --recursive
gdrive --service-account ../../credentials.json share $folderId
gdrive --service-account ../../credentials.json info $folderId
