<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <title>Floydian Lands - IF Forever Wandering</title>
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js">
    </script>
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <style>
        body {font-family: Verdana, sans-serif; font-size:0.8em;}
        header,nav, section,article,footer
        {border:1px solid grey; margin:5px; padding:8px;}
        nav ul {margin:0; padding:0;}
        nav ul li {display:inline; margin:5px;}
    </style>

    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
    <script type="text/javascript" src="chat/chat.js"></script>
    <script type="text/javascript">

        //ask user for name with popup prompt
        var name = prompt("Enter your chat name:", "Guest");

        //default name is 'Guest'
        //TODO random unique username generation
        if (!name || name === ' ') {
            name = "Guest";
        }

        //strip tags
        name = name.replace(/(<([^>]+)>)/ig,"");

        //display name on page
        $("$username").html("You are: <span id='username>" + name + "</span>");

        //start chat
        var chat = new Chat();

        $(function() {

            chat.getState();

            // watch textarea for key presses
            // TODO 'someone is typing' alert, toggleable
            $("#sendbox").keydown(function(event)  {

                var key = event.which;

                //all keys including return.
                if (key >= 33) {

                    var maxLength = $(this).attr("maxlength");
                    var length = this.value.length;

                    //don't allow new content if length is maxed out
                    if (length >= maxLength) {
                        event.preventDefault();
                    }
                }
            });

                //watch textarea for key release
            $("#sendbox").keyup(function(e) {

                if (e.keyCode == 13) {

                    var text = $(this).val();
                    var maxlength = $(this).attr("maxlength");
                    var length = text.length;

                    // send
                    if (length <= maxLength + 1) {
                        chat.send(text, name);
                        $(this).val("");
                    } else {
                        $(this).val(text.substring(0, maxLength));
                    }
                }
            });
        });
    </script>
</head>

<body onload="setInterval('chat.update()',1000)">
    <div id="wrapper">
        <header>
            <nav>Test | Things | All | Go | Here</nav>
        </header>
        <div id="gargoyle"><img src="http://i.imgur.com/KPGUhid.jpg?1" /><br />
        All Things Must be Tested.</div>

        <div id="chat">
            <p id="username"></p>
            <div id="chatlog">Initial Text</div>
            <form id="message-send">
                <textarea id="sendbox" maxlength='300'>Enter a message here.</textarea>
            </form>
        </div>
        <div id="command">We're not kidding here.</div>
    </div>
</body>
</html>