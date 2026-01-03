<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>正在跳转</title>
    <!-- 隐藏页面，实现无感知跳转 -->
    <style>body{display:none;}</style>
</head>
<body>
    <script type="text/javascript">
        // 替换为你的目标防红链接（如支付宝外部链接）
        const targetUrl = "https://baidu.com";
        // 延迟跳转（可选，避免被检测为恶意跳转）
        setTimeout(() => {
            window.location.href = targetUrl;
        }, 500);
    </script>
</body>
</html>
