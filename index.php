<html>
    <header>
        <title> Captcha </title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    </header>
    <body>
        <div class="container d-flex justify-content-center">
            <div class="d-flex flex-column col-4 justify-content-center p-5">
                <img id="captcha-img" src="https://wallpapers.com/images/featured/7sn5o1woonmklx1h.jpg" class="border border-dark" style="height: 40px; width:150px;">
                <span class="d-none my-1 mb-2 text-danger" id="error_captcha">Captcha loading error</span>
                    
                <form class="form mt-2" id="catch_form" action="verify.php" method="post">
                    <input type="text" name="captcha_text" class="form-control mb-2" placeholder="Enter text here"/>
                    <span class="d-none my-1 text-danger" id="captcha_result">Invalid Captcha</span>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                
                $.get("generate.php").then(function (response) {
                    response = $.parseJSON(response);

                    if(response.image != false) {
                        $("#captcha-img").attr("src", "images/"+response.image);
                    } else {
                        $("#error_captcha").text(response.error);
                    }
                });

                $("#catch_form").submit(function (e) {
                    e.preventDefault();

                    $.post("verify.php", $("#catch_form").serialize()).then(function (response) {
                        response = $.parseJSON(response);

                        if(response.verify) {
                            $("#captcha_result").text("Success!").addClass("text-success d-block").removeClass("text-danger d-none");
                        } else{
                            $("#captcha_result").text("Invalid Captcha!").addClass("text-danger d-block").removeClass("text-success d-none");
                        }
                    });
                });
                
            });
        </script>
    </body>
</html>
