<?php if(!class_exists('Rain\Tpl')){exit;}?><!doctype html>
<html lang="pt">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  </head>
  <body>
    <div>
      <h4>Obrigado por se inscrever no meu site!</h4>
      <p>Em breve receberá novidades sobre programação para iniciantes e outras curiosidades.</p>
      <p>Caso não tenha se inscrito, clique nesse <a href="<?php echo htmlspecialchars( $link, ENT_COMPAT, 'UTF-8', FALSE ); ?>">link</a> para cancelar o recebimento dos emails.</p>
      <p>Cumprimentos,</p>
      <h4>Felipe Nascimento</h4>
      <h4>Programador Novato</h4>
    </div>
  </body>
</html>