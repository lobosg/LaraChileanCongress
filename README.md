# LaraChileanCongress - Wrapper for opendata.congreso.cl web service

Package to facilitate the use of opendata.congreso.cl web service using Laravel

# Installation

To add this package on your Laravel project add this on your `composer.json file

```
"unforgivencl/larachileancongress": "dev-master"
```


To install and configure add the service provider to your `config/app.php`

```
Unforgivencl\LaraChileanCongress\LaraChileanCongressServiceProvider::class,
```


If you want to use the Facade add this to your facade section on `config/app.php`

```
'ChileanCongress' => Unforgivencl\LaraChileanCongress\Facades\LaraChileanCongress::class,
```


# Usage

For example if you want to get all delegates you can use

In some endpoints the web service changes url (delegates), to use that WS you need to change
with ```setDelegates()``` method, if you use the senators endpoint use ```setSenators()``` , by
default it's set to Senators


```
$delegates = ChileanCongress::delegate()->setDelegates()->getDelegates()->fetch();
```

If you want to get information of a votation of senators you can use

```
$votation = ChileanCongress::votation()->number('8575')->getSenatorsVotation()->fetch();
```

If you want to get a specific law project you can use

```
$lawProject = ChileanCongress::lawproject()->number('1')->getLawProject()->fetch();
```

# Response

All responses are converted to JSON from an XML Response, if you see any weird index or order, i'm sorry but
the web service are very incosistent

# Development

This package are under development so if you find any bug feel free to send PR or send an issue.
