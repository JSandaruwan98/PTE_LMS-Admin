<!DOCTYPE html>
<html>
<head>
    <title>Student Attendance</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</head>
<body>
    <h1>Student Attendance</h1>
    <form id="attendanceForm">
        <label for="attendanceDate">Select Date:</label>
        <input type="date" id="attendanceDate" name="attendanceDate" required>
        <table>
            <tr>
                <th>Roll Number</th>
                <th>Name</th>
                <th>Attendance</th>
            </tr>
            <?php
                // Replace with your database connection code
                include 'conn.php';

                $sql = "SELECT * FROM student";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['student_id'] . '</td>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '<td><input type="checkbox" name="attendance['.$row['student_id'].']" value="1"></td>';
                        echo '</tr>';
                    }
                }

                $conn->close();
            ?>
        </table>
        <br>
        <input type="submit" value="Submit Attendance">
    </form>

    <script>
        // Initialize the date picker
        $( function() {
            $('#attendanceDate').datepicker({ dateFormat: 'yy-mm-dd' });
        });

        // Use jQuery to handle form submission
        $('#attendanceForm').submit(function (event) {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'test2_save_attendance.php',
                data: $(this).serialize(),
                success: function (response) {
                    if (response.success) {
                        alert('Attendance saved successfully.');
                        // You can redirect or refresh the page as needed
                    } else {
                        alert('Error: ' + response.message);
                    }
                }
            });
        });
    </script>
</body>
</html>
