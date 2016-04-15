<html lang = "en">

    <head>
        <title>Handyman Tool</title>
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    </head>


    <body>
        <h2>Make Reservation</h2>
        <?php
            session_start();
            include('dbconn.php');
            global $conn;
            if (empty($_SESSION['login_user'])) {
                die("You are not login yet!");
            }
            if (isset($_POST['calculate'])) {
                if (!isset($_SESSION['tool_list']) || empty($_SESSION['tool_list'])) {
                    echo '&nbsp&nbsp<span style="color:#FF0000;text-align:center;">Please add at least one tool to your list!</span>';
                } else {
                    echo "<script> window.location.assign('summary.php'); </script>";                    
                }
            }
            if (isset($_POST['logout'])) {
                session_destroy();
                echo "<script> window.location.assign('index.php'); </script>";
            }
        ?>

        <div class = "container">
            <form class = "form-signin" role = "form" method = "post">
                <p>
                Starting Date&nbsp<input type = "text" class = "form-control" placeholder="YYYY-MM-DD"
                   name = "startdate" id="startdate"  autofocus>
                </p>
                <p>
                Ending Date&nbsp&nbsp<input type = "text" class = "form-control" placeholder="YYYY-MM-DD"
                   name = "startdate" id="enddate" >
                </p>
                <p>&nbsp</p>
                <p>
                Type of Tool
                </p>
                <select id="one" name="tooltype">
                  <option value="">Please select</option>
                  <option value="hand">Hand Tools</option>
                  <option value="construction">Construction Equipment</option>
                  <option value="power">Power Tools</option>
                </select>
            </form>
        </div>
        <div id = "menu2">
            <p>Tool</p>
            <p><select>
            </select>
            </p>
        </div>

        <div>
            <form class = "form-signin" role = "form" action = "" method = "post">
                <p>
                <button class = "btn btn-lg btn-primary btn-block" type = "button" id = "add" name = "add">Add More Tools</button>
                <button class = "btn btn-lg btn-primary btn-block" type = "button" id = "remove" name = "remove">Remove Last Tool</button>
                </p>
                <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "calculate">Calculate Total</button>
                <p>
                <hr>
                <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button>
                </p>
            </form>
        </div>

        <script>
            $(document).ready(function() {
                $("select#one").change(function() {
                    $("div#menu2").load("second_menu.php?tooltype=" + $(this).val() + "&startdate=" + $("input#startdate").val() + "&enddate=" + $("input#enddate").val());
                });

                $("button#add").click(function(){
                    var id = $('div#menu2').find('option:selected').val();
                    var abbr = $('div#menu2').find('option:selected').attr('abbr');
                    $.ajax({
                        type : 'GET',
                        url  : 'toollist.php',
                        data : {tool_id : id, abbr : abbr},
                        success: function(data) {
                            alert("Tool part # " + id + " " + abbr + ": has been added to your list");
                        }
                    });
                });

                $("button#remove").click(function(){
                    $.ajax({
                        type : 'GET',
                        url  : 'toollist.php',
                        data : {remove : 1},
                        success: function(data) {
                            alert("The last tool has been removed from your list");
                        }
                    });
                });
            });
        </script>
   </body>
</html>