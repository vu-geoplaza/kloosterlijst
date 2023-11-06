# Kloosterlijst website

Refurbished kloosterlijst website formerly found on https://www2.fgw.vu.nl/oz/kloosterlijst

To bring up a copy with docker. 
1. Rename `.env-template` to `.env` and add sensible passwords.
2. `docker-compose build` and `docker-compose up -d`.
3. Restore the database like `cat /mnt/c/tmp/kloosterlijst-dbs.sql | sudo docker-compose exec -T kloosterlijst-db /usr/bin/mysql -u kloosterlijst --password=****** kloosterlijst-dbs`.

All photos 	&copy;Koen Goudriaan.