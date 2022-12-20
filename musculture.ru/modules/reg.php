
                elseif (isset($_POST['reg'])){
                    if(empty($_POST['username']) or empty($_POST['password'])){
                        ?><span class="fault-msg">Проверьте введенные данные</span><?php
                        exit();
                    }
                    $username=$_POST['username'];
                    $password=$_POST['password'];
    
                    $salt=bin2hex(random_bytes(5));
                    $salted_password=$salt.$password;
                    $hash=password_hash($salted_password,PASSWORD_DEFAULT);
                    
                    if ($connection->query("INSERT INTO users(username,salt,hash) VALUES('$username','$salt','$hash')")===TRUE):
                    ?>  <span class="success-msg"><?php echo "Новый пользователь зарегистрирован";?></span>
                    <?php
                    else:
                    ?>  <span class="fault-msg"><?php echo "Ошибка регистрации"?></span>
                <?php endif;
                }