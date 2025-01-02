<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin Panel</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="../css/admin.css" rel="stylesheet" />
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <p></p>
            </div>
            <div class="col" id=''>
                {if isset($eMsg)} 
                <div>
                    <font color="#FF0000">{$eMsg}</font>
                </div> 
                {else}
                <div>
                    <b>Log In</b>
                </div>
                {/if}
    
                <form action="{$baseUrl}/acp/login.php?act=login" method="post" enctype="multipart/form-data" name="adminLoginForm">
                    <div class="mb-3">
                        <label for="acpFormInputUser" class="form-label">Username</label>
                        <input type="text" class="form-control" id="acpFormInputUser" name="acpFormInputUser">
                    </div>
                    <div class="mb-3">
                        <label for="acpFormInputPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="acpFormInputPassword" name="acpFormInputPassword">
                    </div>
                    <button type="submit" class="btn btn-primary" name="loginSubmit">Submit</button>
                </form>
            </div>
            <div class="col"></div>
        </div>
        <p></p>
    </div>
</div>
{include file='acp/footer.tpl'}