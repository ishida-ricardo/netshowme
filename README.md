## Instalar projeto

1 - Baixe/clone o repositório </br>
2 - Instale as dependências php: composer install </br>
3 - Instale as dependências nodejs: npm install </br>
4 - Altere o arquivo .env.example para .env </br>
5 - Altere o conteudo do arquivo .env com as configurações de banco de dados e email </br>
6 - Execute as migrations na linha de comando: php artisan migrate </br>
7 - Gere uma key: php artisan key:generate
8 - Build os arquivos front-end: npm run dev </br>
9 - Inicie a aplicação: php artisan serve </br>
10 - Acesse http://localhost:8000

### Testes

1 - Para executar os testes automatizados: <br />
1.1 - Execute os passos de instalação do projeto </br>
1.2 - Execute o comando: php artisan test </br>

