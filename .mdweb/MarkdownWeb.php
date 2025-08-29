<?php
ini_set("display_errors", "On");
date_default_timezone_set("Asia/Shanghai");

# 
# 
# 用 `.htaccess` 将对 '.md' 文件的请求重定向到 'index.php'，其它请求都不变。
# 在 'index.php' 中，获取请求的文件路径，读取文件内容，渲染成 html，输出到页面。
# 程序只需处理 '.md' 文件，其它一切正常运作即可，包括：链接、图片、文件等。
#
#

include './.mdweb/Parsedown.php';

// 获取基础路径和URL
$script_name = $_SERVER['SCRIPT_NAME'];
$base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

// 获取并验证文件路径
$md_file_path = $_GET['path'] ?? 'index.md';
$md_file_path = trim($md_file_path);

// 安全检查：防止路径穿越攻击
if (strpos($md_file_path, '..') !== false || 
    strpos($md_file_path, '/') === 0 || 
    strpos($md_file_path, '\\') !== false) {
    $md_file_path = 'index.md'; // 如果路径不安全，使用默认文件
}

// 初始化变量
$title = '';
$description = '';
$keywords = '';
$author = '';
$copyright = '';
$h1 = '';
$main = '';

if (file_exists($md_file_path)) {
    $md_file_content = file_get_contents($md_file_path);
    
    if ($md_file_content !== false) {
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
        
        // 解析 markdown
        $markdown = implode("\n", $markdown_lines);
        if (!empty($markdown)) {
            $Parsedown = new Parsedown();
            $main = $Parsedown->text($markdown);
        } else {
            $main = '<div class="error">File content is empty</div>';
        }
    } else {
        $main = '<div class="error">Unable to read file</div>';
    }
} else {
    $main = '<div class="error">File does not exist</div>';
}

// 确定页面标题
$page_title = !empty($title) ? $title : (!empty($h1) ? $h1 : '');
?>