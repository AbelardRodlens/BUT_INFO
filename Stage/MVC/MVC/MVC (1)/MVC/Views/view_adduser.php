<?php require "view_begin_html.php" ?>
    <title>addUser</title>
  
</head>
<body>
    <div id="adduser_body">

        
        <div id="adduser-div">
            <form action="index.php?controller=adduser&action=adduser" method="post">
                <input type="text" name="username" id="username" placeholder="Username">
                <input type="email" name="adress" id="adress" placeholder="Adress">
                
                <div id="droit">
                    <p id="role">Role:</p>
                    <input type="radio" name="role" id="admin" class="radio" value="non">
                    <label for="admin">Admin:</label>
                    <input type="radio" name="role" id="client" class="radio" value="oui">
                    <label for="client">Client:</label>
                </div>

                <input type="submit" name="submit" id="submit" value="ajouter">

            </form>
            
        </div>

    </div>
</body>
</html>
<?php require "view_end_html.php" ?>