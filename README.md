# kocom
KOREATECH COMPUTER COMMUNITY

## 세팅하기
```
git clone https://github.com/refracta/kocom -b develop tmp && \
docker run --rm \
    -v "$(pwd)":/opt \
    -w /opt \
    -e MYSQL_ROOT_HOST=% \
    laravelsail/php81-composer:latest \
    bash -c "laravel new kocom && cd kocom && php ./artisan sail:install --with=mysql" && \
cp -rf tmp/* kocom/ && rm -rf tmp && \
./vendor/bin/sail up
```

```
docker ps
# sail-8.1/app CONTAINER ID 확인
```

```
docker exec -it {CONTAINER NAME} /bin/bash
php artisan storage:link
exit
# storage 초기화
```
http://localhost:8989 PHPMyAdmin에 ID:root/PW:password로 진입
kocom.sql 가져오기로 테이블 초기화

http://localhost 로 사이트 확인
