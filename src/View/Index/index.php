<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sample chat with mvc">
    <meta name="author" content="Thibault Forax">
    <link rel="icon" href="/img/favicon.ico">
    <title>Kiara - Chat en ligne</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/kiara.css" rel="stylesheet">
    <link href="/css/chat.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
<h3 class=" text-center">Kiara</h3>
<div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>Connecté</h4>
            </div>
          </div>
          <div class="inbox_chat"></div>
        </div>
        <div class="mesgs">
          <div class="div-previous"><a href="#" id="previous-message">Charger les anciens messages</a></div>
          <div class="msg_history"></div>
          <div class="type_msg">
            <div class="input_msg_write">
                <form id="form-message">
                  <input type="text" name="message" id="input-message" class="write_msg" placeholder="Ecrire un message" />
                  <button class="msg_send_btn" id="submit-message" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div></div>
    <div id="spinner-block">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20"></circle>
        </svg>
    </div>
    <script src="/lib/jquery/js/jquery-3.2.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="/lib/noty/js/jquery.noty.packaged.min.js"></script>
    <script src="/js/kiara.js"></script>
    <script src="/js/chat.js"></script>
  </body>
</html>
