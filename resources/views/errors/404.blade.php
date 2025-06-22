<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página Não Encontrada</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background: linear-gradient(135deg, #42a5f5, #478ed1);
      color: white;
      font-family: 'Roboto', sans-serif;
    }

    .center-box {
      text-align: center;
      padding: 40px;
      border-radius: 15px;
      background-color: rgba(0, 0, 0, 0.3);
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    .error-code {
      font-size: 6rem;
      font-weight: 700;
    }

    .btn-large {
      margin-top: 20px;
    }
  </style>
</head>
<body>

  <div class="center-box">
    <i class="material-icons large">error_outline</i>
    <div class="error-code">404</div>
    <h5>Ops! Página não encontrada.</h5>
    <p>A página que você procura pode ter sido removida ou nunca existiu.</p>
    <a href="/" class="btn-large blue lighten-1 waves-effect waves-light">
      <i class="material-icons left">home</i>Voltar para o início
    </a>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
