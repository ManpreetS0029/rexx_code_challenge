<?php

require_once "db/db_connection.php";

// convert json to array
$events = json_decode(file_get_contents("data_source/events.json"), true);

try {

    foreach ($events as $event) {

        $event_name = $event["event_name"];

        $duplicate = $conn->prepare("SELECT * FROM events WHERE event_name = '$event_name'");

        $duplicate->execute();

        if ($duplicate->rowCount() == 0) {
            // sql query to insert the data to the events table
            $query1 = $conn->prepare("INSERT INTO events (event_name) VALUES(:event_name)");

            $query1->bindParam(":event_name", $event_name);

            // query will be executed
            $query1->execute();
        }

        // sql query to insert the data to participants table
        $query2 = $conn->prepare("INSERT INTO participants (employee_name, employee_mail, event_id, participation_fee, event_date, version) VALUES(:employee_name, :employee_mail, :event_id, :participation_fee, :event_date, :version)");

        $query2->bindParam(":employee_name", $event["employee_name"]);
        $query2->bindParam(":employee_mail", $event["employee_mail"]);
        $query2->bindParam(":event_id", $event["event_id"]);
        $query2->bindParam(":participation_fee", $event["participation_fee"]);
        $query2->bindParam(":event_date", $event["event_date"]);
        $query2->bindParam(":version", $event["version"]);

        // query will be executed
        $query2->execute();
    }

    echo "Data inserted successfully";
} catch (Exception $e) {
    echo $e->getMessage();
}
