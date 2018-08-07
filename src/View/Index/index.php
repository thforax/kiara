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
    <link href="/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/kiara.css" rel="stylesheet">
    <link href="/css/chat.css" rel="stylesheet">
  </head>
  <body>
    <div class="container app">
      <div class="row app-one">
        <div class="col-sm-4 side">
          <div class="side-one">
            <div class="row heading">
              <div class="col-sm-12 col-xs-12">
                <?php echo $_SESSION['user']['login']; ?>
              </div>
            </div>

            <div class="row sideBar">
                <?php
                foreach ($userActiveList as $user) { ?>
              <div class="row sideBar-body">
                <div class="col-sm-12 col-xs-12 sideBar-main">
                  <div class="row">
                    <div class="col-sm-12 col-xs-12 sideBar-name">
                      <span class="name-meta"><?php echo $user['usr_login']; ?>
                    </span>
                    </div>
                  </div>
                </div>
              </div>
                <?php } ?>
            </div>
          </div>
        </div>

        <div class="col-sm-8 conversation">
          <div class="row heading">
            <div class="col-sm-1 col-xs-1 heading-dot pull-right">
              <a href="/login/logout"><i class="fa fa-sign-out fa-2x pull-right" aria-hidden="true"></i></a>
            </div>
          </div>

          <div class="row message" id="conversation">
            <div class="row message-previous">
              <div class="col-sm-12 previous">
                <a onclick="previous(this)" id="ankitjain28" name="20">
                Voir les messages précédents
                </a>
              </div>
            </div>
            <?php
            foreach ($messageList as $message) {
                $class = 'receiver';
                if ($message['usr_id'] == $_SESSION['user']['id']) {
                    $class = 'sender';
                }
                ?>
            <div class="row message-body">
              <div class="col-sm-12 message-main-<?php echo $class; ?>">
                <div class="<?php echo $class; ?>">
                  <div class="message-text">
                   <?php echo nl2br($message['msg_content']); ?>
                  </div>
                  <span class="message-time pull-right">
                    <?php echo $message['usr_login']; ?> -
                    <?php echo $message['msg_date']; ?>
                  </span>
                </div>
              </div>
            </div>
            <?php } ?>
            <!--<div class="row message-body">
              <div class="col-sm-12 message-main-sender">
                <div class="sender">
                  <div class="message-text">
                    I am doing nothing man!
                  </div>
                  <span class="message-time pull-right">
                    Sun
                  </span>
                </div>
              </div>
            </div>-->
          </div>

          <div class="row reply">
            <form id="form-message">
                <div class="col-sm-11 col-xs-9 reply-main">
                  <input type="text" name="message" id="input-message" class="form-control"></textarea>
                </div>
                <div class="col-sm-1 col-xs-1 reply-send">
                  <a href="#"><i class="fa fa-send fa-2x" aria-hidden="true"></i></a>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div id="spinner-block">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20"></circle>
        </svg>
    </div>
    <script src="/lib/jquery/js/jquery-3.2.1.min.js"></script>
    <script src="/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="/lib/noty/js/jquery.noty.packaged.min.js"></script>
    <script src="/js/kiara.js"></script>
    <script src="/js/chat.js"></script>
  </body>
</html>
