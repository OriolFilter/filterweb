#!/bin/bash

mkdir /FOLDER_MASTER
mkdir /BACKUP_HOLDER
mkdir /FOLDER_SLAVE

set ftp:ssl-protect-data true
set ftps:initial-prot
set ftp:ssl-force true
set ftp:ssl-protect-data true
set ssl:verify-certificate off


echo "hi"


#echo "$PASSWORD" | sftp -P ${PORT} ${USER}@${HOST}:${REMOTE_DIR} <<< 'put ${local_file_path}'

tail -f /dev/null