<?php if(!class_exists('Rain\Tpl')){exit;}?><!doctype html>
<html lang="pt">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
      .button {
        background-color: gray;
        border: none;
        color: white;
        padding: 5px 15px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 13px;
        margin: 4px 2px;
        cursor: pointer;
      }
    </style>
  </head>
  <body>
    <div>
      <h4>Hello <?php echo htmlspecialchars( $name, ENT_COMPAT, 'UTF-8', FALSE ); ?>,</h4>
      <p>Click in the button below to reset your password. This link will be valid for 20 minutes. If you did not request a password reset, do not click the button below. Ignore this email.</p>
      <a style="color: white;" href="<?php echo htmlspecialchars( $link, ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="button">Reset my password</a>
    </div>
  </body>
</html>