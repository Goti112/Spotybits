<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>SpotyBits</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="/Web_Spotify/SPOTYBITS/spotybits/view/css/navbar.css">
  <link rel="stylesheet" href="/Web_Spotify/SPOTYBITS/spotybits/view/css/inicio.css">
  <link rel="stylesheet" href="/Web_Spotify/SPOTYBITS/spotybits/view/css/footer.css">
  <link rel="stylesheet" href="/Web_Spotify/SPOTYBITS/spotybits/view/css/messages.css">
  <link rel="stylesheet" href="/Web_Spotify/SPOTYBITS/spotybits/view/css/carta.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body class="bg-dark text-white">

  <?php
    //se verifica si la session esta empezada antes de incluir el navbar
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
  ?>

  <!-- navbar -->
  <?php require_once __DIR__ . '/includes/navbar.php'; ?>
          
      <!-- mensajes de error -->
      <?php if (!empty($_SESSION['error'])): ?>
          <div class="msg-error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
      <?php endif; ?>

      <?php if (!empty($_SESSION['success'])): ?>
          <div class="msg-success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
      <?php endif; ?>
  </div>
  <main class="container py-4">
      <?php require $ruta; ?>
  </main>

  <!-- footer -->
  <?php require_once __DIR__ . '/includes/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>