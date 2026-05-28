#!/bin/bash
echo "DB NAME:$1";
echo "OWNER NAME:$2";
if [ -n $1 -a -n $2 -a -n $3 ] ; then
PGUSER='postgres';export PGUSER;
PGPASSWORD=$3;export PGPASSWORD;
for \
  tbl in `psql -qAt -c "select tablename from pg_tables where schemaname = 'public';" $1` ;
  do psql -c "alter table $tbl owner to \"$2\"" $1 ;
done

for \
  tbl in `psql -qAt -c "select sequence_name from information_schema.sequences where sequence_schema = 'public';" $1` ;
  do psql -c "alter table $tbl owner to \"$2\"" $1 ;
done

for \
  tbl in `psql -qAt -c "select table_name from information_schema.views where table_schema = 'public';" $1` ;
  do psql -c "alter table $tbl owner to \"$2\"" $1 ;
done
fi
