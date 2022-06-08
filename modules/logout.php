<?php
    if($isAdmin==true):
        ?><div class="user-bar">
            <img src="../images/admin.png" alt="">
            <form method="POST">
                <button type="submit" name="logout"><img src="../images/exit.png" alt=""></button>
            </form>
        </div>
<?php endif;?>