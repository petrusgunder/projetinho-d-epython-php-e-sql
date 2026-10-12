# Projeto de Integração: Python, PHP e MySQL com Criptografia

Este projeto foi desenvolvido com foco prático de aprendizado para integrar Python, PHP e MySQL (SQL), aplicando validações de entrada e criptografia de dados no fluxo de cadastro e armazenamento.

## Para que serve o projeto?

O objetivo principal é simular o fluxo seguro de captura, validação, criptografia e persistência de dados de usuários:

1. Python recebe os dados via linha de comando, valida as entradas (nome, e-mail e idade) e armazena esses dados de forma criptografada em um arquivo JSON local.

2. PHP faz a leitura dos dados, realiza a verificação de duplicidade diretamente na base de dados MySQL e insere os novos registros no banco.

## Tecnologias e Bibliotecas Utilizadas

### 1. Python (main.py e funções.py)

Responsável pela interface CLI (linha de comando), validação das entradas e criptografia dos registros.

* re (Expressões Regulares): Biblioteca nativa do Python utilizada para criar padrões de validação de texto (maciçamente usada para validar a estrutura correta de e-mails e regras de caracteres para o nome).

* json: Biblioteca nativa usada para converter estruturas de dados em memória (dicionários e listas) para o formato JSON string e vice-versa.

* os: Biblioteca nativa para interagir com o sistema operacional (verificar existência de arquivos como a chave de criptografia ou o arquivo JSON).

* cryptography (módulo Fernet): Biblioteca externa utilizada para realizar a criptografia simétrica. Ela garante que os dados salvos em dados_criptografados.json fiquem ilegíveis caso alguém tente abri-los diretamente.

### 2. PHP (cadastro.php)

Responsável por conectar com o banco MySQL, processar o arquivo de dados e persistir as informações com segurança.

* mysqli: Extensão do PHP para comunicação com o banco de dados MySQL.

* json_decode e file_get_contents: Utilizados para ler e converter arquivos JSON em arrays do PHP.

### 3. MySQL / Banco de Dados

Responsável pelo armazenamento permanente dos dados de usuários já cadastrados.

## Pré-requisitos

Antes de iniciar, certifique-se de ter instalado em sua máquina:

* Python 3.8+
* PHP 8.x
* Servidor MySQL (ou XAMPP no Windows / LAMP no Linux)
* Git (opcional)

## Instalação e Configuração

### 1. Preparando o Banco de Dados (MySQL)

No seu gerenciador MySQL (phpMyAdmin, MySQL Workbench ou terminal), crie o banco de dados e a tabela necessária:

```sql
CREATE DATABASE projeto1;

USE projeto1;

CREATE TABLE Usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(40) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    idade INT NOT NULL
);
```

### 2. Configurando no Windows

#### a) Clonar ou baixar o projeto

Navegue até a pasta do seu servidor local (ex: C:\xampp\htdocs\projeto1).

#### b) Criar e Ativar o Ambiente Virtual (venv)

Abra o Prompt de Comando (CMD) ou PowerShell na pasta do projeto:

```cmd
# Criar o ambiente virtual
python -m venv venv

# Ativar no Prompt de Comando (CMD)
venv\Scripts\activate

# OU Ativar no PowerShell
.\venv\Scripts\activate.ps1
```

#### c) Instalar as dependências do Python

Com o ambiente virtual ativado (venv), execute:

```cmd
pip install -r requirements.txt
```

### 3. Configurando no Linux (Ubuntu/Debian)

#### a) Instalar pacotes necessários (se ainda não tiver)

```bash
sudo apt update
sudo apt install python3 python3-venv python3-pip php php-mysqli mysql-server -y
```

#### b) Criar e Ativar o Ambiente Virtual (venv)

No terminal, dentro da pasta do projeto:

```bash
# Criar o ambiente virtual
python3 -m venv venv

# Ativar o ambiente virtual
source venv/bin/activate
```

#### c) Instalar as dependências do Python

Com o ambiente virtual ativado (venv):

```bash
pip install -r requirements.txt
```

## Como Executar o Projeto

### Passo 1: Executar o script Python para cadastrar usuário

Com o ambiente virtual ativado:

* Windows:
  ```cmd
  python main.py
  ```

* Linux:
  ```bash
  python3 main.py
  ```

Siga as instruções na tela para inserir Nome, E-mail e Idade. O script irá validar as entradas e gerar/atualizar a chave de criptografia (chave.key) e o arquivo criptografado (dados_criptografados.json).

Nota: Para o script PHP ler os dados, certifique-se de descriptografar ou ajustar o nome do arquivo lido no PHP conforme a sua necessidade.

### Passo 2: Executar o script PHP

Se estiver usando o XAMPP:

1. Inicie os módulos Apache e MySQL.
2. Acesse no navegador: http://localhost/seu-projeto/cadastro.php

Se preferir rodar direto pelo CLI do PHP:

```bash
php cadastro.php
```

## Como Desativar o Ambiente Virtual

Quando terminar de trabalhar no projeto, desative o ambiente virtual executando:

```bash
deactivate
```

## Sugestões e Melhorias

Teve alguma dúvida ou tem sugestões para melhorar a arquitetura, segurança ou código deste projeto?

Entre em contato pelo e-mail: gunderiiiterceiro@gmail.com