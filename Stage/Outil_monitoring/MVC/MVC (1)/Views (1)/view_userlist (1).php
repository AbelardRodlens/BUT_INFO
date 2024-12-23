<?php require "view_begin_html.php" ?>
    <title>Userlist</title>
  
</head>
<body>
    <div id=userlist-body>
        <div id ="userinfos">
            
            <form action="index.php?controller=userlist&action=modifyuser" id="modify_user_form" method="post">
                <p id='croix'>&#x274C;</p>
                <input type="hidden" name="oldusername" id="oldusername-userlist" value="">
                <input type="text" name="newusername" id="newusername-userlist" value="" placeholder="">
                <input type="hidden" name="oldadress"   id="oldadress-userlist" value="" placeholder="">
                <input type="text" name="newadress"   id="newadress-userlist" value="" placeholder="">
                <input type="submit" name="submit" valeur="modifier" id="submit_test" onclick="">
                <div id="message"></div>
            </form>
        </div>
    </div>
    <?php $tab=json_encode($data);?>
<?php require "view_end_html.php" ?>