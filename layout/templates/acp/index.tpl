{include file='acp/header.tpl'}
        <div class="container-md">
            <div class="row text-center">
                <div class="col">
                    <h2>Dashboard</h2>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md">
                    <table id="dash_infotable" class="table_dashboard">
                        <thead>
                            <tr>
                                <td>
                                    <h3>Information</h3>
                                </td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Hostname:</td>
                                <td class="fw-bold text-end">{$serverHostname}</td>
                            </tr>
                            <tr>
                                <td>Total # of Mods:</td>
                                <td class="fw-bold text-end">{$totalMods}</td>
                            </tr>
                            <tr>
                                <td>Total Space Used: </td>
                                <td class="fw-bold text-end"><div id="dash_lastworkdate">{$totalSize}</div></td>
                            </tr>
                        </tbody>
                    </table>
                    <p></p>
                </div>
                <div class="col-md">
                    <div class="column-right">
                        <p></p>
                        <div class="githubInfo text-end">
                            <a href="https://github.com/spliffz/FS25-Mod-Sync-Server" target="_blank">FS25 Sync Storage Server Github</a><br />
                            <a href="https://github.com/spliffz/FS25-Sync-Tool" target="_blank">FS25 Mod Sync Tool Github</a><br />
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col"><p></p></div>
            </div>
        </div>
{include file='acp/footer.tpl'}