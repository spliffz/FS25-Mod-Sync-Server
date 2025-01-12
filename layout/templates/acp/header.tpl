<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" data-bs-theme="dark">
    <head>
        <title>{$siteTitle} - ACP</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
        <link rel="stylesheet" href="{$baseUrl}/layout/css/style.css" type="text/css" />
        <script src="{$baseUrl}/core/js/main.js"></script>
      </head>

    <body>
        <div class="container-fluid p-5 bg-secondary text-white text-center">
            <h1>{$siteTitle} - ACP</h1>
        </div>

        <nav class="navbar navbar-expand-md bg-body-tertiary">
            <div class="container-fluid">
              <a class="navbar-brand" href="#">
                <img src="{$imgUrl}/discord_logo.png" style="width: 40px;" />
              </a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a href="#" class="nav-link disabled">Hello {$acpUser}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active crumb-dashboard" aria-current="page" href="{$baseUrl}/acp/">Dashboard</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link crumb-modList" href="{$baseUrl}/acp/home.php?p=modList">Mod List</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link crumb-upload" href="{$baseUrl}/acp/home.php?p=upload">Upload Mods</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link crumb-settings" href="{$baseUrl}/acp/home.php?p=settings">Settings</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{$baseUrl}/acp/login.php?act=logout">Logout</a>
                  </li>
<!--                   <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Dropdown
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </li>
 --><!--                   <li class="nav-item">
                    <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                  </li>
 -->                </ul>
<!--                 <form class="d-flex" role="search">
                  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                  <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
 -->              </div>
            </div>
          </nav>