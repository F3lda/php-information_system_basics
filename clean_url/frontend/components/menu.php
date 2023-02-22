<nav>
    <h1><a href="./"><?php echo $cmpnt_menu['title']; ?></a></h1>
    <ul>
        <li><a <?php if($cmpnt_menu['active'] == 'Home') {echo 'style="color:red;"';} ?> href="./home">Home</a></li>
        <li><a <?php if($cmpnt_menu['active'] == 'About') {echo 'style="color:red;"';} ?> href="./about">About</a></li>
        <li><a <?php if($cmpnt_menu['active'] == 'Login') {echo 'style="color:red;"';} ?> href="./login">Login</a></li>
    </ul>
</nav>
