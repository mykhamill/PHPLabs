<?php
    //Set sender, headers & subject
    $sender = "them@example.com";
    $headers  = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
    $headers .= "From: Data Sender <$sender>" . "\r\n";
    $subject = "Data Sender";
    
    //Load data and message template
    $datafile = "data.txt";
    $datafileContents = file_get_contents($datafile);
    $messageTemplateFile = "message_template.txt";
    $messageTemplateContents = file_get_contents($messageTemplateFile);
    
    //Split data by lines into an array
    $expDatafileContents = explode("\n", $datafileContents);
    
    //Loop over each line of the array
    foreach ($expDatafileContents as $line) {
            if (strlen($line) > 0) { // only process if the line has data in it
                    $expl = explode(", ", $line); //Split the line by comma + space
                    $email = $expl[0]; //Set the email to the first element in the row
                    $data = array_slice($expl, 1); //Group the rest of the elements into an array
                    //print_r($scores)."<br>"; 
                    $message = $messageTemplateContents; //Copy the message template
                    for ($j = 0; $j < sizeof($data); $j++) { //Loop over the data elements 
                        $search = "{".($j + 1)."}"; //Set the search
                        $replace = $data[$j]; //Set the replace
                        //Replace the place holder in the message template
                        $message = str_replace($search, $replace, $message); 
                    }
                    $message = wordwrap($message, 70); //Word wrap lines at seventy characters
                    
                    //Using the sendmail process through the mail function
                    //set the email, subject, message, and headers 
                    $mail = mail($email, $subject, $message, $headers);
                    if ($mail) {
                        echo "Mail sent to ".$email."<br>"; //Confirmation that mail completed successfully
                                                     //!!Does not gaurantee that the email will arrive!!
                    }
            }
    };
    
?>
