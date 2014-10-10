unlink /var/www/vhosts/redcafestore.com/subdomains/my/httpsdocs/cron/sqldump/sqldump.sql
mysqldump -u Rekjhefr -plkj2h34r -h localhost redjoomlaredcafe  > /var/www/vhosts/redcafestore.com/subdomains/my/httpsdocs/cron/sqldump/sqldump.sql
DATE=`date +%F`
cd /var/www/vhosts/redcafestore.com/subdomains/my
tar -cf  /var/www/vhosts/redcafestore.com/subdomains/my/httpsdocs/cron/backups/$DATE.tar --exclude=*.gz httpsdocs
gzip  /var/www/vhosts/redcafestore.com/subdomains/my/httpsdocs/cron/backups/$DATE.tar
unlink /var/www/vhosts/redcafestore.com/subdomains/my/httpsdocs/cron/backups/$DATE.tar
/var/www/vhosts/redcafestore.com/subdomains/my/httpsdocs/cron/removeoldfiles.php
