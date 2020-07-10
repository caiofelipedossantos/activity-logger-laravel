# Activity Logger Laravel

Armazenamento de Logs podendo ser acionado via Middleware ou Trait.
Suporta Laravel 5.\*, 6.\* e 7 (Não testado).

## Requisitos

- [Laravel](https://laravel.com/docs/installation)
- [jaybizzle/laravel-crawler-detect](https://github.com/JayBizzle/Laravel-Crawler-Detect)

## Instalação
1 - No terminal acesse a raiz do projeto e execute o comando:

```sh
$ composer require polares552/activity-logger-laravel
```
2 - Laravel 5.5 e superior efetua a descoberta automática de pacotes, sem necessidade de editar o arquivo `config/app.php`.

* Laravel 5.4 e abaixo é necessário registrar o pacote adicionando o provider no arquivo `config/app.php`:

```sh
'providers' => [
        polares552\ActivityLogger\ActivityLoggerServiceProvider::class,
];
```
3 - Efetue a publicação do arquivo de configuração:

```sh
$ php artisan vendor:publish --provider="polares552\ActivityLogger\ActivityLoggerServiceProvider" --tag="config"
```
4 - Efetue a publicação do arquivo de banco de dados:

```sh
$ php artisan vendor:publish --provider="polares552\ActivityLogger\ActivityLoggerServiceProvider" --tag="migrations"
```
5 - Execute a **Migration** para criar a tabela no banco de dados.

```sh
php artisan migrate
```

## Utilização

Via **Middleware**

Você pode efetuar o rastreamento dos eventos das rotas e controller utilizando o name `activity` no `Route::group`. Por exemplo:

```sh
Route::group(['middleware' => ['activity']], function () {
    Route::get('/', 'WelcomeController@welcome')->name('welcome');
});
```

Via **Trait**

Eventos podem ser gravados diretamente usando a Trait, possibilitando a personalização da descrição do evento a ser armazenado.

1 - Para utilizar a Trait adicione a chamada no cabeçalho da classe:

```sh
use polares552\ActivityLogger\App\Http\Traits\ActivityLogger;
```

2 - Inclua a chamada da Trait na class:

```sh
use ActivityLogger;
```

3 - Para gravar um novo log utilize o método `activity`.

```sh
ActivityLogger::activity("Descrição do Log.");
```

## Recursos

Atualmente o **ActivityLogger**  efetua o armazenamento dos seguintes itens:
* Id do usuário autenticado;
* Descrição do Log armazenado;
* Tipo de registro efetuado;
* Rota acessada;
* Controller associado a rota - caso exista;
* Método associado a rota - caso exista;
* Parâmetros enviados na requisição;
* Endereço IP;
* Agente utilizado;
* Idioma
* URL corrente;
* Tipo de requisição;
* Data de cadastro;


## Screenshots

![Armazenamento](https://raw.githubusercontent.com/polares552/activity-logger-laravel/master/ActivityLogger.png)

