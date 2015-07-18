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
    <script type="text/javascript" src="chat/chat.js"></script>
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

            //display name on page (Unused)
            $("#name-area").html("You are: <span id='username'>" + name + "</span>");

            //start chat
            var chatlogid = "chatlog"
            var chat = new Chat(TypeEnum.CHAT, chatlogid);

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

            setInterval(chat.update, 1000, 1, chatlogid);
        });
    </script>
</head>

<body>
    <div id="wrapper">
        <header>
            <nav>Test | Things | All | Go | Here</nav>
        </header>
        <div id="chat">
            <!--<p id="name-area"></p>-->
            <div id="chatlog"></div>
            <form id="chat-send-area">
                <textarea id="sendbox" maxlength='300'>Enter a message here.</textarea>
            </form>
        </div>
        <div id="leftpane">
            <div id="gargoyle"><img src="http://i.imgur.com/KPGUhid.jpg?1" /></div>
            
            <div id="command">
                <div id="cmdlog"></div>
                <form id="cmd-send-area">
                    <b>&gt;</b><textarea id="cmdbox" maxlength='300'></textarea>
                </form>
            </div>
        </div>
    </div>
</body>
</html>