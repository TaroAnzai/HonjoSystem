#!/bin/sh
# Start/stop/restart PostgreSQL.

# Start pgsqld:
start() {
  if [ -x /usr/local/pgsql/bin/pg_ctl ]; then
    su - postgres -c "/usr/local/pgsql/bin/pg_ctl start -D /home/staff/postgres/data -s 2>&1 | /usr/local/sbin/cronolog -S ~postgres/data/pg_log/pgsql ~postgres/data/pg_logs/%Y/%m/pgsql_%d.log&" ;

  fi
}

# Stop pgsqld:
stop() {
  su - postgres -c "/usr/local/pgsql/bin/pg_ctl stop -m fast -D /home/staff/postgres/data -s" ;
}

# Restart pgsqld:
restart() {
    su - postgres -c "/usr/local/pgsql/bin/pg_ctl restart -D /home/staff/postgres/data -s 2>&1 | /usr/local/sbin/cronolog -S ~postgres/data/pg_log/pgsql ~postgres/data/pg_logs/%Y/%m/pgsql_%d.log&" ;
}

case "$1" in
'start')
  start
  ;;
'stop')
  stop
  ;;
'restart')
  restart
  ;;
*)
  echo "usage $0 start|stop|restart"
esac

