# REVISÃO GIT

# Após instalação

```
git config --global user.name "Seu nome"
git config --global user.email "seu@email.com"
```

## Inicializar um projeto sem git

```
git init
```


## Ignorar itens para não ser enviado para o GIT

Criar um arquivo com o nome `.gitignore`

Dentro do arquivo colocar o nome das pastas e arquivos a serem ignorados.

## Adicionar arquivos

```
git add arquivo1 arquivo2
```

## Fazer commit

```
git commit -m "uma mensage sobre o que foi feito"
```

## Caso a branch se chame master altera para main com o comando
```
git branch -M main
```
## Enviar para o github

```
git push origin main
```

# Revisão
## Composer 
Gerenciador de pacotes, onde podemos instalar dependências externas.

```bash
# Inicializa um projeto com o composer
composer init
```

```bash
# Instala uma nova dependência do projeto
composer require nome_dependencia
# Instala uma nova dependência de desenvolvimento
composer require nome_dependencia --dev
```

```bash
# Remove uma dependência do projeto
composer remove nome_dependencia
```

```bash
# Instala todas as dependências incluindo os de dev que estão listadas no composer.json
composer install

# Instalar sem os pacotes de desenvolvimento
composer intsall --no-dev
```

### O autoload

```
 "autoload": {
        "psr-4": {
            "Projetux": "src/"
        }
    },
```

> toda alteração precisa ser executado o comando
```bash
composer dumpautoload
```