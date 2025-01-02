{include file='header.tpl'}
        <div class="container mt-5">
            <div class="row">
                <div class="col text-center comingSoon">
                    <h2>A few things first...</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div id="consoleWrapper">
                        <div class="console" id="console"></div>
                    </div>

                    <div id="install_part2" class="installPartsWrapper">
                        <div id="part2_log">
                            <div class="install_info_title fw-bold">
                                Log
                                <hr />
                            </div>
                            <ul id="part2_log_ul" class="">

                            </ul>
                        </div>
                        <div id="part2_link">
                            All done. Please visit <a href="{$baseUrl}/acp/" target="_blank">The Control Panel</a> to start using FS25 Sync Storage Server <br />
                            <br />
                            You can close this window now.
                        </div>
                    </div>

                    <div id="formWrapper" class="installPartsWrapper">
                        <form class="form-control" id="install_form">
                            <div id="install_serverURL">
                                <label for="install_hostname" class="form-label">Server URL:</label>
                                <input type="text" id="install_hostname" class="form-control" value="{$baseUrl}" name="install_hostname" />
                            </div>
                            <div id="spacer">
                                <hr />
                            </div>
                            <div id="install_serverDB">
                                <span class="info">
                                    <p>
                                    These are values from 'config.inc.php'. Please edit them in the file.
                                    </p>
                                </span>
                                
                                <label for="install_sqlHostname" class="form-label">MySQL Server Host:</label>
                                <input type="text" id="install_sqlHostname" class="form-control" value="{$sql_host}" name="install_sqlHostname" />
                                
                                <label for="install_sqlPort" class="form-label">MySQL Server Port:</label>
                                <input type="text" id="install_sqlPort" class="form-control" value="{$sql_port}" name="install_sqlPort" />
                                
                                <label for="install_sqlUser" class="form-label">MySQL Username:</label>
                                <input type="text" id="install_sqlUser" class="form-control" value="{$sql_user}" name="install_sqlUser" />
                                
                                <label for="install_sqlPass" class="form-label">MySQL Password:</label>
                                <input type="password" id="install_sqlPass" class="form-control" value="{$sql_pass}" name="install_sqlPass" />
                                
                                <label for="install_sqlDB" class="form-label">MySQL Database:</label>
                                <input type="text" id="install_sqlDB" class="form-control" value="{$sql_db}" name="install_sqlDB" />
                            </div>
                            
                            
                            <div class="text-end p-1">
                                <button id="install_submit" class="btn btn-primary">Install</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
{include file='footer.tpl'}