<?php
//for functions that will interact and query with the database
//use of hierarchy chart and the mvc model in the design stage for sign up module
//to prevent lots of syntax errors


//london's busiest underground stations defined as nodes
//array of the Londons Underground's most popular stations
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

// weighted undirected graph using an adjacency list representation
// Initialize graph with empty arrays for each station
// associative array where the keys represent stations and the values represent an array of neighboring stations with their respective weights
if (!function_exists('getGraph')) {
    function getGraph() {
        global $graph;
        return $graph;
    }
} else {
    $errors_booking = [];
    $errors_booking[] = 'Get graph is broken'; 
}

if (!function_exists('initialiseGraph')) {
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
            echo "Error: Stations are experiencing issues.";
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
    }
} else {
    $errors_booking = [];
    $errors_booking[] = 'Initialise graph is broken'; 
}

//$graph = initialiseGraph($stations, $connections, $graph);

//check if $graph is an array before using it
/*if (is_array($graph)) {
    $previous = array_fill_keys(array_keys($graph), null);
    //debugging output
    echo "Graph:";
    print_r($graph);
    echo "Previous:";
    print_r($previous);

    $path = dijkstra($graph, $startStation, $destinationStation, $stations, $connections, $endstation);

    if (is_array($path)) {
        displayPath($path, $graph, $stations, $connections);
    } else {
        echo "Error: Unable to calculate the path.";
    }

} else {
    echo "Error: Unable to retrieve the graph data.";
}*/


/*function fetch_user(object $pdo, string $username)
{
    //use pseudocode reference from design to query the database
    $query = "SELECT * FROM users WHERE username = :username";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":username", $username);
    $statement->execute();

    //refer to data from the field
    //$result is boolean so this function can only return true or false
    $result = $statement->fetch(PDO::FETCH_ASSOC); 
    return $result;
} */

function fetch_user(object $pdo, string $username)
{
    $query = "SELECT * FROM users WHERE username = :username";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":username", $username);

    try {
        $statement->execute();
        $result_booking = $statement->fetch(PDO::FETCH_ASSOC);
        return $result_booking;
    } catch (PDOException $e) {
        // Handle the error, log it, or display a user-friendly message
        echo "Error fetching user: " . $e->getMessage();
        return false;
    }
}