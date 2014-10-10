#! /bin/bash

#
#$RIT - root in tar  - name root directory in the tar.gz arj
#$ROOT_DIR - path to workdir

#localhost
#RIT=www #localhost
#ROOT_DIR=/opt/lampp/htdocs/mrcs.loc #localhost
#PHP=/opt/lampp/bin/php
#product
ROOT_DIR=/var/www/redcafestore/data/www
RIT=my.redcafestore.com
PHP=/usr/bin/php

WORK_DIR=$ROOT_DIR
DATE='2014-03-07' #debug {M_DATE}
TARGETFILE='userfiles/u539/u539f1451.dss' #debug {M_FILE}

#echo `pwd` >  $ROOT_DIR/$RIT/cron/ox/replace_out.msg
#exit

r=`/var/www/redcafestore/data/www/my.redcafestore.com/cron/checktar.php $DATE $TARGETFILE`
echo $r


if [ $r = '1' ]
then
	echo 'ScriptError: Не найден архив на данную дату ('$DATE')' > $ROOT_DIR/$RIT/cron/ox/replace_out.msg
	exit
fi
if [ $r = '2' ]
then
	echo 'ScriptError: Не найден искомый файл ('$TARGETFILE') в архиве за ('$DATE')' > $ROOT_DIR/$RIT/cron/ox/replace_out.msg
	exit
fi


cd $WORK_DIR/$RIT/cron/testextract
echo 'pwd = '`pwd`
#исхожу из того, что если файл был вчера, то он расположен в архиве точь в точь по тому же пути. Если это не так, то надо либо править систему, либо разбираться с конкретной ситуацией
#(Например, у пользователя сломался файл, он его с досады удалил, потом создал с таким же имененм в той же папке - в этом случае восстановилка не справится - так как не известен номер старого файла в системе)
#{M_CLEAR}
#echo 'tar -v -zxf' $r $TARGETFILE
#tar -v -zxf $r &> $ROOT_DIR/$RIT/cron/ox/replace_out.msg
cp --no-preserve=mode,ownership -f -v $ROOT_DIR/$RIT/cron/testextract/$TARGETFILE $ROOT_DIR/$RIT/$TARGETFILE &> $ROOT_DIR/$RIT/cron/ox/replace_move.msg
