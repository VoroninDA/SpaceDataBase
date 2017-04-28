<!-- http://www.tutorialrepublic.com/php-tutorial/php-mysql-ajax-live-search.php -->

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>PHP Live Database Search</title>
<link href="search_style.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup put", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("search_handler.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        $(this).parent(".result").empty();
    });
});
</script>
</head>
<body>
    <p><a href="index.php"><input type="reset" value="Back to main menu"></a></p>
    <div class="search-box">
        <input type="text" autocomplete="off" placeholder="Search first name of employees table" />
        <div class="result"></div>
    </div>
    
</body>
</html>