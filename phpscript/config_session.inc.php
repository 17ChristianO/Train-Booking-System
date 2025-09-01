<?php

ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

//used a built in PHP function called session_set_cookie_params to set  session cookie parameters in this PHP system
session_set_cookie_params([
    'lifetime' => 1800, //cookie lifetime in seconds
    'path' => '/', //the cookie should function for everypath in this domain
    'domain' => 'localhost', //cookie will work on all paths from localhost domain
    'secure' => true, //indicates that the cookie should only be sent over secure connections (such as HTTPS)
    'httponly' => true, //indicates the cookie is only accessible through the HTTP protocol
]);

session_start();

regenerate_session_id();

//check if there is already a session going on
if(isset($_SESSION["user_id"])){

} else {
        //session security to stop attackers form gaining access to cookies for long periods of time
    if (!isset($_SESSION["last_regeneration"])) {
        //fetch the session
        regenerate_session_id_loggedin();
    } else{
        //time in seconds until session id next updated, number of seconds multiplied by number of desired minutes
        $interval = 60 * 30;
        // 
        if (time() - $_SESSION["last_regeneration"] >= $interval) {
            regenerate_session_id_loggedin();
        }

}
}

/*if (session_start() === false) {
    // Handle the error
    echo "Error starting the session.";
    exit();
}*/

//regenerate a new id with userid and session id joint
function regenerate_session_id_loggedin() {
    //use of php prebuilt operation  to regenerate the id
    session_regenerate_id(true);
        //fetches userId from the $_SESSION variable
        $userId = $_SESSION["user_id"];
        //new session when something changes to improve security
        //used to create completely new session id
        $newsessionId = session_create_id();
        //pair together the user id and the session id
        $sessionId = $newsessionId . "_" . $userId;
        //set the new session id
        session_id($sessionId);

    $_SESSION["last_regeneration"] = time(); //Get timestamp for when each session is last generated
}

function regenerate_session_id() {
    if (!isset($_SESSION["last_regeneration"])) {
        session_regenerate_id(true);
    } else {
        $interval = 60 * 30; // 30 minutes
        if (time() - $_SESSION["last_regeneration"] >= $interval) {
    //use of php prebuilt operation 
    session_regenerate_id(true);
        }
    }
    $_SESSION["last_regeneration"] = time(); //Get timestamp for when each session is last generated
}
?>