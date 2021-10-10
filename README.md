# Campanha de Vacinação contra o COVID-19
O projeto desenvolvido para a Fase 2 do processo seletivo para bolsista do Laboratório de Inovação Tecnológica em Saúde (LAIS) consiste em um sistema Web que permite que o cidadão realize seu autocadastro e tenha a possibilidade de realizar o seu agendamento escolhendo local, dia e horário para a vacinação. O sistema também possui uma página de transparência em que a população em geral pode acompanhar a quantidade de agendamentos realizados. 

O sistem foi criado utilizando uma API Rest implementada em PHP utilizando o Laravel (back-end) e consumida utilizando React.JS (front-end). Além disso, para a persistência dos dados foi utilizado o PostgresSQL.

## Tecnologias e suas versões utilizadas
- PHP 7.4.16
- Laravel Framework 8.62.0
- PostgreSQL 13.2
- React.JS 17.0.2

## Diagrama de Entidade Relacionamento
<img src="https://github.com/Aleika/campanhavacinacao/blob/main/public/images/modelagem%20do%20banco.png">

## Clonando repositório do Git
Para clonar o projeto é possível utilizar dois métodos:
- HTTPS: `https://github.com/Aleika/campanhavacinacao.git`
- SSH: `git@github.com:Aleika/campanhavacinacao.git` (para usar esse método é necessário configurar as chaves SSH no git.)

## Configurando dependências do projeto
Após realizar o clone, entre na pasta do projeto e execute os comandos para que as dependências sejam instaladas:

- ```composer install```
- ```npm install``` (Instala as dependências do Node)

## Configurando variáveis de ambiente
Copiar o arquivo `.env.example` para o arquivo `.env`. Após isso, gerar a chave de aplicação com o comando `php artisan key:generate`.

## Configurando os dados para acesso ao banco de dados
No arquivo `.env`, informar as credenciais para acesso ao banco de dados:

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=vacinacao
DB_USERNAME= NOME_USUARIO
DB_PASSWORD= SENHA
```
Veja que para que funcione, é necessário que seja criado um banco com o nome 'vacinacao' e é preciso informar o nome do usuário e senha que foram criados por você durante a instalação do postgres. Caso tenha alguma dessas informações configuradas de forma diferente, basta substituir. O importante é que as informações correspondam ao servidor de banco de dados que você configurou anteriormente.

Observação: Abra o arquivo php.init e descomente as linhas:

```extension=pdo_pgsql```

```extension=pgsql```

## Realizar a migração dos dados
Para a criação das tabelas e inserção de dados via migration, execute o comando:

```php artisan migrate```

## Adicionar a chave JWT ao projeto
Para a autenticação do acesso dos usuários no sistema está sendo utilizado o JWT, logo é necessário gerar a chave JWT ao projeto

 ``` php artisan jwt:secret ```

## Executar seeders
Os seeders contém dados para serem inseridos no banco no momento em que são chamados.

```php artisan db:seed ```

### Observações:  

Os pontos de vacinação contidos no projeto foram importados a partir do link [ubs.csv](http://repositorio.dados.gov.br/saude/unidades-saude/unidade-basica-saude/ubs.csv) e inseridos via seed.

 Foram inseridos nos seeds dados para que se tenha um cenário inicial para realizar testes e verificações no sistema. Esses cenários consistem em:
 - Dados inseridos para que possam ser visualizados os gráficos na página inicial
 - Usuário administrador para que se possa ter acesso às funcionalidades restritas a ele (login: aleika.alves@lais.huol.ufrn.br, senha:123456)
 - Usuário do tipo cidadão com agendamento cadastrado (login: lglima@gmail.com, senha:123456)
 - Usuário do tipo cidadão sem agendamento cadastrado (login: larissa@gmail.com, senha:123456)


## Executar servidor localmente
Por fim, para executar o servidor localmente é necessário apenas executar os comandos:

- ``` npm run dev ``` (compila todos os arquivos do front - React.JS)
- ```php artisan serve ```

## Extra
Para testar a API utilizei o Insomnia. Caso deseje utiliza-lo também, faça o download pelo [link](https://insomnia.rest/). 
