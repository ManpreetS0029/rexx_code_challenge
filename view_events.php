<?php

require_once "db/db_connection.php";

require_once "classes/VersionComparison.php";

$query = $conn->prepare("SELECT * FROM participants INNER JOIN events ON participants.event_id = events.event_id");

$query->execute();

$events = $query->fetchAll(PDO::FETCH_ASSOC);

$employee_name = "";
$event_name = "";
$event_date = "";

$searchStatus = 0;

if (isset($_GET["submit_button"])) {

    $searchStatus = 1;

    $employee_name .= trim($_GET["employee_name"]);
    $event_name .= trim($_GET["event_name"]);
    $event_date .=  trim($_GET["event_date"]);

    $seachQuery = $conn->prepare("SELECT * FROM participants INNER JOIN events ON  participants.event_id = events.event_id WHERE employee_name LIKE '%$employee_name%' AND event_name LIKE '%$event_name%' AND event_date LIKE '%$event_date%'");

    $seachQuery->execute();

    $results = $seachQuery->fetchAll(PDO::FETCH_ASSOC);
}

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

                        <form method="GET">

                            <label for="employee_name">Employee Name</label>
                            <input type="text" name="employee_name" id="employee_name" value="<?php echo isset($_GET["employee_name"]) ? $_GET["employee_name"] : ""  ?>">

                            <label for="event_name">Event Name</label>
                            <input type="text" name="event_name" id="event_name" value="<?php echo isset($_GET["event_name"]) ? $_GET["event_name"] : ""  ?>">

                            <label for="event_date">Date</label>
                            <input type="date" name="event_date" id="event_date" value="<?php echo isset($_GET["event_date"]) && $_GET["event_date"] != "" ? date("Y-m-d", strtotime($_GET["event_date"])) : "mm-dd-yyyy"  ?>">

                            <button type="submit" name="submit_button">Search</button>

                        </form>

                    </div>
                </div>

            </div>

        </div>

        <div class="datatable">
            <table border="1" cellpadding="7">
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

                    <?php

                    if ($searchStatus === 0) {

                        foreach ($events as $event) {

                            $versionCompare = new VersionComparison($event["version"]);

                    ?>

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
                                    <?php echo $event["event_date"] . " " . $versionCompare->isBerlin(); ?>
                                </td>
                                <td>
                                    <?php echo $event["version"]; ?>
                                </td>
                            </tr>

                        <?php

                        }
                    } else {


                        $totalPrice = 0;

                        foreach ($results as $result) {

                            $totalPrice += $result["participation_fee"];

                            $versionCompare = new VersionComparison($result["version"]);

                        ?>

                            <tr>
                                <td>
                                    <?php echo $result["participation_id"]; ?>
                                </td>
                                <td>
                                    <?php echo $result["employee_name"]; ?>
                                </td>
                                <td>
                                    <?php echo $result["employee_mail"]; ?>
                                </td>
                                <td>
                                    <?php echo $result["event_id"]; ?>
                                </td>
                                <td>
                                    <?php echo $result["event_name"]; ?>
                                </td>
                                <td>
                                    <?php echo $result["participation_fee"]; ?>
                                </td>
                                <td>
                                    <?php echo $result["event_date"] . " " . $versionCompare->isBerlin();  ?>
                                </td>
                                <td>
                                    <?php echo $result["version"]; ?>
                                </td>
                            </tr>

                        <?php
                        }
                        ?>

                        <tr>
                            <td></td>
                            <td><b>Total Price</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php echo $totalPrice; ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php
                    } ?>

                </tbody>
            </table>
        </div>
    </div>
</body>

</html>