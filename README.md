# kocom

KOREATECH COMPUTER COMMUNITY

## 세팅하기

### Clone 및 Docker 설정

docker 및 docker-compose가 설치된 환경에서 아래 명령을 실행합니다.

```
git clone https://github.com/refracta/kocom -b develop tmp && \
docker run --rm \
    -v "$(pwd)":/opt \
    -w /opt \
    laravelsail/php81-composer:latest \
    bash -c "laravel new kocom && cd kocom && php ./artisan sail:install --with=mysql" && \
cp -rf tmp/* kocom/ && find ./tmp -name '.*' -exec cp -r "{}" ./kocom  \; && rm -rf tmp && \
cd kocom && ./vendor/bin/sail up
```

### laravel 기본 설정

```
docker ps
```

위 명령어로 `sail-8.1/app`의 CONTAINER ID를 확인합니다.

```
docker exec -it {CONTAINER_ID} /bin/bash
php artisan storage:link
# laravel에서 사용하는 storage 초기화
exit
```

storage를 초기화합니다.

### DB 초기화

1. http://localhost:8989 PHPMyAdmin에 ID:root/PW:password로 진입 (docker-compose.yml에 설정된 기본 PHPMyAdmin 포트)

2. kocom.sql 가져오기로 테이블 초기화 (프로젝트 루트 폴더 참조)

3. http://localhost 로 사이트 확인

### 사이트 로그인

```
ID: refracta@koreatech.ac.kr, PW: password (관리자 계정)
ID: user1@koreatech.ac.kr, PW: password
ID: user2@koreatech.ac.kr, PW: password
ID: user3@koreatech.ac.kr, PW: password
ID: user4@koreatech.ac.kr, PW: password
```

위의 계정을 이용하여 로그인이 가능합니다.
