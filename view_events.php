<?php

require_once "db/db_connection.php";

$query = $conn->prepare("SELECT * FROM events");

$query->execute();

$events = $query->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Challenge</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div>

        <div>
            <h1>Events</h1>
        </div>

        <div>
            <div>
                <h3>Filters</h3>
            </div>

            <div class="filters">

                <div>
                    <div>
                        <label for="employee_name">Employee Name</label>
                        <input type="text" name="employee_name" id="employee_name">

                        <label for="event_name">Event Name</label>
                        <input type="text" name="event_name" id="event_name">

                        <label for="event_date">Date</label>
                        <input type="date" name="event_date" id="event_date">
                    </div>
                </div>

            </div>

        </div>

        <div class="datatable">
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Employee Name</th>
                        <th>Employee Email</th>
                        <th>Event ID</th>
                        <th>Event Name</th>
                        <th>Participation Fee</th>
                        <th>Event Date</th>
                        <th>Version</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($events as $event) { ?>
                        <tr>
                            <td>
                                <?php echo $event["participation_id"]; ?>
                            </td>
                            <td>
                                <?php echo $event["employee_name"]; ?>
                            </td>
                            <td>
                                <?php echo $event["employee_mail"]; ?>
                            </td>
                            <td>
                                <?php echo $event["event_id"]; ?>
                            </td>
                            <td>
                                <?php echo $event["event_name"]; ?>
                            </td>
                            <td>
                                <?php echo $event["participation_fee"]; ?>
                            </td>
                            <td>
                                <?php echo $event["event_date"]; ?>
                            </td>
                            <td>
                                <?php echo $event["timezone_version"]; ?>
                            </td>
                        </tr>

                    <?php  }  ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>