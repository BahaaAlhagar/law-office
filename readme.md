# Lawyer Office Panel | PHP Laravel Panel

- [About](#about)
- [Requirements](#requirements)
- [Installation](#installation)

## About

Simple Panel to control lawyer office in arabic, including Cases & Office Clients & Contracts & Todos & Files Mangement.

## Requirements

```bash
	
    PHP >= 7.0.0
    OpenSSL PHP Extension
    PDO PHP Extension
    Mbstring PHP Extension
    Tokenizer PHP Extension
    XML PHP Extension

```

## Installation

1. Download or Clone this Repository

2. From your this Repository root folder in terminal run:

```bash
    composer install
```
then create you .env file and configure it and use this command to create the database tables.

```bash
    php arstian migrate --seed
```

3. Navigate to the browser and use the default admin & password to log in

```bash
    username: admin@law.dev
    password: secret
```
