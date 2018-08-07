<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sample chat with mvc">
    <meta name="author" content="Thibault Forax">
    <link rel="icon" href="/img/favicon.ico">
    <title>Kiara - Erreur <?php echo $_GET['code']; ?></title>
    <link href="/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/lib/formvalidation/css/formValidation.min.css" rel="stylesheet">
    <link href="/css/kiara.css" rel="stylesheet">
    <link href="/css/error.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
        <h1 class="text-primary text-center"><?php echo $code; ?></h1>
        <h2 class="text-grey text-center"><?php echo $title; ?></h2>
        <div class="panel panel-padding-20 margin-top-20 text-center">
            <span class="text-primary text-big">Désolé !</span> <?php echo $text; ?>
            <br><br>
            <a href="/index" class="btn btn-action btn-action-primary no-margin">Retour à l'accueil</a>
        </div>
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
