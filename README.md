## Instalar projeto

1 - Baixe/clone o repositório
2 - Instale as dependências 
    composer install
3 - Altere o arquivo .env.example para .env
4 - Altere o conteudo do arquivo .env com os dados do banco de dados
5 - Execute as migrations na linha de comando
    php artisan migrate
6 - Inicie a aplicação
    php artisan serve

### Testes

1 - Para executar os testes automatizados, execute o comando:
    php artisan test

