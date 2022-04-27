#!/bin/bash

readonly EXTRA_FILE_TEXT="[client] password=${MYSQL_ROOT_PASSWORD}"

readonly SOCKET=`
  mysqld --verbose --help \
  | grep '^socket\s' \
  | grep -o '\s\+[[:print:]]\+' \
  | tr -d '[:blank:]'
`

sql() {
  # `--defaults-extra-file` must be the first arg.
  mysql \
    --defaults-extra-file=<(printf "%s\n" $EXTRA_FILE_TEXT) \
    --comments \
    --protocol=socket \
    --socket="${SOCKET}" \
    -u root \
    -h localhost \
    "$@"
}

if [ -n $ADMIN_NAME ] && [ -n $ADMIN_PASSWORD ]
then
  echo Creating user $ADMIN_NAME
  sql --database=mysql \
    <<<"CREATE USER '$ADMIN_NAME'@'%' IDENTIFIED BY '$ADMIN_PASSWORD';"

  for DB in $DATABASES
  do
    echo Creating database $DB
    sql --database=mysql \
      <<<"CREATE DATABASE IF NOT EXISTS \`$DB\`;"

    echo Grant user $ADMIN_NAME access to $DB
    sql --database=mysql \
      <<<"GRANT ALL ON \`${DB//_/\\_}\`.* TO '$ADMIN_NAME'@'%';"
  done
fi
