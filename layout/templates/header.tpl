<html data-bs-theme="dark">
    <head>
        <title>{$siteTitle}</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <link href="{$baseUrl}/layout/css/style.css" rel="stylesheet" type="text/css" />
        {literal}
        <script>
            ajaxUrl = '/INSTALL/install.php';
            async function part2() {
                var x = $('#install_form').serializeArray();

                $.post(ajaxUrl, {'r':'part2', 'd': x}, (data) => {
                    $.each(data.msg, (i, val) => {
                        $('#part2_log_ul').append('<li class="">' + val + '</li>');
                    })
                    $('#part2_link').show();
                }, 'json')
            }

            async function part1() {
                $.post(ajaxUrl, { 'r':'part1'}, (data) => {
                    if(data.status == 'ok') {
                        $('#formWrapper').hide();
                        $('#install_part2').show();
                    } else {
                        console.log(data);
                        return true;
                    }
                },'json');
            }

            async function run() {
                await part1();
                await part2();
            }

            $(document).ready(function() {

                $('#install_form').on('submit', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    var x = $('#install_form').serializeArray();
                    var formComplete = true;
                    for( const pair of x.entries()) {
                        $('#'+pair[1]['name']).removeClass('redBorder');
                        if(pair[1]['value'] == '') {
                            $('#'+pair[1]['name']).addClass('redBorder');
                            formComplete = false;
                        }
                    }

                    if(formComplete) {
                        run();
                    }
                })

            })            
        </script>
        {/literal} 
    </head>


    <!-- Background image by kjpargeter on Freepik -->
    <body class="cover img-fluid">
        <div class="container-fluid p-5 text-center" style="font-family: 'weblysleek'; color: #376d7f;">
            <h1>{$headerText}</h1>
        </div>
