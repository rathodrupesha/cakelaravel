#! /bin/bash
 
TIMESTAMP=$(date +"%F")
BACKUP_DIR="/home/tops/Documents/$TIMESTAMP"
MYSQL_USER="maitrak"
MYSQL=/usr/bin/mysql
MYSQL_PASSWORD="123"
MYSQLDUMP=/usr/bin/mysqldump
 
mkdir -p "$BACKUP_DIR/mysql"
 
databases=`$MYSQL --user=$MYSQL_USER -p$MYSQL_PASSWORD -e "SHOW DATABASES;" | grep -Ev "(Database|information_schema|performance_schema)"`
 
for db in $databases; do
  $MYSQLDUMP --force --opt --user=$MYSQL_USER -p$MYSQL_PASSWORD --databases $db | gzip > "$BACKUP_DIR/mysql/$db.gz"
done

#backup of All databse
#put via ftp on server for live
# connect by ssh 
#run crontab -e
# set cron like time /path
#change the bacup directory in above code as well as root user not permitted so 
#make new user from php myadmin

#https://mensfeld.pl/2013/04/backup-mysql-dump-all-your-mysql-databases-in-separate-files/