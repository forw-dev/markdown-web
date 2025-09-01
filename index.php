<?php include '.mdweb/config.php'; ?>
<?php include '.mdweb/markdown-web.php'; ?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <?php include 'google-tag.php'; ?>
  
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
  <?php include '.mdweb/header.php'; ?>
  <main>
    <div class="container">
      <?php echo $main; ?>
    </div>
  </main>
  <?php include '.mdweb/footer.php'; ?>
</body>

</html>