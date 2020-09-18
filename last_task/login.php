
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Login</title>
</head>
<body>
    <header>
        <div class="title">
            <div class="title_top"></div>
            <div class="title_next"></div>
        </div>
    </header>
    <h2>Login</h2>
    <form action="login.act.php" method="post" name="form1">
        email: <input type="text" name="email"/>
        PW: <input type="password" name="pw"/>
        <input type="submit" value="LOGIN" id="login"> 
    </form>
    <a href="index.html">戻る</a>
    
    <div class="footer">
        <div class="footer_navi">
            <ul class="footer_navi_title">
                <li>About</li>
                <li>Contact</li>
                <li>Term of Use</li>
                <li>Privacy Policy</li>
            </ul>
        </div>

        <div class="copy">
            <p class="copy_title">ⓒALPS2020.All Rights Reserved</p>
        </div>

        <div class="sns_link">
            <div class="sns_link_btn">
                <ul class="sns_link_list">
                    <li><a href=""><img src="" alt="">facebook</a></li>
                    <li><a href=""><img src="" alt="">Instagram</a></li>
                    <li><a href=""><img src="" alt=""></a></li>
                    <!-- 中華系のSNSと中東系のSNS -->
                </ul>
            </div>
        </div>
    </div>
</body>
</html>