<?php include './.mdweb/MarkdownWeb.php'; ?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta name="robots" content="all">
  <meta name="revisit-after" content="7 days">
  <meta http-equiv="expires" content="0">
  <meta name="description" content="<?php echo htmlspecialchars($description); ?>">
  <meta name="keywords" content="<?php echo htmlspecialchars($keywords); ?>">
  <meta name="author" content="<?php echo htmlspecialchars($author); ?>">
  <meta name="copyright" content="<?php echo htmlspecialchars($copyright); ?>">

  <title><?php echo htmlspecialchars($page_title); ?></title>

  <link rel="icon" href="<?php echo $base_url; ?>/.mdweb/fav.ico" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo $base_url; ?>/.mdweb/styles.css">
</head>

<body>
  <header>
    <div class="container">
      <div class="logo">
        <a href="https://forw.cc">
          <img src="<?php echo $base_url?>/.mdweb/logo.png" alt="logo">
        </a>
      </div>
      <nav>
        <a href="<?php echo $base_url; ?>/">Home</a>
      </nav>
    </div>
  </header>
  <main>
    <div class="container">
      <?php echo $main; ?>
    </div>
  </main>
  <footer>
    <div class="container">
      <nav>
        <!-- <a href="#">About Us</a> | -->
        <!-- <a href="#">Support Us</a> | -->
        <a href="<?php echo $base_url; ?>/privacy-policy.md">Privacy Policy</a> |
        <a href="<?php echo $base_url; ?>/terms-of-service.md">Terms of Service</a>
      </nav>
      <p>&copy; 2025 forw.cc</p>
    </div>
  </footer>
</body>

</html>