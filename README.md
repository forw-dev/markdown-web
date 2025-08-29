# Markdown Web (mdweb)

## 1. 概述

在线浏览 Markdown 文件的工具，极简风格。

## 2. 特点

- 简单易用。放在哪里，哪里的 Markdown 文件就会被渲染。
- Markdown 文件内嵌的超链接、图片等无需任何处理，都能正常工作。

## 3. 快速开始

- 放置 `.htaccess`、 `index.php`、 `.mdweb/` 到主机目录。
- 放置 `.md` 文件到主机目录，`index.md` 为内容的入口文件。
- 用浏览器访问 `.md` 文件，Markdown 已被渲染。

## 4. SEO

通过 `.md` 文件的 FrontMatter 来设置页面的 SEO 信息：

```yaml
---
title: forw.cc                                      # 页面标题，默认值为页面 h1 标题。
description: 在线浏览 markdown 文件的工具，极简风格。  # 页面描述，默认值为空。
keywords: markdown web, one file, md to html        # 页面关键词，默认值为空。
author: tyx                                         # 页面作者，默认值为空。
copyright: Copyright © 2025 forw.cc                 # 页面版权，默认值为空。
---
```

## 5. 自定义

- `index.php` 保持着清晰的原始结构，直接编辑即可。
- 其它资源都在 `.mdweb/` 目录中。
