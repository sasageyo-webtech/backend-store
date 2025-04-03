#  Online Store System (Sasageyo) Backend

## Member

- อติราช แก้ววิเชียร 6510451051
- ภัฎฎารินธ์ ไฝ่ทอง 6510450771
- อควอรัตน์ ธิติวุฒิกร 6510451026

## Setup

1. run 
```bash
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php84-composer:latest \
        composer install --ignore-platform-reqs
```
2. run ```bash cp .env.example .env ```
3. edit .env
```bash
    DB_CONNECTION=pgsql
    DB_HOST=pgsql
    DB_PORT=5432
    DB_DATABASE=laravel
    DB_USERNAME=sail
    DB_PASSWORD=password 
```
4. run ``` sail up -d ```
5. run ``` sail artisan key:generate ```
6. run ``` sail artisan migrate ```
7. run ``` sail npm install ```
8. run ``` sail artisan storage:link```
9. เตรียมรูปภาพไว้ <br />
   - storage/app/public/products/ ใส่รูปภาพที่ต้องการมากๆเพื่อทำงาน seed
   - storage/app/public/receipts/ ใส่รูปภาพที่ต้องการมากๆเพื่อทำงาน seed
   - storage/app/public/users/default-user-profile.png เตรียมรูปชื่อนี้ไว้เพื่อ seed รูปภาพ default ของ user
10. run ``` sail artisan migrate:refresh --seed ```
11. start ``` sail up -d```

## Users 
```
# role staff account
email: admin@gmail.com
password: password

# role user staff account
email: test@gmail.com
password: password
```


## Development Server

- Start the development server on `http://localhost`:
- See database with <b>adminer<b/> on `http://localhost:8080`

## Release Tag v1.0.0
