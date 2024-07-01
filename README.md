
# Laravel8 Test Workana

Este projeto é um exemplo de aplicação Laravel 8 configurado para ser executado em um ambiente Docker. Ele inclui funcionalidades de autenticação, redefinição de senha e uma interface para visualização de mensagens de erro e sucesso conforme o padrão solicitado.

## Requisitos

- Docker
- Docker Compose

## Configuração do Projeto

### 1. Clonar o Repositório

```sh
git clone https://github.com/LdSH-dev/laravel8-test-workana.git
cd laravel8-test-workana
```

### 2. Configurar Variáveis de Ambiente

Renomeie o arquivo `.env.example` para `.env` e configure suas variáveis de ambiente:

```sh
cp .env.example .env
```

Edite o arquivo `.env` conforme necessário. Certifique-se de configurar as seguintes variáveis para o SMTP ou para usar o log do Laravel:

#### Usando o log do Laravel para visualizar e-mails de redefinição de senha:

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS=seu_email@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

#### Configurando um servidor SMTP:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.seuservidor.com
MAIL_PORT=587
MAIL_USERNAME=seu-usuario
MAIL_PASSWORD=sua-senha
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="example@example.com"
MAIL_FROM_NAME="\${APP_NAME}"
```

### 3. Construir e Subir os Containers Docker

Execute os seguintes comandos para construir e iniciar os containers Docker:

```sh
docker-compose up -d --build
```

### 4. Instalar as Dependências

Entre no container da aplicação e instale as dependências do Composer:

```sh
docker-compose exec app bash
composer install
```

### 5. Gerar a Chave da Aplicação

Ainda dentro do container, gere a chave da aplicação:

```sh
php artisan key:generate
```

### 6. Migrar o Banco de Dados

Execute as migrações para configurar o banco de dados:

```sh
php artisan migrate
```

### 7. Permissões de Pasta

Certifique-se de que as permissões de pasta estão configuradas corretamente:

```sh
sudo chown -R \$USER:www-data storage
sudo chmod -R 775 storage
```

## Acessando a Aplicação

Abra o navegador e vá para `http://localhost:9000` para acessar a aplicação.

## Visualizando E-mails de Redefinição de Senha

### Usando o Log do Laravel

Se você configurou o `MAIL_MAILER` para `log`, você pode visualizar os e-mails de redefinição de senha no arquivo de log do Laravel (`storage/logs/laravel.log`).

### Usando um Servidor SMTP

Se você configurou um servidor SMTP, os e-mails serão enviados para o servidor configurado.

## Parando e Removendo os Containers

Para parar e remover os containers Docker, execute:

```sh
docker-compose down
```

### Autor

Leonardo Hemming

---

### Licença

Este projeto está licenciado sob os termos da licença MIT.

---

Este README deve fornecer todas as informações necessárias para configurar e executar o projeto em um ambiente Docker, além de visualizar ou configurar os e-mails de redefinição de senha.
