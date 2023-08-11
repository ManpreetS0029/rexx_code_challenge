<?php

require_once "db/db_connection.php";

// convert json to array
$events = json_decode(file_get_contents("events.json"), true);

try {

    foreach ($events as $event) {
        // sql query to insert the data to the table
        $query = $conn->prepare("INSERT INTO events (employee_name, employee_mail, event_id, event_name, participation_fee, event_date, timezone_version) VALUES(:employee_name, :employee_mail, :event_id, :event_name, :participation_fee, :event_date, :timezone_version)");

        $query->bindParam(":employee_name", $event["employee_name"]);
        $query->bindParam(":employee_mail", $event["employee_mail"]);
        $query->bindParam(":event_id", $event["event_id"]);
        $query->bindParam(":event_name", $event["event_name"]);
        $query->bindParam(":participation_fee", $event["participation_fee"]);
        $query->bindParam(":event_date", $event["event_date"]);
        $query->bindParam(":timezone_version", $event["version"]);

        // query will be executed
        $query->execute();
    }

    echo "Data inserted successfully";
} catch (Exception $e) {
    echo $e->getMessage();
}
