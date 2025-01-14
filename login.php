<!doctype html>
<html lang="en">

<head>
  <title>Spinning Wheel | Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="dist/css/style.css">

</head>

<body>
  <section class="ftco-section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 text-center mb-5">
          <h2 class="heading-section">Welcome, Back</h2>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
          <div class="login-wrap p-4 p-md-5" style="padding-bottom: 90px !important;">
            <div class="icon d-flex align-items-center justify-content-center">
              <span class="fa fa-user-o"></span>
            </div>
            <h3 class="text-center mb-4">Login to Secure Admin Pannel</h3>
            <small class="d-block text-danger mb-2 text-center" for="all"></small>
            <form action="script/login.php" class="login-form">
              <div class="form-group">
                <input type="email" class="form-control rounded-left" placeholder="Email" name="email">
                <small class="d-block text-danger" for="email"></small>
              </div>
              <div class="form-group">
                <input type="password" class="form-control rounded-left" placeholder="Password" name="password">
                <small class="d-block text-danger" for="password"></small>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary rounded submit p-3 px-5 bg-black">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      $('.login-form').submit(event => {
        event.preventDefault();
        $('[type="submit"]').prop('disabled', true);

        let formdata = new FormData(document.forms[0]);
        $.ajax({
          url: document.forms[0].action,
          data: formdata,
          method: 'POST',
          processData: false,
          contentType: false,
          dataType: 'json',
          success: (response) => {
            console.log(response);
            if(response.success == 1){
              location.href = 'dashboard.php';
            }else{
              $('[for="email"]').html(response.error?.email ?? "");
              $('[for="password"]').html(response.error?.password ?? "");
              $('[for="all"]').html(response.error?.all ?? "");
              $('[type="submit"]').prop('disabled', false);
            }
          },
          error: (error) => {
            alert(error.statusText);
            $('[type="submit"]').prop('disabled', false);
          }
        })
      });
    });
  </script>
</body>

</html>