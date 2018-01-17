<!DOCTYPE html>
<html>
<head>

<title>MYRUNS</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Favicon -->
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="/manifest.json">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="theme-color" content="#ffffff">

<!-- General javascript code -->
<script type="text/javascript" src="/shared/js/myruns_readers_api.js"></script>

<!-- Style -->
<link rel="stylesheet" href="/styles.css" />

<!-- JQuery Migrate -->
<script src="/shared/includes/libraries/jquery-migrate-1.4.1.min.js"></script>

<!-- Jquery UI -->
<link href="/shared/includes/libraries/jquery-ui/jquery-ui.css" rel="stylesheet">
<script src="/shared/includes/libraries/jquery-ui/jquery-ui.js"></script>

<script src="/shared/includes/libraries/html2canvas.js"></script>

<!-- Material design lite -->
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<script src="./mdl/material.min.js"></script>
<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.blue-cyan.min.css" />

 

<!-- Google analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-96665691-1', 'auto');
  ga('send', 'pageview');

</script>



</head>

<body class="myruns-blue-background">

<div class="mdl-card mdl-shadow--2dp center" style="margin-top: 5em;">
  <div class="mdl-card__title mdl-card--expand">
        <img src="/shared/img/logo_blue_256.png" class="center" style="max-width: 90%;">
  </div>
  <div class="mdl-card__supporting-text">

  <div class="not_connected_panel">

  	<form action="endpoints/sign_in.php" method="POST">

    <div class="color-error">
        </div>

    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
      <input class="mdl-textfield__input" type="text" id="input-server-ip" value="" name="username">
      <label class="mdl-textfield__label" for="input-server-ip">Username</label>
    </div>

    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
      <input class="mdl-textfield__input" type="password" id="input-password" value="" name="password">
      <label class="mdl-textfield__label" for="input-password">Password</label>
    </div>
        

    <input type="submit" value="Sign in" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored Width" style="width: 100%; margin-top: 3em;">

    </form>

  </div>

  </div>

</div>

</body>

</html>