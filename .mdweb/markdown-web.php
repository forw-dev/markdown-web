<?php
# 
# 
# 用 `.htaccess` 将对 '.md' 和 '.php' 文件的请求重定向到 'index.php'，其它请求都不变。
# 如果是 '.md'，在 'index.php' 中，获取请求的文件路径，读取文件内容，渲染成 html，输出到页面。
# 如果是 '.php'，在 'index.php' 中，获取请求的文件路径，包含文件，执行文件，输出到页面。
#
#

// 初始化变量
$title = '';
$description = '';
$keywords = '';
$author = '';
$copyright = '';

$h1 = '';
$main = '';
$page_title = '';

// 获取并验证文件路径
$file_path = $_GET['path'] ?? 'index.md';
$file_path = trim($file_path);

// 安全检查：防止路径穿越攻击
if (strpos($file_path, '..') !== false || 
    strpos($file_path, '/') === 0 || 
    strpos($file_path, '\\') !== false) {
    $main = '<div class="error">Not allowed</div>';
}

// 文件是否存在
if (!file_exists($file_path)) {
    $main = '<div class="error">File does not exist</div>';
}

// 读取文件
$md_file_content = file_get_contents($file_path);
if ($md_file_content === false) {
    $main = '<div class="error">Unable to read file</div>';
}

// 解析文件
if ($main == ""){
    $md_file_content_lines = explode("\n", $md_file_content);

    // 分离 frontMatter 和 markdown
    $front_matter_lines = array();
    $markdown_lines = array();
    $is_front_matter = false;
    $front_matter_closed = false;

    for ($i = 0; $i < count($md_file_content_lines); $i++) {
        $line = $md_file_content_lines[$i];
        $trimmed_line = trim($line);
        
        // 检查 front matter 开始
        if ($trimmed_line == "---" && $i == 0) {
            $is_front_matter = true;
            continue;
        }
        
        // 检查 front matter 结束
        if ($trimmed_line == "---" && $is_front_matter && !$front_matter_closed) {
            $is_front_matter = false;
            $front_matter_closed = true;
            continue;
        }
        
        if ($is_front_matter) {
            $front_matter_lines[] = $line;
        } else {
            $markdown_lines[] = $line;
            // 提取第一个 H1 标题
            if (empty($h1) && preg_match('/^#\s+(.+)$/', $trimmed_line, $matches)) {
                $h1 = trim($matches[1]);
            }
        }
    }
}

// 解析 frontMatter
if (count($front_matter_lines) > 0) {
    foreach ($front_matter_lines as $front_matter_line) {
        if (strpos($front_matter_line, ':') !== false) {
            $kv = explode(":", $front_matter_line, 2);
            $key = strtolower(trim($kv[0]));
            $value = trim($kv[1]);
            
            switch ($key) {
                case 'title':
                    $title = $value;
                    break;
                case 'description':
                    $description = $value;
                    break;
                case 'keywords':
                    $keywords = $value;
                    break;
                case 'author':
                    $author = $value;
                    break;
                case 'copyright':
                    $copyright = $value;
                    break;
            }
        }
    }
}

// 确定页面标题
$page_title = !empty($title) ? $title : (!empty($h1) ? $h1 : '');

// 解析 markdown
if (count($markdown_lines) > 0){
    include ".mdweb/Parsedown.php";
    $markdown = implode("\n", $markdown_lines);
    $Parsedown = new Parsedown();
    $main = $Parsedown->text($markdown);
}

// 如果 main 还是空的
if ($main == ""){
    $main = '<div class="error">File content is empty</div>';
}
?>