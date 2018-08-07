<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sample chat with mvc">
    <meta name="author" content="Thibault Forax">
    <link rel="icon" href="/img/favicon.ico">
    <title>Kiara - Connexion</title>
    <link href="/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/lib/formvalidation/css/formValidation.min.css" rel="stylesheet">
    <link href="/css/kiara.css" rel="stylesheet">
    <link href="/css/login.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <form id="form-login" class="form-login">
        <h2 class="form-login-heading">Veuillez-vous connecter</h2>
        <div class="form-group">
            <label for="input-login" class="sr-only">Identifiant</label>
            <input type="text" name="login" id="input-login" class="form-control" placeholder="Identifiant" autofocus>
        </div>
        <div class="form-group">
            <label for="input-password" class="sr-only">Mot de passe</label>
            <input type="password" name="password" id="input-password" class="form-control" placeholder="Mot de passe">
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Se connecter</button>
      </form>
    </div>
    <div id="spinner-block">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20"></circle>
        </svg>
    </div>
    <script src="/lib/jquery/js/jquery-3.2.1.min.js"></script>
    <script src="/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="/lib/noty/js/jquery.noty.packaged.min.js"></script>
    <script src="/lib/formvalidation/js/formValidation.min.js"></script>
    <script src="/lib/formvalidation/js/framework/bootstrap.min.js"></script>
    <script src="/js/kiara.js"></script>
    <script src="/js/login.js"></script>
  </body>
</html>
