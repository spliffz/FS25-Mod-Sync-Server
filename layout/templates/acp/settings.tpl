{include file='acp/header.tpl'}

        <!-- Modal -->
        <div class="modal fade" id="addrModal" tabindex="-1" aria-labelledby="addrModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="addrModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <p></p>
                        <div id="map_modal"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
            </div>
        </div>
  

        <!-- Page -->

        <div class="container-md">
            <div class="row text-center">
                <div class="col">
                    <p></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h2>Settings</h2>
                    <p>Here you can change various (future) settings.</p>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-start fw-bold">Change Admin Password</td>
                        </tr>
                        <tr>
                            <td class="">
                                <div id="info_popupWrapper">
                                    <div class="alert alert-success info_popup" id="info_popup_OK">
                                        Successfully changed the password.
                                    </div>
                                </div>
                                <label for="acp_changePassInput" class="form-label">Password:</label>
                                <input type="password" class="form-control text-end" id="acp_changePassInput">
                                <div class="text-end p-1">
                                    <button class="btn btn-primary" id="acp_changePassButton">Change Password</button>
                                </div>
                            </td>
                        </tr>

                    </table>
                </div>
            </div>

            <hr />

            <div class="row">
                <div class="col-md-6">
                    <div id="logBoxWrapper" class="logBoxWrapper">
                        <textarea class="logBox" id="logBoxContents" readonly></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <td class="text-start fw-bold">
                                Import Mods from GPortal Hosted FS22/25 Server<br />
                                <br />
                                <div class="alert alert-secondary text-center" role="alert">
                                    This will make an FTP Connection to your GPortal server and download the mods with it to the modsfolder on this server. <br />
                                    It will <strong>only</strong> download currently <strong>active mods.</strong><br /><br />
                                    <strong>It does not account for newer files. GPortal mods will always overwrite local mods.</strong>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="">
                                <div id="info_popupWrapper_FTP">
                                    <div class="alert alert-warning text-center" id="info_popup_SpinnerWrapper_FTP">
                                        <div class="spinner-border" role="status" id="info_popup_Spinner_FTP">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>

                                    <div class="alert alert-success text-center" id="info_popup_INFO_OK_FTP">
                                        Successfully updated the FTP Information.
                                    </div>

                                    <div class="alert alert-success text-center" id="info_popup_OK_FTP">
                                        Successfully imported all active mods from GPortal.
                                    </div>
                                </div>

                                <div id="acp_ftpInfoWrapper" class="">
                                    <div class="fw-bold">FTP Information:</div>
                                    {section name=nr loop=$ftpInfo}
                                    <form id="acp_ftp_form">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td>FS REST API <br />Career Savegame Link: <img src="{$imgUrl}/Question.png" class="icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="You can find this on your Dedicated Server Admin Panel under > Settings > Miscellaneous > REST API."></td>
                                            <td><input type="text" id="acp_ftp_careerSavegameLink" name="acp_ftp_careerSavegameLink" class="form-control text-end" value="{$ftpInfo[nr].CSLink}" /></td>
                                        </tr>
                                        <tr>
                                            <td>Hostname/IP: <img src="{$imgUrl}/Question.png" class="icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="This is your FTP Hostname/IP. You can find this on your GPortal Server"></td>
                                            <td><input type="text" id="acp_ftp_hostname" name="acp_ftp_hostname" class="form-control text-end" value="{$ftpInfo[nr].ftp_host}" /></td>
                                        </tr>
                                        <tr>
                                            <td>Port: <img src="{$imgUrl}/Question.png" class="icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="This is your FTP Port. You can find this on your GPortal Server"></td>
                                            <td><input type="text" id="acp_ftp_port" name="acp_ftp_port" class="form-control text-end" value="{$ftpInfo[nr].ftp_port}" /></td>
                                        </tr>
                                        <tr>
                                            <td>Username: <img src="{$imgUrl}/Question.png" class="icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="This is your FTP Username. You can find this on your GPortal Server"></td>
                                            <td><input type="text" id="acp_ftp_uname" name="acp_ftp_uname" class="form-control text-end" value="{$ftpInfo[nr].ftp_user}" /></td>
                                        </tr>
                                        <tr>
                                            <td>Password: <img src="{$imgUrl}/Question.png" class="icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="This is your FTP Password. You can find this on your GPortal Server"></td>
                                            <td><input type="text" id="acp_ftp_pword" name="acp_ftp_pword" class="form-control text-end" value="{$ftpInfo[nr].ftp_pass}"/></td>
                                        </tr>
                                        <tr>
                                            <td>Folder: (Optional) <img src="{$imgUrl}/Question.png" class="icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="This defaults to /profile/mods. This should be good. leave blank if you don't know."></td>
                                            <td><input type="text" id="acp_ftp_path" name="acp_ftp_path" placeholder="profile/mods" class="form-control text-end" value="{$ftpInfo[nr].ftp_path}"/></td>
                                        </tr>
                                    </table>
                                    </form>
                                    {/section}
                                </div>

                                <div class="text-end p-1">
                                    <button class="btn btn-primary" id="acp_saveChangeImportMods">Save Changes</button>
                                    <button class="btn btn-primary" id="acp_importModsFromGPortalButton">Import Mods</button>
                                </div>
                            </td>
                        </tr>

                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col"><p></p></div>
            </div>
        </div>
{include file='acp/footer.tpl'}