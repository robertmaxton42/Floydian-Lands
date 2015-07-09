/* 
Created by: Kenrick Beckett
Edited by: Robert Maxton (linkhyrule5)
Name: Chat Engine
*/

var instanse = false;
var state;
var mes;
var file;

function Chat () {
    this.update = updateChat;
    this.send = sendChat;
    this.getState = getStateOfChat;
}

/*Gets the state of the chat.
**Asks the server for the number of lines in the remote chat log.*/
function getStateOfChat(){
    if(!instanse){
         instanse = true;
         $.ajax({
               type: "POST",
               url: "process.php",
               data: {  
                        'function': 'getState',
                        'file': file
                        },
               dataType: "json",
            
               success: function(data){
                   state = data.state;
                   instanse = false;
               },
            });
    }    
}

//Updates the chat
function updateChat(){
     if(!instanse){
         instanse = true;
         $.ajax({
               type: "POST",
               url: "process.php",
               data: {  
                        'function': 'update',
                        'state': state,
                        'file': file
                        },
               dataType: "json",
               success: function(data){
                   if(data.text){
                        for (var i = 0; i < data.text.length; i++) {
                            $('#chat-area').append($("<p>"+ data.text[i] +"</p>"));
                        }                                 
                   }
                   document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
                   instanse = false;
                   state = data.state;
               },
            });
     }
     else {
         setTimeout(updateChat, 1500);
     }
}

//send the message
function sendChat(message, nickname)
{       
    updateChat();
     $.ajax({
           type: "POST",
           url: "process.php",
           data: {  
                    'function': 'send',
                    'message': message,
                    'nickname': nickname,
                    'file': file
                 },
           dataType: "json",
           success: function(data){
               updateChat();
           },
        });
}
