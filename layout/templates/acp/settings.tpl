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
                    <table class="table">
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
                                <input type="password" class="form-control" id="acp_changePassInput">
                                <div class="text-end p-1">
                                    <button class="btn btn-primary" id="acp_changePassButton">Change Password</button>
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