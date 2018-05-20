<table class="table table-hover">
    <thead>
    <tr>
      <th scope="col">Day</th>
      <th scope="col">Date</th>
      <th scope="col">Job #</th>
      <th scope="col">Operator</th>
      <th scope="col">D Code</th>
      <th scope="col">Total Runtime</th>
      <th scope="col">Description</th>
      <th scope="col">Task</th>
      <th scope="col">Quantity</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($entries as $entry): ?>

        <tr>
            <td><?php echo date('D') ?></td>
            <td><?php echo date('Y-m-d') ?></td>
            <td><?php echo htmlspecialchars($entry['part_number']); ?></td>
            <td><?php echo htmlspecialchars($entry['initials']); ?></td>
            <td><?php echo htmlspecialchars($entry['dept_code']); ?></td>
            <td>
                <?php
                $id = $entry['start_id'];
                $time = get_row($id);
                $datetime1 = new DateTime($time['stop_time']);
                $datetime2 = new DateTime($time['start_time']);
                $interval = $datetime1->diff($datetime2);
                echo $interval->format('%H:%I:%S');

                ?>
            </td>
            <td><?php echo htmlspecialchars($entry['description']); ?></td>
            <td><?php echo htmlspecialchars($entry['task']); ?></td>
            <td><?php echo htmlspecialchars($entry['quantity']); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php
$tdate = date("Y-m-d");
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=cnc_daily_time_$tdate.xls");
delete_all_stop();
delete_all_start();
// header('Location: index.php?action=table');
?>
