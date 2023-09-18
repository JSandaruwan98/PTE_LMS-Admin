<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagination Example</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
          $('#previous').click(function(){
             $('#main').load('assignTest.html');
          });
        });
      </script> 
</head>
<body>
  <?php
    if (isset($_GET['id'])){
      echo '<h1>'.$_GET['id'].'</h1>';
    }
  ?>

  <div class="header border">
    <div class="card-body ms-3" style="margin-top: -7px;">
        <h5 class="h4 card-title text-secondary">Assign Test</h5>
        <p class="card-text text-secondary"><a href="/">Dashboard</a><span> / Batch Details</span></p>
    </div>
</div>
    
  <div id="data-container" class="content border mt-3 p-4">
    <div class="col">
        <h5 class="pb-3" style="float: left;">Batch Details</h5>
    </div>
    <div style="height: 380px;">
    <table class="table" id="data-table">
      <thead>
        <tr>
          <th scope="col" class="text-center"><span style="color: #666464;"></th>
          <th scope="col" class="text-center"><span style="color: #666464;">Test Name</span></th>
          <th scope="col" class="text-center"><span style="color: #666464;">Module</span></th>
          <th scope="col" class="text-center"><span style="color: #666464;">Category Name</span></th>
          <th scope="col" class="text-center"><span style="color: #666464;">Level</span></th>
        </tr>
      </thead>
      <tbody>
        
      </tbody>
    </table>
  </div>
    <nav aria-label="Page navigation example" style="margin-top: 65px;">
      <ul id="pagination" class="pagination">
        
      </ul>
      <button class="btn btn-secondary" style="float: right; margin-top: 35px;">Submit</button>
      <button id="previous" class="btn btn-secondary me-2" style="float: right; margin-top: 35px;">Previous</button>
    </nav>
    
  </div>
  
  
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="script.js"></script>
  <script>
    $(document).ready(function () {
    var itemsPerPage = 10; // Number of items to display per page
    var currentPage = 1;  // Track the current page

    function loadData(page) {
        $.ajax({
            type: "GET",
            url: "get_data.php",
            data: { page: page },
            dataType: "json",
            success: function (response) {
                var data = response.data;

                // Populate the table with data
                var tableBody = $("#data-table tbody");
                tableBody.empty();
                $.each(data, function (index, item) {
                    var row = `<tr>
                        <td class="text-center" style="font-size:15px;"><div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="0"></div></span></td>
                        <td class="text-center">${item.name}</td>
                        <td class="text-center">${item.age}</td>
                        <td class="text-center">${item.id}</td>
                        <td class="text-center">${item.name}</td>
                    </tr>`;
                    tableBody.append(row);
                });

                // Update pagination controls
                var pagination = $("#pagination");
                
                pagination.empty();
                var totalPages = Math.ceil(response.totalItems / itemsPerPage);

                // Add Previous button
                if (currentPage > 1) {
                    var prevButton = `<li id="pagination-previous" class="page-item" id="prev-btn"><a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a></li>`;
                    pagination.append(prevButton);
                }

                // Add numbered page buttons
                for (var i = 1; i <= totalPages; i++) {
                    var pageLink = `<li id="pagination-item" class="page-item"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
                    pagination.append(pageLink);
                }

                // Add Next button
                if (currentPage < totalPages) {
                    var nextButton = `<li id="pagination-next" class="page-item" id="next-btn"><a class="page-link" href="#" data-page="${currentPage + 1}">Next</a></li>`;
                    pagination.append(nextButton);
                }
            }
        });
    }

    // Initial data load
    loadData(currentPage);

    // Pagination click event
    $(document).on("click", "#pagination a", function (e) {
        e.preventDefault();
        var page = $(this).data("page");
        currentPage = page;  // Update the current page
        loadData(page);
    });
});

</script>
</body>
</html>