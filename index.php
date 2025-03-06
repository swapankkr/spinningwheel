<?php require_once './script/includes/start.php';
$user = user(); $wheels = query("SELECT * FROM wheels WHERE user_id = '$user->id'"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spinning Wheel</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <style>
        .form-control, .card, .form-control:focus{
            background-color: #3b3f4b;
            color: #fff !important;
        }
        .card a{
            color: #fff !important;
        }
        header i{
            color: #007bff !important;
        }
        body{
            background-color: #1f2130 !important;
        }
        .bg-light{
            color: #fafcff !important;
            background-color: #1f2130 !important;
        }
        .bg-light > a{
            color: #fafcff !important;
        }
        .main-cointainer {
            max-width: 560px;
            width: 100%;
            margin: auto;
            height: 100vh;
        }

        header {
            position: sticky;
            z-index: 2;
        }

        header i {
            font-size: 25px;
            cursor: pointer;
        }

        body {
            background-color: rgba(125, 3, 123, 0.119);
            color: black;
        }

        main {
            overflow: auto;
            height: calc(100vh - 100px);
        }

        .cursor-pointer {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="main-cointainer bg-light shadow">
        <header>
            <div class="d-flex w-100 justify-content-between align-items-center bg-light p-4 shadow ">
                <a href="javascript:void(0)" title="Settings" style="visibility: hidden;">
                    <i class="fas fa-cog"></i>
                </a>
                <h4>Spinning Wheel</h4>
                <a href="new_wheel.php" title="Add new wheel">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </header>
        <main id="wheel_list">
            <?php if(empty($wheels)) : ?>
            <div class="text-center px-4">
                <p class="text-gray text-bold p-5">
                    You do not added any Wheel yet. Please click ' <i class="fas fa-plus"></i> ' to create new Wheel.
                </p>
            </div>
            <?php else : ?>
                <div class="w-100 p-4">
                <?php foreach($wheels as $index => $wheel) : ?>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="spinner.php?id=<?php echo $wheel->id ?>"><img src="dist/img/logo.png" alt="wheel" height="60" class="cursor-pointer"></a>
                            <a href="spinner.php?id=<?php echo $wheel->id ?>"><h5 class="cursor-pointer"><?php echo $wheel->name ?></h5></a>
                            <div class="d-flex" style="font-size: 20px; gap: 18px;">
                                <a href="edit_wheel.php?id=<?php echo $wheel->id;?>" title="Edit" class="px-2 py-1 bg-blue rounded-circle">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="script/delete_wheel.php?id=<?php echo $wheel->id;?>" title="Delete" class="px-2 py-1 bg-danger rounded-circle" data-id="<?php echo $wheel->id;?>">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
                </div>
                <?php endif; ?>
        </main>
    </div>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', function() {

        });
    </script>
</body>

</html>