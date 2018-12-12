<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link rel="manifest" href="/manifest.json">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" id="status-bar" content="white-translucent">
    <meta name="format-detection" content="telephone=no">

    <meta name="author" content="Mathieu Sanchez">

    <title><?= $this->head[ 'title' ] ?></title>
    <meta name="description" content="<?= $this->head[ 'description' ] ?>">

    <meta property="og:title" content="<?= $this->head[ 'title' ] ?>"/>
    <meta property="og:description" content="<?= $this->head[ 'description' ] ?>"/>
    <meta property="og:url" content="https://<?= $_SERVER[ 'SERVER_NAME' ] . $_SERVER[ 'REQUEST_URI' ] ?>"/>
    <meta property="og:image"
          content="//<?= $_SERVER[ 'SERVER_NAME' ] . \WebProjectFitness\Config::FAVICON_PATH ?>"/>
    <!--    <meta property="fb:app_id"              content="1000452166691027" /> -->

    <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700%7CRoboto+Condensed:400,700%7CMaterial+Icons'
          rel='stylesheet' type='text/css'>
    <link href="/css/materialize.min.css" rel="stylesheet">

    <link href="/css/style.css?v=<?= WebProjectFitness\Config::SITE_CSS_VERSION ?>" rel="stylesheet">

    <link rel="image_src" href="//<?= $_SERVER[ 'SERVER_NAME' ] . \WebProjectFitness\Config::FAVICON_PATH ?>"/>
    <link rel="icon" type="image/ico"
          href="//<?= $_SERVER[ 'SERVER_NAME' ] . \WebProjectFitness\Config::FAVICON_PATH ?>"/>

    <meta name="theme-color" content="#ffffff">

    <?php if ( isset( $this->head[ 'robotNoIndex' ] ) && $this->head[ 'robotNoIndex' ] == true ) { ?>
        <meta name="robots" content="noindex"/>
    <?php } ?>

</head>

<body class="grey lighten-4">

<ul id="user" class="dropdown-content">
    <li><a>Your Account</a></li>
    <li class="divider"></li>
    <li><a>Your Saved Exercises</a></li>
    <li class="divider"></li>
    <li><a>Your Training</a></li>
</ul>

<div class="navbar-fixed">
    <nav class="green darken-3" role="navigation">
        <div class="nav-wrapper container">
            <a id="logo-container" class="brand-logo">
                <img src="/img/logo.svg" alt="Logo for Your Exercise" height="64px"/>
            </a>

            <ul class="right hide-on-med-and-down">
                <li>
                    <a class="dropdown-trigger" data-target="user">Name Of The Account<i class="material-icons right">arrow_drop_down</i></a>
                </li>
            </ul>
        </div>
    </nav>
</div>

<main>
