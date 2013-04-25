</div>
</div>
<!-- <footer> -->

    <footer id="footer">
    	<?php if(empty($_SESSION['loginStatus']) || $_SESSION['loginStatus'] == FALSE) { ?>
            <form method="post" action=".">
	            Admin: <input type="text" placeholder="User name" name="userName" size="10" required />
	            <input type="password" placeholder="Password" name="password" size="10" required />
	            <input type="submit" name="action" value="login" />
            </form>
            <?php } else { ?>
            <form action="." method="POST" enctype="multipart/form-data">
                <label>Pic:</label>
                <input type="file" name="file1">
                <label>Desc:</label>
                <input type="text" name="description">
                <input type="submit" name="action" value="Upload">
                <span> &nbsp;&nbsp;|&nbsp;&nbsp; </span>
                <input type="button" value="Logout" onclick="window.location.href='index.php?action=logout'" />
            </form>
           	<?php } ?>
    <!-- </div> -->
</footer>
</body>
</html>