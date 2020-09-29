
<?php if(isset($_SESSION["loggedIn"])){
    header('Location: index.php?aktion=backend');}
    ?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="styles/login-style.css">
    <meta name="noindex" content="noindex" />
</head>
<body>
  <div id="login">

      <div class="login-item">
          <img src="images/login-icon.png" alt="login-image">
      </div>

      <div class="login-item">

        <form id="login-form" method="post" action="index.php?aktion=login" >
          <legend>Administrationpanel</legend>
            <input type="password" class="password" placeholder="Passwort" name="passwd" required>
          <input type="submit" name="Login" value="Login">
        </form>

      </div>
  </div>
</body>
</html>
