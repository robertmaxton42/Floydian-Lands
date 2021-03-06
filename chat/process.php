<?php

    $function = $_POST['function'];
    $ctype = $_POST['type'];
    $fname = ($ctype == 0) ? 'cmdlog.txt' : 'chatlog.txt';

    $log = array();
    switch ($function) {


        #Evaluate updateChat()
        case('update'): 
            $state = $_POST['state'];
           
            if (file_exists($fname)) {
                $lines = file($fname);
            }
            $count = count($lines);
            if ($state == $count) {
                #No change since last update.
                #Return no text.
                $log['state'] = $state;
                $log['text'] = false;
            } else {
                #New text. Feed it to the POST.
                $text = array();
                $log['state'] = $state + count($lines) - $state; #Return updated line count in passed datatype.
                foreach ($lines as $line_num => $line) {
                    #Jump to the end of the passed local log and start reading lines.
                    if ($line_num >= $state) {
                        $text[] =  $line = str_replace("\n", "", $line);
                        #Sanitization.
                        #TODO Sanitize more thoroughly.
                        #TODO Handle exotic characters?
                    }
                }
                $log['text'] = $text;
            }
            break;

        #Evaluate sendChat()
        case('send'):
            $nickname = htmlentities(strip_tags($_POST['nickname']));
            #TODO Handle colors, bold, italics.
            #TODO Handle server commands - /nick, /whois
            #TODO Split based on chat type - commands should not accept hypertext
            $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
            $message = htmlentities(strip_tags($_POST['message']));
            if (($message) != "\n") {

                if (preg_match($reg_exUrl, $message, $url)) {
                    $message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>' , $message);
                }   

                
                fwrite(fopen($fname, 'a'), "<span class='usernames'>". $nickname . "</span>" . $message = str_replace("\n", " ", $message) . "\n");
            }
           break;

        default:
            trigger_error("Error WTF: Impossible request, check Kaguya's nightstand.");
            break;
    }
    echo json_encode($log);

?>