<?php

$sname= "localhost";
$unmae= "root";
$password = "";
$db_name = "lms";

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagination Example</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <div class="header border">
    <div class="row p-3 ps-5">
         <h1 class="h4 text-secondary">Wallet</h1>
         <div class="d-inline"><a href="/">Dashboard</a><span> / Wallet</span></div> 
    </div>
  </div>
  <div class="content border mt-3 p-3">
    <div style="height: 360px;">
    <table class="table" id="data-table">
      <thead>
        <tr>
          <th scope="col"><span style="color: #666464;">S.No</span></th>
          <th scope="col"><span style="color: #666464;">Date</span></th>
          <th scope="col"><span style="color: #666464;">Type</span></th>
          <th scope="col"><span style="color: #666464;">Amount</span></th>
          <th scope="col"><span style="color: #666464;">Transaction</span></th>
          <th scope="col"><span style="color: #666464;">Description</span></th>

        </tr>
      </thead>
      <tbody>
        
      </tbody>
    </table>
    <h1 id="test"></h1>
  </div>
    <nav aria-label="Page navigation example" id="pagination" style="margin-top: -30px; margin-bottom: -20px;">
      <ul class="pagination">
        <li class="page-item" id="prev-btn"><a class="page-link" href="#">Previous</a></li>
        <li class="page-item"><a class="page-link" href="#"><span style="color: black;" id="page-info">Page 1</span></a></li>
        <li class="page-item" id="next-btn"><a class="page-link" href="#">Next</a></li>
      </ul>
    </nav>
  </div>
  <?php $result = $conn->query("SELECT * FROM courses") or die($conn->$query);
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        $data_json = json_encode($data)
  ?>
  
  
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="script.js"></script>
  <script>
    $(document).ready(function() {
  // Sample data for demonstration
  var jsonData = <?php echo $data_json; ?>;

  const itemsPerPage = 10; // Number of items to show per page
  let currentPage = 1; // Current page number

  function displayTableData() {
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const pageData = data.slice(startIndex, endIndex);

    const tableBody = $("#data-table tbody");
    tableBody.empty(); // Clear existing rows
    $("#test").append(`kamal`)
    
    pageData.forEach(item => {
      const row = `<tr><td>${item.id}</td><td>${item.course_id}</td><td>${item.lname}</td><td>${item.handle}</td></tr>`;
      tableBody.append(row);
    });

    $("#page-info").text(`Page ${currentPage}`);
  }

  $("#prev-btn").on("click", function() {
    if (currentPage > 1) {
      currentPage--;
      displayTableData();
    }
  });

  $("#next-btn").on("click", function() {
    const totalPages = Math.ceil(data.length / itemsPerPage);
    if (currentPage < totalPages) {
      currentPage++;
      displayTableData();
    }
  });

  // Initial display
  displayTableData();
});

  </script>
</body>
</html>
