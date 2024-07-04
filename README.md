# Painel do Cliente - Roque

<p align="center"><img src="./resources/assets/imgs/logo.svg" width="400" alt="Roque logo"></p>

## Pré-requisitos

Antes de começar, verifique se você possui o [Docker](https://docs.docker.com/) instalado em sua máquina.


## Configuração do Ambiente com Docker

1. Clone este repositório em sua máquina usando o seguinte comando:
```bash
git clone -b main git@github.com:lucaslemo/panel-roque.git
```

2. Entre no repositório clonado:
```bash
cd panel-roque/
```

3. Crie o arquivo .env
```bash
cp .env.example .env
```

4. No diretório raiz do projeto, execute o seguinte comando para instalar as dependências:
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
``` 

5. (Opcional) Adicione o comando sail ao seu path:
```bash
echo "alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'" >> ~/.bashrc & source ~/.bashrc
```

6. Inicialize os containers:
```bash
sail up -d
```

7. Gere a chave de criptografia do Laravel:
```bash
sail php artisan key:generate
```

8. Crie um link simbólico para o armazenamento público:
```bash
sail php artisan storage:link
```

9. Instale as dependências do node.js:
```bash
sail npm install
```

10. Compile os assets na pasta public:
```bash
sail npm run build
```

11. Rode as migrations e seeds:
```bash
sail php artisan migrate --seed  
```

12. Execute servidor de desenvolvimento do vite:
```bash
sail npm run dev
```

13. Acesse a tela de login: http://localhost/login

    1. email: admin@email.com ou user@email.com
    2. senha: senha

14. Acesso o banco de dados via phpMyAdmin http://localhost:8088/
    1. DB_HOST=mysql
    2. DB_USERNAME=sail
    3. DB_PASSWORD=password
