#!/usr/bin/env bash

# Abort if a command fails!
set -e

TEMP_DIR=/tmp/

if [ ! -n "$HOST" ];then
    echo "missing option \"HOST\", aborting"
    exit 1
fi
if [ ! -n "$USER" ];then
    echo  "missing option \"HOST\", aborting"
    exit 1
fi
if [ ! -n "$PASSWORD" ];then
    echo  "missing option \"HOST\", aborting"
    exit 1
fi
if [ ! -n "$IGNORE" ];then
    IGNORE=''
fi

# Create temporary director
WORKING_DIR="$TEMP_DIR/workspace"

# TODO: fail if exists..
mkdir -p $WORKING_DIR
export COMPOSER_HOME="$WORKING_DIR"

# Clone the repo & checkout branch
echo "Creating archive..."
git archive master --format=tar --output=$TEMP_DIR/export.tar
tar -xf $TEMP_DIR/export.tar -C $WORKING_DIR

# Change directory into the working dir
cd "$WORKING_DIR"

# install the dependencies
echo "Install dependencies..."
composer install --no-dev --optimize-autoloader

# Prepare ignore parameters
IFS=';' read -a igor <<< "$IGNORE"
params=''
for element in "${igor[@]}"
do
    params=$(echo "$params --exclude $element")
done

# TODO: allow SFTP
# TODO: allow verify cert
echo "Uploading..."
lftp -e "
open $HOST
set ssl:verify-certificate no
set ftp:ssl-allow off
set cmd:fail-exit true
user $USER $PASSWORD
cd $DIRECTORY
mirror --reverse $params --delete --ignore-time --verbose --parallel . .
bye
"

# Complete!
echo "Done!"
exit 0
