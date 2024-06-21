<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

# Iniciando Projeto Laravel Existente

Este repositório contém instruções sobre como configurar e executar esse projeto Laravel existente em sua máquina.

## Configuração do Ambiente

Siga os passos abaixo para configurar o ambiente e iniciar o projeto em sua máquina local.

### Pré-requisitos

Certifique-se de ter as seguintes ferramentas instaladas em sua máquina:

- [Laravel](https://laravel.com/docs/installation)
- [Composer](https://getcomposer.org/download/)
- [Node.js](https://nodejs.org/) e [npm](https://www.npmjs.com/)
- Banco de Dados (por exemplo, MySQL, PostgreSQL)

### Passos de Instalação

1. **Instalar as dependências do Composer:**

   ```bash
   composer install

2. **Instalar as dependências do Node.js:**

   ```bash
   npm install

3. **Configurar o arquivo `.env:`**
    - Faça uma cópia do arquivo `.env.example` e renomeie-o para `.env`.
      
       - Windows
           ```bash
           copy .env.example .env
           ```
           
        - linux / mac
           ```bash
           cp .env.example .env
           ```
   
    - Abra o arquivo `.env` e configure as variáveis de ambiente, como as configurações do banco de dados e outras informações relevantes. **Exemplo:**
      
        ```bash
          DB_CONNECTION=mysql
          DB_HOST=localhost
          DB_PORT=3306
          DB_DATABASE=meudatabase
          DB_USERNAME=root
          DB_PASSWORD=root
        ```
        - Após alterar algo no arquivo `.env` certifique-se re rodar:
          
          ```bash
              php artisan optimize:clear
          ```
          
4. **Gerar a chave de aplicativo:**
   ```bash
   php artisan key:generate

5. **Executar as migrações e seeds do banco de dados:**
   ```bash
    php artisan migrate --seed

6. **Iniciar o servidor de desenvolvimento:**
   ```bash
   php artisan serve

7. **se tiver o npm instalado rode também:**
    ```bash
   npm run build

8. **Acessar o projeto no navegador:**
   Abra seu navegador e vá para  <a href="http://localhost:8000">http://localhost:8000</a>

      
