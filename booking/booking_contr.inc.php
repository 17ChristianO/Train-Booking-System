<?php
//handles information
//use of hierarchy chart and the mvc model in the design stage for sign up module
//to prevent lots of syntax errors
//include 'C:\xampp\htdocs\NEA\booking\index.php';
//require_once 'booking_model.inc.php';
//require_once 'booking.inc.php';

require_once 'booking_model.inc.php';

$startStation = $_POST["startStation"];
$destinationStation = $_POST["destinationStation"];
$startDate = $_POST["startDate"];
$startTime = $_POST["startTime"];
$returnDate = $_POST["returnDate"];
$returnTime = $_POST["returnTime"];
$numTickets = $_POST["numTickets"];

/*
function getGraph() {
    global $graph;
    return $graph;
}


function initialiseGraph($stations, $connections, $graph) {
    $graph = [];

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

    if (!is_array($stations) || !is_array($connections)) {
        echo "Error: Invalid input data.";
        return null;
    }

    
    foreach ($stations as $station) {
        $graph[$station] = [];
    }

    // add edges and their weights to the graph
    foreach ($connections as $connection) {
        //stationA and stationB are used to represent points on each side of the edge
        //the edges are added twice because the graph should be bidriectional
        $stationA = $connection[0];
        $stationB = $connection[1];
        $weight = $connection[2];

        //add edges if they don't already exist in the graph
        if (!isset($graph[$stationA][$stationB])) {
            $graph[$stationA][$stationB] = $weight;
            $graph[$stationB][$stationA] = $weight; //graph is undirected
        }
    }
    return $graph;
}*/

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

$graph = [];
$graph = getGraph();

$graph = initialiseGraph($stations, $connections, $graph);

/*
if (!function_exists('initialiseGraph')) {
    function dijkstra($graph, $startStation, $stations, $connections, $destinationStation) {
        //PHP_FLOAT_MAX sets $inf to the loargest float value php accepts
        $inf = PHP_FLOAT_MAX; //inf represents infinity or an unreachable value
        $graph = [];

        $graph = getGraph();

        $graph = initialiseGraph($stations, $connections, $graph);

        if (is_array($graph)) {
            $previousStation = array_fill_keys(array_keys($graph), null);
            //debugging output
            /*echo "Graph:";
            print_r($graph);
            echo "Previous:";
            print_r($previousStation);* /
            $distances = array_fill_keys(array_keys($graph), $inf);
            $previousStation = array_fill_keys(array_keys($graph), null);//sets the distance from the previous station to be null
            $visitedStations = []; //initialises an empty array called $visitedStations
                

            //PHP_FLOAT_MAX sets $inf to the loargest float value php accepts
            //$inf = PHP_FLOAT_MAX; //inf represents infinity or an unreachable value
        
                //using prebuit functions, array_fill_keys() and array_keys()
            //array_keys() is used to fetch an array that contains all the stations from the graph array
            //array_fill_keys() is used to create an array based on the stations in the $graph structure
            //sets the start distance between the stations to be infinite
            //$distances = array_fill_keys(array_keys($graph), $inf);
            //$previousStation = array_fill_keys(array_keys($graph), null);//sets the distance from the previous station to be null
            //$visitedStations = []; //initialises an empty array called $visitedStations
            $priorityQueue = new SplPriorityQueue(); //new queue to hold elements based on priority
        
            $distances[$startStation] = 0;
            $priorityQueue->insert($startStation, 0);
        
            while (!$priorityQueue->isEmpty()) { //loop if the priority queues is not empty
        
                //method to make the station that is the shortest distance from the start the current station
                $currentStation = $priorityQueue->extract();//dequeues first station in the queue
        
                if ($currentStation === $destinationStation) { //checks if current station is destination
                    $path = [];
        
                    //able to backtrack through $previousStation array until the array is empty
                    while ($previousStation[$currentStation] !== null) {  //while loop used to produce the shortest path because it will use backtracking
                        array_unshift($path, $currentStation); //appends current station to beginning of the array
                        $currentStation = $previousStation[$currentStation]; //changes $currentStation to previous station
                    }
                    array_unshift($path, $startStation); //$startStation is added to the beginning of the array
                    return $path;
                }
        
                if (!isset($visitedStations[$currentStation])) { //checks if the current node has not been visited
                    $visitedStations[$currentStation] = true; //if the current node has not been visited then change the current node to visited the go through currentStation
        
                    foreach ($graph[$currentStation] as $neighbour => $weight) {
                        $alt = $distances[$currentStation] + $weight; //calculates alternative routes
                        if ($alt < $distances[$neighbour]) { //compare $alt distant with the currently known distance
                            $distances[$neighbour] = $alt;  
                            $previousStation[$neighbour] = $currentStation; //backtracks to the previous neighbour
                            $priorityQueue->insert($neighbour, -$alt); //the smallest distance takes highest priority in the queue
                        }
                    }
                }
            }
            //return null;
        }
        //echo 'i hate nea';
        return null;
    }
}*/

if (!function_exists('dijkstra')) {
    function dijkstra($graph, $startStation, $stations, $connections, $destinationStation) {
        //PHP_FLOAT_MAX sets $inf to the loargest float value php accepts
        $inf = PHP_FLOAT_MAX; //inf represents infinity or an unreachable value
        $graph = [];
    
        $errors_booking = [];

        $graph = getGraph();
    
        $graph = initialiseGraph($stations, $connections, $graph);
    
        $startStation = $_POST["startStation"];
        $destinationStation = $_POST["destinationStation"];
    
        //sets all the distances on the graph to be infinite
        //distances in this scenario represent the cost
        $distances = array_fill_keys(array_keys($graph), $inf);

        //sets the distance from the previous station to be null
        $previousStation = array_fill_keys(array_keys($graph), null);
        $visitedStations = []; //initialises an empty array called $visitedStations
        //$previousStation = array_fill_keys(array_keys($graph), null);
        //debugging output
        /*echo "Graph:";
        print_r($graph);
        echo "Previous:";
        print_r($previousStation);*/
    
        $priorityQueue = new SplPriorityQueue(); //new queue to hold elements based on priority
    
        if ($priorityQueue === new SplPriorityQueue()) {
            //$errors_booking = [];
            $errors_booking["queue_issue2"] = "Queue Issue";   
        }

        //set start station distance to 0
        $distances[$startStation] = 0;
        //insert start station into priority queue
        $priorityQueue->insert($startStation, 0);
    
        //check queue is not empty
        if ($priorityQueue->isEmpty()) {
            //if it is empty then error displayed
            //$errors_booking = [];
            $errors_booking["queue_issue"] = "Error: Queue did not store start station";   
        }
    
        while (!$priorityQueue->isEmpty()) { //loop if the priority queues is not empty
    
            //method to make the station that is the shortest distance from the start the current station
            $currentStation = $priorityQueue->extract();//dequeues first station in the queue
            
            /*if ($currentStation !== $startStation) {
                echo 'Nodes are not fine';
                $errors_booking = [];
                $errors_booking[] = "Error: Nodes are not fine";   
                return $errors_booking;
            }*/
    
            if ($currentStation === $destinationStation) { //checks if current station is destination
                $path = [];
                if(is_array($path)){
                    //able to backtrack through $previousStation array until the array is empty
                    //while loop used to produce the shortest path because it will use backtracking
                    while ($previousStation[$currentStation] !== null) {  
                        array_unshift($path, $currentStation); //appends current station to beginning of the array
                        $currentStation = $previousStation[$currentStation]; //changes $currentStation to previous station
                        if ($path === []) {
                            $errors_booking[] = "Error: Current station is incorrectly held";
                        }
                        //return $path;
                    }
                    array_unshift($path, $startStation); //$startStation is added to the beginning of the array
                    return $path;
                }
            }
    
            if (!isset($visitedStations[$currentStation])) { //checks if the current node has not been visited

                //if the current node has not been visited then change the current node to visited the go through currentStation
                $visitedStations[$currentStation] = true; 
    
                foreach ($graph[$currentStation] as $neighbour => $weight) {
                    $alt = $distances[$currentStation] + $weight; //calculates alternative routes
                    if ($alt < $distances[$neighbour]) { //compare $alt distant with the currently known distance
                        $distances[$neighbour] = $alt;  
                        $previousStation[$neighbour] = $currentStation; //backtracks to the previous neighbour
                        $priorityQueue->insert($neighbour, -$alt); //the smallest distance takes highest priority in the queue
                    }
                }
            } 
            /*else {
                echo 'The current station has been visited before';
                $errors_booking = [];
                $errors_booking[] = "Error: The current station has been visited before"; } */
            ;   
        };
    }
} else {
    $errors_booking = [];
    $errors_booking[] = "Error: Dijkstra has been called before";
}



if (!function_exists('displayPath')) {
    function displayPath($path, $graph, $stations, $connections) {
        if (empty($path)) {
            $errors_booking["no_service"] = "There is no service line that visits both these stations, check the map and try again.";
        } else {
            $totalWeight = 0; //variable to store the total weight

            $graph = initialiseGraph($stations, $connections, $graph);

            //iterate over the path and display each station along with its weight
            for ($i = 0; $i < count($path) - 1; $i++) {
                $currentStation = $path[$i];
                $nextStation = $path[$i + 1];
                
                // get the weight between the current and next stations
                $weight = $graph[$currentStation][$nextStation];

                // Display the station and its weight
                echo $currentStation . ' (£' . $weight . ') -> ';

                // Accumulate the weight to calculate the total weight
                $totalWeight += $weight;
            }

            // Display the last station in the path
            echo end($path);
            //echo 'path empty if end of path is not displayed';

            // Display the total price of the path
            echo "<br>Total Cost (INCLUDING £2 SERVICE FEE):£ " . $totalWeight + 2 ;
        }
        return $totalWeight;
    }
}

if (!function_exists('check_null')) {
    function check_null($startStation, $destinationStation, $startDate, $startTime, $returnDate, $returnTime, $numTickets) {

        $errors_booking = [];

        if (empty($startStation) || empty($destinationStation) || empty($startDate) || empty($startTime) || empty($numTickets)) {
            $errors_booking[] = "All  fields are required to proceed with the booking";
        }

        return $errors_booking;
    }
}

if (!function_exists('validateStartDate')) {
    function validateStartDate($startDate) {
        $currentDate = date("Y-m-d");
        $errors_booking = [];

        if ($startDate < $currentDate) {
            $errors_booking[] = "Start date cannot be before the current date, please try again";
        }

        return $errors_booking;
    }
}

if (!function_exists('stations_different')) {
    function stations_different(string $startStation, string $destinationStation){
    return $startStation !== $destinationStation;
    }   
}
 