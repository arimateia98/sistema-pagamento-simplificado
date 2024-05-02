# Projeto Laravel

Este é um projeto Laravel para transfêrencias entre usuários, comuns e lojsitas.

## Pré-requisitos

Certifique-se de ter os seguintes requisitos instalados em sua máquina:

- PHP 8.2
- Composer (gerenciador de dependências para PHP)

## Instalação do Projeto

1. Faça o clone do projeto
    ```
   git clone https://github.com/arimateia98/sistema-pagamento-simplificado.git
    ```
2. Execute o seguinte comando para instalar as dependências do projeto via Composer:

    ```
    composer install
    ```


## Configuração do Ambiente

3. Copie o arquivo `.env.example` e renomeie-o para `.env`. 
4. Este arquivo contém variáveis de ambiente para configuração, como conexões de banco de dados.
5. Execute as migrations
   ```
   php artisan migrate
   ```
7. Gere uma chave de aplicativo executando o seguinte comando:

    ```
    php artisan key:generate
    ```

## Execução do Servidor 

Para iniciar o servidor  localmente, execute o seguinte comando:

    php artisan serve

Para executar os testes unitários basta executar o comando:

    php artisan test
    
Para verificar o nível de cobertura dos testes basta abrir os arquivos
dashboard.html e index.html que se encontram dentro da pasta coverage

Para acessar a documentação da API, basta ir para a rota

    http://localhost:8000/api/documentation



