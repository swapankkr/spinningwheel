<?php require_once './script/includes/start.php';
$user = user(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spinning Wheel</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
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
            height: 90vh;
            position: relative;
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
            background-color: white;
            color: black;
        }

        main {
            overflow: auto;
            height: calc(90vh - 200px);
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .color-box {
            height: 35px;
            min-width: 35px;
            border-radius: 50%;
            cursor: pointer;
        }

        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 110px;
        }

        /* color picker */
        .color-picker {
            position: absolute;
            height: 90vh;
            width: 100%;
            bottom: 0;
            z-index: 10000;
            background-color: white;
            display: none;
            transition: 500ms;
            opacity: 0;
        }
        .color-picker.show{
            display: block;
            opacity: 1;
        }
        .color-item {
            height: 55px;
            border-radius: 10px;
            box-shadow: 1px 1px 5px 1px #ddd;
        }
        .color-item.active::before{
            position: relative;
            height: 100%;
            width: 100%;
            content: '\2713';
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            border: 1px solid gray;
            font-weight: bold;
            color: white;
            text-shadow: 0px 0px 2px black;
        }

        .color-grid {
            display: grid;
            grid-template-columns: auto auto auto auto auto;
            gap: 20px;
            height: calc(90vh - 70px);
            overflow: auto;
            padding: 10px 0;
        }

        /**/
    </style>
</head>

<body>
    <div class="main-cointainer">
        <form autocomplete="off" id="add_wheel_form">
            <header class="shadow-lg">
                <div class="d-flex w-100 justify-content-between align-items-center bg-light p-4" style="gap: 20px;">
                    <a href="index.php" title="Settings">
                        <i class="fas fa-times"></i>
                    </a>
                    <input type="text" name="wheel_name" value="" placeholder="Enter wheel title"
                        class="form-control text-center">
                </div>
            </header>
            <main id="wheel_list">
                <div class="w-100 p-4 sortable">
                    <?php for ($index = 0; $index < 4; $index++) {
                        $color = color($index); /*hslToHex(rand(0, 360), 70, 60)*/ ?>
                        <div class="d-flex justify-content-between align-items-center mb-2" style="gap: 10px;" index="<?php echo $index; ?>">
                            <div class="drag-handler cursor-pointer">
                                <i class="fas fa-grip-horizontal text-gray" style="font-size: 25px;" title="Drag"></i>
                            </div>
                            <label class="color-box" for="color_<?php echo $index; ?>" style="background-color: <?php echo $color ?>;" data-color="<?php echo $color ?>"><input type="hidden" name="item[<?php echo $index; ?>][color]" class="color" value="<?php echo $color ?>"></label>
                            <input type="text" placeholder="Slice text" class="form-control name" name="item[<?php echo $index; ?>][name]"
                                style="flex-grow:1; min-width: auto;">
                            <input type="hidden" placeholder="Weight" class="form-control weight" name="item[<?php echo $index; ?>][weight]"
                                style="width: 75px;" value="1">
                            <div>
                                <a href="javascript:void(0)" class="remove-icon text-danger" style="font-size: 25px;" title="Delete">
                                    <i class="fas fa-ban"></i>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </main>
            <footer class="footer">
                <div>
                    <div class="d-flex flex-column justify-content-between align-items-center" style="gap: 10px;">
                        <button type="button" class="btn btn-primary w-50" style="font-size: 25px;" id="add_new_item_btn"><i class="fas fa-plus"></i></button>
                        <button type="submit" class="btn btn-primary w-75" style="font-size: 20px;" id="submit_wheel">Done</button>
                    </div>
                </div>
            </footer>
        </form>
        <div class="color-picker">
            <div class="d-flex justify-content-between align-items-center px-4 py-2">
                <h4>Pick a Colour</h4>
                <a href="javascript:void(0)" class="close-color-picker text-danger" style="font-size: 25px;" title="Close">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <div class="color-grid px-4">
                <?php foreach(json_decode(color()) as $colorCode): ?>
                <div class="color-item" data-color="<?php echo $colorCode;?>" style="background-color: <?php echo $colorCode;?>;"></div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/toastr/toastr.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            let nextColorIndex = <?php echo $index; ?>;
            const init_listeners = item => {
                index = item.getAttribute('index');
                item.querySelector('.remove-icon').addEventListener('click', () => {
                    if ($('#wheel_list > div').children().length > 4) {
                        item.remove();
                    } else {
                        toastr.info("At least 4 slice need to create wheel");
                    }
                });
                item.querySelector('input.weight').addEventListener('input', function(event) {
                    item.querySelector('input.weight').value = item.querySelector('input.weight').value.replace(/[^0-9]/g, '');
                });

                $(item.querySelector('.color-box')).click((event) => {
                    let currentColor = event.target.getAttribute('data-color');
                    window.colorPickForElement =  event.target;
                    $('.color-picker').addClass('show');
                    $(`.color-picker [data-color="${currentColor}"]`).addClass('active');
                });

                $('.sortable').sortable({
                    placeholder: 'sort-highlight',
                    connectWith: '.sortable',
                    handle: '.drag-handler',
                    forcePlaceholderSize: true,
                    zIndex: 999999
                })

            }
            $('#add_new_item_btn').click(() => {
                const item = document.createElement('div');
                const index = $('#wheel_list > div').children().length;
                const colorIndex = ((nextColorIndex++) % colors.length);
                const color = colors[colorIndex] /*hslToHex(Math.random() * 360, 70, 60)*/ ;
                item.setAttribute('class', "d-flex justify-content-between align-items-center mb-2")
                item.setAttribute('index', index)
                item.style.gap = '10px';
                item.innerHTML = `
                    <div class="drag-handler cursor-pointer">
                        <i class="fas fa-grip-horizontal text-gray" style="font-size: 25px;" title="Drag"></i>
                        </div>
                        <label class="color-box" for="color_${index}" data-color="${color}"><input type="hidden" name="item[${index}][color]" class="color" value="${color}"></label>
                        <input type="text" placeholder="Slice text" class="form-control name" name="item[${index}][name]"
                            style="flex-grow:1; min-width: auto;">
                        <input type="hidden" placeholder="Weight" class="form-control weight" name="item[${index}][weight]"
                            style="width: 75px;" value="1">
                        <div>
                        <a href="javascript:void(0)" class="remove-icon text-danger" style="font-size: 25px;" title="Delete">
                            <i class="fas fa-ban"></i>
                        </a>
                    </div>
                `;
                $('#wheel_list > div').append(item);
                item.querySelector('.color-box').style.backgroundColor = color;
                init_listeners(item);
                item.querySelector('input.name').focus();
            });

            $('#add_wheel_form').submit((event) => {
                event.preventDefault();
                $('#submit_wheel').prop('disabled', true);
                $.ajax({
                    url: 'script/add_wheel.php',
                    method: 'post',
                    data: new FormData(document.forms[0]),
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: (response) => {
                        $('#submit_wheel').prop('disabled', false);
                        location.href = 'spinner.php?id=' + response.data.wheel_id;
                    },
                    error: (error) => {
                        toastr.error(error.statusText);
                        $('#submit_wheel').prop('disabled', false);
                    }
                });
            });

            $('#wheel_list > div').children().each((index, element) => {
                init_listeners(element);
            });

            function hslToHex(h, s, l) {
                s /= 100;
                l /= 100;

                let c = (1 - Math.abs(2 * l - 1)) * s;
                let x = c * (1 - Math.abs((h / 60) % 2 - 1));
                let m = l - c / 2;

                let r = 0,
                    g = 0,
                    b = 0;

                if (0 <= h && h < 60) {
                    r = c;
                    g = x;
                    b = 0;
                } else if (60 <= h && h < 120) {
                    r = x;
                    g = c;
                    b = 0;
                } else if (120 <= h && h < 180) {
                    r = 0;
                    g = c;
                    b = x;
                } else if (180 <= h && h < 240) {
                    r = 0;
                    g = x;
                    b = c;
                } else if (240 <= h && h < 300) {
                    r = x;
                    g = 0;
                    b = c;
                } else if (300 <= h && h < 360) {
                    r = c;
                    g = 0;
                    b = x;
                }

                r = Math.round((r + m) * 255);
                g = Math.round((g + m) * 255);
                b = Math.round((b + m) * 255);

                return `#${((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1)}`;
            }
            const colors = <?php echo color(); ?>;
            
            /* Color picker */
            $('.close-color-picker').click(()=> {
                $('.color-picker').removeClass('show');
                $(`.color-picker [data-color]`).removeClass('active');
            });

            $(`.color-picker [data-color]`).each((index, element) => {
                element.onclick= (event)=>{
                    let selectedColor = event.target.getAttribute('data-color');   
                    window.colorPickForElement.style.backgroundColor = selectedColor;
                    window.colorPickForElement.setAttribute('data-color', selectedColor);
                    window.colorPickForElement.querySelector('input.color').value = selectedColor;
                    $('.color-picker').removeClass('show');
                    $(`.color-picker [data-color]`).removeClass('active');
                }
            });
            /**/ 
        });
    </script>
</body>

</html>