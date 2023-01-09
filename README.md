# docker-adminer
Adminer - lightweight container with Nginx 1.20 &amp; PHP 8.0 based on Alpine Linux

# Adminer
- [adminer.org](https://www.adminer.org)
- version 4.8.1 english version [link](https://github.com/vrana/adminer/releases)

## Support
- [x] MySQL / MariaDB
- [x] PostgreSQL
- [ ] MongoDB
- [ ] Oracle

## Build-in plugins
- Beautiful theme (default orage theme)
- Display foreign key name (work good with mysql)
- Database hide
- Suggest table fields
- Table filter
- Tinymce

## Pre-requisite
- Docker

## Installation
```
git clone https://github.com/huakwan/docker-adminer.git
cd docker-adminer
docker-compose up -d
```

## Re-create if the code changed
```
docker-compose build
docker-compose up -d
```

## Set container join database network
```
docker network connect database [CONTAINER]
```

## Run
http://localhost:9080/index.php

## Login
<img width="285" alt="login_screen_shot" src="https://user-images.githubusercontent.com/10665780/154832094-8f91aa44-fb19-41bf-a787-e299f1642f74.png">
