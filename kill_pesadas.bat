@echo off
:: Variables
set db_user=sistemas
set db_password=adn
set db_host=nube9.x5servers.cloud
set db_port=3335
set db_name=adn

:: Comando para ejecutar el procedimiento almacenado
mysql -u %db_user% -p%db_password% -h %db_host% -P %db_port% %db_name% -e "CALL KILL_METADATALOCK();"

