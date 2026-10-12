# Projeto de Integração: Python, PHP e MySQL com Criptografia

Este projeto foi desenvolvido para integrar Python, PHP e MySQL (SQL), aplicando validações de entrada, criptografia simétrica de dados (Fernet) e persistência segura em banco de dados utilizando PDO e Transações.

## Para que serve o projeto?

O objetivo principal é simular um fluxo completo de manipulação segura de dados:

1. **Python (`main.py`)**: Atua como interface CLI para coleta de dados do usuário. Ele valida o formato do nome, e-mail e idade e salva os registros criptografados em um arquivo JSON local (`dados_criptografados.json`) com o auxílio de uma chave simétrica (`chave.key`).
2. **PHP (`cadastro.php`)**: Lê o arquivo criptografado, realiza a descriptografia nativa usando a biblioteca Fernet do PHP e salva os usuários no banco MySQL através de PDO com suporte a transações (`beginTransaction` / `commit` / `rollBack`).

---

## Tecnologias e Bibliotecas Utilizadas

### 1. Python (`main.py` e `funções.py`)

* **`re` (Expressões Regulares)**: Validação de padrões de formato para e-mails e regras de nome.
* **`json`**: Serialização e desserialização de dados JSON.
* **`os`**: Verificação da existência de arquivos no sistema de arquivos.
* **`cryptography` (Módulo `Fernet`)**: Criptografia simétrica em Python.

### 2. PHP (`cadastro.php`)

* **`PDO` (PHP Data Objects)**: Interface de conexão e manipulação segura do MySQL com Prepared Statements.
* **`kelvinmo/fernet-php`**: Biblioteca responsável por descriptografar dados Fernet diretamente no PHP (instalada via Composer na pasta `vendor/`).

### 3. Gerenciador de Dependências & Banco

* **Composer**: Gerenciador de pacotes PHP (usado para baixar dependências externas do PHP).
* **MySQL / MariaDB**: Banco de dados relacional.

---

## Pré-requisitos

* **Python 3.8+**
* **PHP 8.x** (com extensões `pdo_mysql` ativas)
* **Composer** (para PHP)
* **XAMPP / LAMPP**

---

## Passo a Passo de Configuração

### 1. Criar o Banco de Dados

Acesse o phpMyAdmin (`http://localhost/phpmyadmin`) ou o terminal MySQL e execute:

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

---

### 2. Como Ligar o XAMPP / LAMPP

Para que o servidor Apache e o banco de dados MySQL funcionem, é necessário ligar o serviço do XAMPP:

#### No Windows:
1. Abra o menu Iniciar e procure por **XAMPP Control Panel**.
2. Clique com o botão direito e selecione **Executar como Administrador**.
3. Clique no botão **Start** ao lado do módulo **Apache**.
4. Clique no botão **Start** ao lado do módulo **MySQL**.
5. Verifique se ambos os nomes ficaram destacados em verde.

#### No Linux (LAMPP):
Abra o terminal e inicie o serviço com o comando:
```bash
sudo /opt/lampp/lampp start
```
*(Para verificar o status: `sudo /opt/lampp/lampp status`)*

---

### 3. Instalar o Fernet no PHP via Composer

Atenção: O comando do Composer deve ser executado no terminal do sistema e **FORA** do ambiente virtual Python (`venv`). O ambiente virtual do Python só serve para gerenciar os pacotes `pip` do Python, enquanto o Composer gerencia pacotes do PHP.

Se o seu ambiente virtual Python estiver ativo no terminal (com a palavra `(venv)` aparecendo no início do terminal), desative-o antes de usar o Composer:

```bash
deactivate
```

#### Como instalar a biblioteca PHP:

1. Verifique se o **Composer** está instalado em sua máquina:
   * **Windows**: Baixe o instalador oficial no site [getcomposer.org](https://getcomposer.org/).
   * **Linux**: Instale via gerenciador de pacotes:
     ```bash
     sudo apt update
     sudo apt install composer -y
     ```

2. Abra o terminal na pasta raiz do projeto (onde está o arquivo `composer.json`) e rode o comando:
   ```bash
   composer install
   ```

*Este comando lerá o arquivo `composer.json` e baixará a biblioteca `kelvinmo/fernet-php` para a pasta `vendor/`.*

---

### 4. Configurar e Ativar o Ambiente Virtual Python (venv)

Agora que o PHP está configurado, você pode ativar o ambiente virtual exclusivo do Python para instalar os requisitos do Python.

#### No Windows:
```cmd
# Criar o venv (caso ainda não exista)
python -m venv venv

# Ativar o venv (CMD)
venv\Scripts\activate

# OU no PowerShell
.\venv\Scripts\activate.ps1

# Instalar dependências Python
pip install -r requirements.txt
```

#### No Linux:
```bash
# Criar o venv
python3 -m venv venv

# Ativar o venv
source venv/bin/activate

# Instalar dependências Python
pip install -r requirements.txt
```

---

## Como Executar a Aplicação

### Passo 1: Executar o Cadastro em Python

Com o `venv` do Python ativado:

* **Windows**: `python main.py`
* **Linux**: `python3 main.py`

Informe Nome, E-mail e Idade. O Python irá criar ou atualizar os arquivos `chave.key` e `dados_criptografados.json`.

---

### Passo 2: Executar o Processamento em PHP

1. Certifique-se de que os arquivos do projeto estão dentro da pasta do servidor web:
   * Windows: `C:\xampp\htdocs\projeto`
   * Linux: `/opt/lampp/htdocs/projeto`
2. Certifique-se de que o **Apache** e **MySQL** estão ativos no XAMPP.
3. Abra o navegador de sua preferência e acesse:
   `http://localhost/projeto/cadastro.php`

O PHP irá ler os dados criptografados, descriptografá-los usando a chave, abrir uma transação PDO e inserir os dados de forma segura na tabela `Usuario`.

---

## Sugestões e Melhorias

Caso tenha sugestões de melhorias de arquitetura, refatoração de código ou dúvidas sobre o projeto:

Entre em contato: **gunderiiiterceiro@gmail.com**