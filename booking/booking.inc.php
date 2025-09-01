<?php
//using as a central file for booking so its easier to maintain and more modular
//file to handle the dorm submission
//require_once 'index.php';
//include 'booking_model.inc.php';
//include_once 'C:\xampp\htdocs\NEA\phpscript\dbh.inc.php';
//include 'C:\xampp\htdocs\NEA\phpscript\config_session.inc.php';
//require_once 'index.php';

/*$startStation = $_POST["startStation"];
$destinationStation = $_POST["destinationStation"];
$startDate = $_POST["startDate"];
$startTime = $_POST["startTime"];
$returnDate = $_POST["returnDate"];
$returnTime = $_POST["returnTime"];
$numTickets = $_POST["numTickets"]; */

$sessionStatus = session_status();

if ($sessionStatus === PHP_SESSION_ACTIVE) {
} else {
    session_start();
}

$stations = [
    'Baker Street',  //BS-
    'Bank/Monument', //BM-
    'Bond Street', //BS2-
    'Camden Town', //CT-
    'Canada Water', //CW-
    'Canary Warf', //CW2-
    'Canning Town', //CT2-
    'Euston Square', // ES-
    'Farringdon', //F-
    'Green Park', //GP-
    'King\'s Cross St.Pancras', // KCSP-
    'Liverpool Street', //LS-
    'London Bridge', //LB-
    'Moorgate', //M-
    'Oxford Circus', //OC-
    'Paddington', //P-
    'South Kensington', //SK-
    'Stratford', //S-
    'Victoria', //V-
    'Waterloo', //W
    'Westminister', //W2
    'Whitechapel' //W3
];

// array to define connections and their weights between stations
//edges only need to be defined once because graph is bidirectional
$connections = [
    ['Baker Street', 'Moorgate', 3],
    ['Baker Street', 'Paddington', 2],
    ['Moorgate', 'Oxford Circus', 1.4],
    ['Moorgate', 'Westminster', 2],
    ['Bank/Monument', 'Canada Water', 1.3],
    ['Bank/Monument', 'Oxford Circus', 0.4],
    ['Bank/Monument', 'Canary Warf', 2.7],
    ['Canada Water', 'London Bridge', 0.4],
    ['London Bridge', 'Canary Warf', 3],
    ['London Bridge', 'Victoria', 2],
    ['Victoria', 'Whitechapel', 2.1],
    ['Canary Warf', 'Liverpool Street', 2.4],
    ['Canary Warf', 'Farringdon', 2],
    ['Canary Warf', 'King\'s Cross St.Pancras', 2],
    ['Liverpool Street', 'Euston Square', 1.4],
    ['Farringdon', 'Euston Square', 2.3],
    ['King\'s Cross St.Pancras', 'Euston Square', 1.3],
    ['King\'s Cross St.Pancras', 'Oxford Circus', 3],
    ['Euston Square', 'Camden Town', 0.6],
    ['Camden Town', 'Oxford Circus', 2.1],
    ['Camden Town', 'Green Park', 0.7],
    ['Green Park', 'Waterloo', 0.2],
    ['Green Park', 'Canning Town', 1.2],
    ['Canning Town', 'Bond Street', 1.8],
    ['Bond Street', 'Oxford Circus', 2],
    ['Oxford Circus', 'South Kensington', 1.3],
    ['South Kensington', 'Stratford', 3]
];

$errors_booking = [];

//check the user got here by submitting the booking form
if(isset($_POST["startStation"], $_POST["destinationStation"], $_POST["startDate"], $_POST["startTime"], $_POST["numTickets"])) {
    $startStation = $_POST["startStation"];
    $destinationStation = $_POST["destinationStation"];
    $startDate = $_POST["startDate"];
    $startTime = $_POST["startTime"];
    $returnDate = $_POST["returnDate"];
    $returnTime = $_POST["returnTime"];
    $numTickets = $_POST["numTickets"];

    try {
        require_once 'booking_contr.inc.php';
        require_once 'booking_model.inc.php';

        //form submission handling
        $startStation = $_POST["startStation"];
        $destinationStation = $_POST["destinationStation"];
        $startDate = $_POST["startDate"];
        $startTime = $_POST["startTime"];
        $returnDate = $_POST["returnDate"];
        $returnTime = $_POST["returnTime"];
        $numTickets = $_POST["numTickets"];
    
        //validate start and destination stations

        $errors_booking = check_null($startStation, $destinationStation, $startDate, $startTime, $returnDate, $returnTime, $numTickets);
        $errors_booking = array_merge($errors_booking, validateStartDate($startDate));

        if (!is_numeric($numTickets) || $numTickets < 0) {
            //handle the case where the ticket number is negative or not a valid number
            $errors_booking[] = "Invalid number of tickets, please enter a non-negative amount of tickets";
        }
    
        //fetch the graph data from the booking model
        $graph = getGraph(); //fetch graph using fucntion from control file
    
        $graph = initialiseGraph($stations, $connections, $graph);
    
        if (!stations_different($startStation, $destinationStation)) {

            // Stations are the same
            $errors_booking[] = "Start and destination stations cannot be the same, please try again";
        }

        if (!empty($errors_booking)) {
            // handle errors here and display them to the user
            /*foreach ($errors_booking as $error) {
                echo $error . "<br>";
            }*/
            $_SESSION['errors_booking'] = $errors_booking;
            echo '<meta http-equiv="refresh" content="0;url=http://localhost/NEA/booking/index.php">';
            die();
        } else {
             //calculate the path using Dijkstra's algorithm
    
             $path = dijkstra($graph, $startStation, $destinationStation,  $stations, $connections, $destinationStation);
    
             // display the path
             
             displayPath($path, $graph, $stations, $connections);
     
             //if dijkstra worked the path not null
             if ($path === null) {
                 $errors_booking["broken_path"] = "Error: Unable to calculate the route.";
                 $_SESSION['errors_booking'] = $errors_booking;
                 echo '<meta http-equiv="refresh" content="0;url=http://localhost/NEA/booking/index.php">';
                 die();
             } else {
                //dijkstra worked
                 $totalWeight = displayPath($path, $graph, $stations, $connections);
                 // store ticket information in session
                 $_SESSION['ticketInformation'] = [
                     'startStation' => $startStation,
                     'destinationStation' => $destinationStation,
                     'startDate' => $startDate,
                     'startTime' => $startTime,
                     'returnDate' => $returnDate,
                     'returnTime' => $returnTime,
                     'numTickets' => $numTickets,
                 ];
                }
            $totalWeight = displayPath($path, $graph, $stations, $connections);
            $_SESSION['totalWeight'] = $totalWeight;
            $_SESSION['ticketInformation'] = [
                'startStation' => $startStation,
                'destinationStation' => $destinationStation,
                'startDate' => $startDate,
                'startTime' => $startTime,
                'returnDate' => $returnDate,
                'returnTime' => $returnTime,
                'numTickets' => $numTickets,
            ];
            echo '<meta http-equiv="refresh" content="0;url=http://localhost/NEA/booking/tickets.php">';
            //header("Location: http://localhost/NEA/booking/tickets.php");
            exit;
        }
        
    } catch (PDOException $e) {
        $errors_booking[] = "Error: " . $e->getMessage();
        $_SESSION['errors_booking'] = $errors_booking;
        echo '<meta http-equiv="refresh" content="0;url=http://localhost/NEA/booking/index.php">';
        die();
    }
} else {
    $errors_booking[] = "Please fill in all the required fields to continue";
    $_SESSION['errors_booking'] = $errors_booking;
    echo '<meta http-equiv="refresh" content="0;url=http://localhost/NEA/booking/index.php">';
    die();
}
//check if the necessary POST data is set and all values have ben retrieved
/*if(isset($_POST["startStation"], $_POST["destinationStation"], $_POST["startDate"], $_POST["startTime"], $_POST["numTickets"])) {

    //form submission handling
    $startStation = $_POST["startStation"];
    $destinationStation = $_POST["destinationStation"];
    $startDate = $_POST["startDate"];
    $startTime = $_POST["startTime"];
    $returnDate = $_POST["returnDate"];
    $returnTime = $_POST["returnTime"];
    $numTickets = $_POST["numTickets"];

    //validate start and destination stations
    $errors_booking = check_null($startStation, $destinationStation, $startDate, $startTime, $returnDate, $returnTime, $numTickets);
    $errors_booking = array_merge($errors_booking, validateStartDate($startDate));


    //fetch the graph data from the booking model
    $graph = getGraph(); //fetch graph using fucntion from control file

    $graph = initialiseGraph($stations, $connections, $graph);

    if (stations_different($startStation, $destinationStation)) {

        //callculate the path using Dijkstra's algorithm

        $path = dijkstra($graph, $startStation, $destinationStation,  $stations, $connections, $destinationStation);

        // display the path
        
        displayPath($path, $graph, $stations, $connections);

        if ($path === null) {
            echo "Error: Unable to calculate the route.";
        } else {
            displayPath($path, $graph, $stations, $connections);
            echo '<meta http-equiv="refresh" content="0;url=http://localhost/NEA/booking/tickets.php">';
            //header("Location: http://localhost/NEA/booking/tickets.php");
            exit;
        }

    } else {
        // Stations are the same
        $errors_booking[] = "Start and destination stations cannot be the same, please try again";
    }

    if (!empty($errors_booking)) {
        // handle errors here and display them to the user
        foreach ($errors_booking as $error) {
            echo $error . "<br>";
        }
    }
} else {
    echo "Please fill in all the required fields to continue";
}

if (!function_exists('validate_booking_form')) {
    function validate_booking_form($startStation, $destinationStation, $startDate, $startTime, $returnDate, $returnTime, $numTickets) {
        $errors_booking = [];

        //check inputs are not null
        $null_inputs = check_null($startStation, $destinationStation, $startDate, $startTime, $returnDate, $returnTime, $numTickets);
        $errors_booking = array_merge($errors_booking, $null_inputs);

        //check that the start station and destination station are different
        if (!stations_different($startStation, $destinationStation)) {
            $errors_booking[] = "Start and destination stations must be different.";
        }

        //to check start date is not before the current date
        $startDateErrors = validateStartDate($startDate);
        $errors_booking = array_merge($errors_booking, $startDateErrors);

        if (!is_numeric($numTickets) || $numTickets < 0) {
            //handle the case where the ticket number is negative or not a valid number
            echo "Invalid number of tickets, please enter a non-negative amount of tickets";
        }
        return $errors_booking;
    }  
}    */

//hereeeeee

/*
//to check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //form submission handling
    $startStation = $_POST["startStation"];
    $destinationStation = $_POST["destinationStation"];
    $startDate = $_POST["startDate"];
    $startTime = $_POST["startTime"];
    $returnDate = $_POST["returnDate"];
    $returnTime = $_POST["returnTime"];
    $numTickets = $_POST["numTickets"];

    //array to hold booking data
    //$bookingData = [
    //'startStation' => $_POST['startStation'],
    //'destinationStation' => $_POST['destinationStation'],
    //'startDate' => $_POST['startDate'],
    //'startTime' => $_POST['startTime'],
    //'returnDate' => $_POST['returnDate'],
    //'returnTime' => $_POST['returnTime'],
    //'numTickets' => $_POST['numTickets'],
    //];

    //validate inputs


    $errors_booking = validate_booking_form($startStation, $destinationStation, $startDate, $startTime, $returnDate, $returnTime, $numTickets);

    $graph = getGraph();

    $graph = initialiseGraph($stations, $connections, $graph);


    // Ensure $graph is an array before using it
    if (is_array($graph)) {
        $previous = array_fill_keys(array_keys($graph), null);
        //debugging output
        echo "Graph:";
        print_r($graph);
        echo "Previous:";
        print_r($previous);
        $path = dijkstra($graph, $startStation, $destinationStation,  $stations, $connections);

        //check if dijkstra returned a valid result
        if ($path === null) {
            echo "Error: Unable to calculate the route.";
        } else {
            displayPath($path, $graph, $stations, $connections);
            header("Location: http://localhost/NEA/booking/tickets.php");
            exit;
        }
    } else {
        echo "Error: Unable to retrieve the graph data.";
    }
}
/*function comment (){

    
    //check if there were any errors if not display path
    if (!empty($errors_booking)) {
        /* display validation errors
        $_SESSION['bookingData'] = $bookingData; //passes booking data into tickets.php
        header("Location: http://localhost/NEA/booking/tickets.php");
        exit;

        $graph = getGraph();
        $path = dijkstra($graph, $startStation, $destinationStation,  $stations, $connections, $endstation);
        displayPath($path, $graph, $stations, $connections);

        exit;

    } else {
        // Display errors
        foreach ($errors_booking as $errors_booking) {
            echo "Error: $errors_booking<br>";
        }

        //$path = dijkstra($graph, $startStation, $destinationStation);

        // display the path
        displayPath($path, $graph, $stations, $connections);

    }

    if ($path === null) {
        echo "Error: Unable to calculate the path.";
    } else {

        header("Location: http://localhost/NEA/booking/tickets.php");
        exit;
    }
    




    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        //perform validation
        $validationResult = validate_booking_form($startStation, $destinationStation, $startDate, $startTime, $returnDate, $returnTime, $numTickets);

        // Check if there are validation errors
        if ($validationResult !== null) {
            //display the validation error 
            echo $validationResult;
        } else {
            header("Location: http://localhost/NEA/booking/tickets.php");
            exit; 
        }
    }
    //$_SESSION['bookingData'] = $bookingData; //passes booking data into tickets.php
    header("Location: http://localhost/NEA/booking/tickets.php"); */

?>