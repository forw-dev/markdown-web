<?php
$file_path = $_GET['path'] ?? 'default.md'; 
$file_path = trim($file_path);
// 安全检查：防止路径穿越攻击
if (strpos($file_path, '..') !== false || 
    strpos($file_path, '/') === 0 || 
    strpos($file_path, '\\') !== false) {
    echo 'Not allowed';
    exit();
}
// 文件是否存在
if (!file_exists($file_path)) {
    echo 'File not exist';
    exit();
}
// 读取文件
$md_file_content = file_get_contents($file_path);
if ($md_file_content === false) {
    $main = 'Read file failed';
}
// 编码为数据
// $data = json_encode($md_file_content, JSON_UNESCAPED_UNICODE);
$data = base64_encode($md_file_content);
?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="UTF-8">
  <link rel="icon" href="https://forw.cc/static/favicon.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MDWeb | forw.cc</title>

  <script src="https://cdn.jsdelivr.net/npm/markdown-it/dist/markdown-it.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/katex@0.16.22/dist/katex.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/katex@0.16.22/dist/contrib/auto-render.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.22/dist/katex.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/styles/default.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/highlight.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/mermaid@11.11.0/dist/mermaid.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>

  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      margin: 0;
      padding: 0;
      font-size: 1.1rem;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
    }

    a:link,
    a:visited {
      color: inherit;
      /* 继承父元素颜色 */
      text-decoration: none;
    }

    nav {
      display: flex;
      gap: 1.5rem;
      flex-wrap: wrap;
    }

    header {
      background: linear-gradient(to right, #5f91ec, #5fb4ec);
      color: white;
      padding: 2rem;
      margin-bottom: 1rem;
    }

    header .container {
      display: flex;
      /* 启用 Flexbox 布局 */
      justify-content: space-between;
      /* 子元素两端对齐 */
      align-items: center;
      /* 子元素垂直居中 */
    }

    header nav {
      font-weight: bold;
    }

    main {
      /* 让main元素占据所有剩余的垂直空间，从而将footer推到底部 */
      flex: 1;
      padding: 0.5rem 2rem;
    }

    main a {
      color: #0059ff !important;
    }

    main h1 {
      font-size: 2.2rem;
      margin: 2rem 0;
    }

    footer {
      background: linear-gradient(to right, #5f91ec, #5fb4ec);
      color: #eee;
      padding: 2rem;
    }

    footer nav {
      margin: 0.5rem 0;
    }

    table {
      margin-bottom: 1rem;
      border-bottom: 1px solid #ddd;
      border-right: 1px solid #ddd;
      border-spacing: 0;
    }

    table th {
      padding: 0.2rem 0.8rem;
      border-top: 1px solid #ddd;
      border-left: 1px solid #ddd;
      font-weight: bold;
      background-color: #f9f9f9;
    }

    table td {
      padding: 0.2rem 0.8rem;
      border-top: 1px solid #ddd;
      border-left: 1px solid #ddd;
      white-space: nowrap;
    }


    code {
      padding: 2px 6px;
      background-color: #eee;
      border: 1px solid #eee;
      border-radius: 4px;
      font-family: "SFMono-Regular", Consolas, "Liberation Mono", Menlo, Courier,
        monospace;
      font-size: 0.9rem;
    }

    /* 为 pre>code 块移除行内 code 的样式，避免双重背景 */
    pre code {
      padding: 0;
      background-color: transparent;
      border: none;
    }

    pre {
      padding: 0.8rem 1rem;
      border: 1px solid #ddd;
      border-radius: 7px;
      white-space: pre-wrap;
      word-wrap: break-word;
    }

    hr {
      margin: 2rem 0;
    }

    blockquote {
      margin: 1rem 0;
      padding: 0.1rem 1rem;
      border-left: 4px solid #5f91ec;
      background-color: #f5f5f5;
    }
  </style>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      // 初始化 Mermaid，但不立即执行
      mermaid.initialize({
        startOnLoad: false,
        theme: 'default',
        securityLevel: 'loose',
        flowchart: {
          useMaxWidth: true,
          htmlLabels: true
        }
      });
      // 配置 markdown-it
      const md = window.markdownit({
        html: true,
        linkify: true,
        typographer: true,
        highlight: function (str, lang) {
          if (lang === 'mermaid') {
            return '<div class="mermaid">' + md.utils.escapeHtml(str) + '</div>';
          }
          if (lang && hljs.getLanguage(lang)) {
            try {
              return '<pre class="hljs"><code>' +
                hljs.highlight(str, { language: lang, ignoreIllegals: true }).value +
                '</code></pre>';
            } catch (__) { }
          }
          return '<pre class="hljs"><code>' + md.utils.escapeHtml(str) + '</code></pre>';
        }
      });
      // 获取数据
      const data = decodeURIComponent(escape(atob("<?php echo $data;?>")));
      // 解析文档
      const regex = /^---\r?\n([\s\S]+?)\r?\n---\r?\n?([\s\S]*)$/;
      const match = data.match(regex);
      let frontMatter = {};
      let content = '';
      if (match){
        const frontMatterString = match[1];
        frontMatter = jsyaml.load(frontMatterString);
        content = match[2].trim();
      } else {
        content = data;
      }
      /*    
      if (frontMatter.protect == true) {
        const script = document.createElement('script');
        script.src = 'https://forw.cc/static/front-end-protect.js';
        script.async = true; 
        document.head.appendChild(script);
      } 
      */
      // 渲染 Markdown
      const html = md.render(content);
      // 插入渲染后的 HTML
      const contentElement = document.getElementById('content');
      contentElement.innerHTML = html;
      // 渲染数学公式
      renderMathInElement(document.body, {
        delimiters: [
          { left: "$$", right: "$$", display: true },
          { left: "$", right: "$", display: false },
          { left: "\\[", right: "\\]", display: true },
          { left: "\\(", right: "\\)", display: false }
        ]
      });
      // 最后，运行 Mermaid 来渲染图表
      mermaid.run();
    });
  </script>
</head>

<body>
  <header>
    <div class="container">
      <div class="logo">
        <a href="https://forw.cc">
          <img src="https://forw.cc/static/logo.png" alt="logo">
        </a>
      </div>
      <nav>
        <a href="/">Home</a>
      </nav>
    </div>
  </header>

  <main>
    <div class="container">
      <article id="content">
      </article>
    </div>
  </main>

  <footer>
    <div class="container">
      &copy; 2025 <a href='https://forw.cc' target="_blank"> forw.cc </a>
    </div>
  </footer>
</body>

</html>