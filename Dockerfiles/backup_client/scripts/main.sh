#!/bin/bash

# Clear files BEFORE and AFTER
# shellcheck disable=SC2115
rm -rf "${HOLDERFOLDER}/*"

V=''
if [ -n "${VERBOSE}" ]
then
  V='-v'
fi

# Sets up a default name, to avoid issues
STRINGOUTPUT=${PREFIX}$(date +%d-%m-%Y__%H-%M)

# Creates a copy of the folder
rsync -a ${V} "${ORIGINFOLDER}"/ "${HOLDERFOLDER}/${STRINGOUTPUT}"

# Checks if the variable $SFTPHOST is configure, to decide if upload in a remote server or do the back-up locally
if [ -z "$SFTPHOST" ] && [ -n "$DESTINATIONFOLDER" ]
then
      tar ${V} -czfp  "${DESTINATIONFOLDER}/${STRINGOUTPUT}.tar.gz" "${HOLDERFOLDER}/${STRINGOUTPUT}"
# Checks if all the variables required to do the backup are set up
elif [ -n "$DESTINATIONFOLDER" ] && [ -n "$SFTPPORT" ] && [ -n "$SFTPUSER" ] && [ -n "$SFTPHOST" ] && [ -n "$SFTPDIR" ]
then
      tar ${V} -czfp "${DESTINATIONFOLDER}/${STRINGOUTPUT}.tar.gz" "${HOLDERFOLDER}/${STRINGOUTPUT}"
      sftp ${V} -P "${SFTPPORT}" -o StrictHostKeyChecking=no "${SFTPUSER}@${SFTPHOST}:${SFTPDIR}" <<< "put ${DESTINATIONFOLDER}/${STRINGOUTPUT}.tar.gz"
else
# In case of not doing anything shows this message
  printf "Not enough variables set up, skipping...\n"
fi

# Finally clears the temporal files
# shellcheck disable=SC2115
rm -rf "${HOLDERFOLDER}/*"