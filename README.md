# docker-adminer
Adminer - lightweight container with Nginx 1.20 &amp; PHP 8.0 based on Alpine Linux

# Adminer
- [adminer.org](https://www.adminer.org)
- version 4.8.1 english version [link](https://github.com/vrana/adminer/releases)

## Support
- [x] MySQL
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
docker network create database
docker-compose up -d
```

## Re-create
```
docker-compose build
docker-compose up -d
```

## Run
http://localhost:9080/index.php
