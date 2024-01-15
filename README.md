# PHP Laravel Template

---

---
## Sobre o projeto:

PHP Laravel Template

1. Primeiro passa é buildar o ambiente e subir os containers
```
docker composer up -d --build
```

2. Após, acessar o container da aplicação PHP via bash
```
docker exec -it api.php.dev sh
```

3. Acessar a pasta raiz da aplicação
```
cd /app
```

4. E por fim, realizar a instalação do framework Laravel
```
composer create-project laravel/laravel .
```
