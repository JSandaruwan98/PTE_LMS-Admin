<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
    <button id="evaluationOn">Evaluation ON</button>
   
    <script>
        function getUrlParameter(parameter) {
            var url = window.location.search.substring(1); // Get the query string (excluding the '?')
            var params = url.split('&');

            for (var i = 0; i < params.length; i++) {
                var param = params[i].split('=');
                if (param[0] === parameter) {
                return param[1];
                }
            }
            return null; // Return null if the parameter is not found
        }
        var idValue = getUrlParameter('id');

        $(document).on("click", "#evaluationOn", function (e) {
            var dataToSend = {
              task: 'evalupdate',
              id: idValue
            };
            $.ajax({
              url: 'dataHandler/api/post.php', // Replace with the URL to your server-side script
              type: 'POST',
              data: dataToSend,
              success: function(response) {
                  // Handle the server's response here if needed
                  console.log(response);
              },
              error: function(xhr, status, error) {
                  // Handle errors here if needed
                  console.error(error);
              }
          });
        });
    </script>
</body>
</html>