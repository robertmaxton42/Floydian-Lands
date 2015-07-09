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
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
    <script type="text/javascript" src="chat.js"></script>
    <script type="text/javascript">
        $("document").ready(function(){

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
            $("#name-area").html("You are: <span id='username'>" + name + "</span>");

            //start chat
            var chat = new Chat();

            $(function() {

                chat.getState();

                // watch textarea for key presses
                // TODO 'someone is typing' alert, toggleable
                $("#sendie").keydown(function(event)  {

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
                $("#sendie").keyup(function(e) {

                    if (e.keyCode == 13) {

                        var text = $(this).val();
                        var maxLength = $(this).attr("maxlength");
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

            setInterval('chat.update()',1000);
        });
    </script>
</head>

<body>
    <div id="wrapper">
        <header>
            <nav>Test | Things | All | Go | Here</nav>
        </header>
        <div id="gargoyle"><img src="http://i.imgur.com/KPGUhid.jpg?1" /><br />
        All Things Must be Tested.</div>

        <div id="chat">
            <p id="name-area">Test</p>
            <div id="chat-area">Initial Text</div>
            <form id="send-message-area">
                <textarea id="sendie" maxlength='300'>Enter a message here.</textarea>
            </form>
        </div>
        <div id="command">We're not kidding here.</div>
    </div>
</body>
</html>