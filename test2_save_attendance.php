<?php
$response = array('success' => false, 'message' => '');

// Establish a database connection (replace with your credentials)
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if attendance data is present
    if (isset($_POST['attendance']) && is_array($_POST['attendance']) && isset($_POST['attendanceDate'])) {
        $attendanceDate = $_POST['attendanceDate'];

        try {
            $conn->autocommit(false); // Start a transaction

            foreach ($_POST['attendance'] as $studentId => $isPresent) {
                // Sanitize inputs and perform error checking as needed
                $studentId = intval($studentId);
                $isPresent = intval($isPresent);

                // Update the attendance for the student
                $sql = "INSERT INTO attendance (student_id, attendance_date, ispresent) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE ispresent = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('issi', $studentId, $attendanceDate, $isPresent, $isPresent);
                $stmt->execute();

                if ($stmt->error) {
                    throw new Exception("Error adding attendance for student ID: $studentId");
                }
            }

            $conn->commit(); // Commit the transaction
            $response['success'] = true;
        } catch (Exception $e) {
            $conn->rollback(); // Rollback the transaction in case of an error
            $response['message'] = $e->getMessage();
        } finally {
            $conn->autocommit(true); // Restore autocommit mode
        }
    } else {
        $response['message'] = 'Invalid or incomplete data submitted.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

$conn->close();
echo json_encode($response);
?>
