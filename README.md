# Sambuh - API

## Översikt
Sambuh - API är ett back-end för att hantera den data som behövs för att dess administrationsverktyg och applikation ska fungera.

## Installation

[1] Klona ner projektet på önskad plats.
```
git clone <via SSH eller HTTP(S)>
```

[2] Installera nödvändiga paket. Nagivera till roten av projektet.

```
composer install
```

[Om composer inte finns installerat hittar du hur man gör det här](https://getcomposer.org/).

[3] Konfigurera miljön utefter Laravels riktlinjer på deras hemsida.

```
https://laravel.com/docs/5.6/installation
```

[4] Konfigurera miljövariabler genom att först kopiera `.env.example` till `.env`.

```
cp .env-example .env
```

Generera ny applikationsnyckel för att säkra krypterad data i databasen. Förutsatt att detta inte redan gjorts i `[3]`.

```
php artisan key:generate
```

Generera ny JWT-nyckel för att möjliggöra skapandet av JWT-tokens som används för authentisering.

```
php artisan jwt:generate
```

Sätt upp en databas på följande sätt (notera `COLLATE utf8mb4_swedish_ci`):

```
CREATE DATABASE mydatabase CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci;
```

Fyll i uppgifter i `.env` så att Laravel kan nå databasen och kör följande kommando för att migrera databastabeller och populera den med data.

```
php artisan migrate:refresh --path=./database/migrations/1.0.1 --seed
```

Resterande som återstår i `.env` är att sätta upp mailuppgifter-, filhanteringsuppgifter- och SAMLuppgifter.

[5]
Systemet är byggt med ett kösystem som heter `supervisor`. Om detta inte finns på den server som API:et är tänkt att köras på så måste det först installeras.

När `supervisor` finns på servern behöver en worker sättas upp ([tips för hur dessa fungerar](https://laravel.com/docs/5.7/queues#supervisor-configuration)) med följande kriterier:

```
[program:sambuh-laravel-queue-worker]
process_name=%(program_name)s_%(process_num)02d
command=/usr/bin/php /home/<användare>/public_html/artisan queue:work database --queue=push,email
autostart=true
autorestart=true
user=<användare>
numprocs=1
stderr_logfile=/var/log/supervisor/sambuh-laravel-queue-worker.err.log
stdout_logfile=/var/log/supervisor/sambuh-laravel-queue-worker.out.log
```

Sedan läser man in skriptet och startar upp det.

```
sudo supervisorctl reread

sudo supervisorctl update

sudo supervisorctl start laravel-worker:*
```

## Push-notifikationer

För att få push-notifikationer att fungera behöver certifikat skapas enligt [Apples riktlinjer](https://developer.apple.com/documentation/usernotifications/setting_up_a_remote_notification_server/establishing_a_certificate-based_connection_to_apns) och placeras i mappen `./storage/push-cert/` samt sätta upp applikationen i Firebase för att generera en API-nyckel för Android enheter.

När detta är gjort behöver uppgifterna för dessa anges i `.env`.
