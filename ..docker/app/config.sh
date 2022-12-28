docker-compose exec app composer install
 
docker-compose exec app php artisan key:generate
 
docker-compose exec app php artisan migrate

docker-compose exec app php artisan storage:link

#comando a rodar
#docker-compose up -d && sh ..docker/app/config.sh