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

  <script src="https://cdn.jsdelivr.net/npm/katex@0.16.22/dist/katex.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/katex@0.16.22/dist/contrib/auto-render.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.22/dist/katex.min.css">

  <script src="https://cdn.jsdelivr.net/npm/mermaid@11.11.0/dist/mermaid.min.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      renderMathInElement(document.body, {
        delimiters: [
          {left: "$$", right: "$$", display: true},
          {left: "$", right: "$", display: false},
          {left: "\\(", right: "\\)", display: false},
          {left: "\\[", right: "\\]", display: true}
        ]
      });
    });

    mermaid.initialize({
      startOnLoad: true,
      theme: 'default'
    });
  </script>

  <link rel="icon" href="<?php echo $base_url; ?>/.mdweb/favicon.png">
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