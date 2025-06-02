# Introdução
Este projeto é um sistema de gerenciamento de livros, autores e assuntos. Ele foi desenvolvido como parte de um desafio técnico, com foco em:
-   Boas práticas de arquitetura (Service + Repository)
-   Organização em camadas   
-   Banco de dados relacional com uso de views, triggers e procedures
-   Interface via API e também Livewire (Web)
-   Filtros, relações N:N e soft deletes.
-   Testes

## Relatório Técnico do Projeto

### Arquitetura e Organização do Projeto

#### Camadas Definidas

O projeto foi estruturado em camadas para garantir manutenção e separação de responsabilidades:
-   **Controller**: recebe requisições HTTP e delega ao service
-   **Service**: contém a lógica de negócio central
-   **Repository**: responsável por interações com o banco de dados
-   **Model**: representa as entidades e seus relacionamentos
-   **FormRequest**: validação de entrada.
-   **Livewire Components**: interface no front-end

## Backlog Técnico Implementado

- Criar migrations e models (Livro, Autor, Assunto)
- Criar tabelas pivot
- Criar relacionamento Many-to-Many
- Criar camadas Service e Repository
- CRUD via API + Livewire
- Form Requests
- Soft Deletes
- View SQL para consulta.
- Testes 

## Banco de Dados

- MySQL

### Tabelas Criadas
- Livro
- Autor
- Assunto 
- Livro_Autor (pivot)
- Livro_Assunto (pivot)

### Views
- vw_livros_por_autor

## Considerações Finais
-   O projeto está preparado para escala, com código limpo, testável e reaproveitável.
-   Segue padrões modernos de arquitetura Laravel.
-   O uso de SoftDeletes adiciona robustez e segurança.
-   O banco está preparado com view para extração de relatório.
-   O projeto conta com testes automatizados.


# Execução do Projeto com Laravel Sail

#### Clonar Repositório
- git clone https://github.com/claudioxsn/desafio-livros.git
- cd desafio-crud-livros

#### Instalar as dependências do projeto
- composer update

#### Copiar e configurar o arquivo .env
- cp .env.example .env

#### Gerar chave da aplicação (app_key)
- ./vendor/bin/sail artisan key:generate

#### Executar ambiente com Laravel Sail
- ./vendor/bin/sail up -d

#### Executar migrations 
- ./vendor/bin/sail artisan migrate 

#### Executar seeders (opcional)
- ./vendor/bin/sail artisan db:seed

