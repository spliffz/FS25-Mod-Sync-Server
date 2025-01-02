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
                </div>
            </div>
            </div>
        </div>
  

        <!-- Page -->
        <div class="container-md">
            <div class="row text-center">
                <div class="col">
                    <p></p>
                    <div class="">
                        <div class="text-start" style="float: left;align-content: normal;">
                            Mod Folder Location: <span class="fw-bold">{$modFolder}</span>
                        </div>
                        <div class="text-end">
                            <div class="indexer_updateInfo" id="indexer_updateInfo">here be update text</div>
                            <div class="indexer_updateBtn">
                                <button class="btn btn-primary" id="acp_indexBtn">Run Indexer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col" id="acp_modListTableWrapper">
                    <table id="acp_modlistTable" class="table">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Filename</td>
                                <td>Hash</td>
                                <td>Size</td>
                                <td>Options</td>
                            </tr>
                        </thead>
                        <tbody class="acp_modlistTableTBody">
                            {section name=nr loop=$modList}
                            <tr>
                                <td>{$modList[nr].idnr}</td>
                                <td>{$modList[nr].name}</td>
                                <td>{$modList[nr].hash}</td>
                                <td>{$modList[nr].size}</td>
                                <td>
                                    [<a href="{$baseUrl}{$modList[nr].download}" target="_blank">Download</a>]
                                     | 
                                    [<a href="#" onclick="delThisMod({$modList[nr].id})">Delete mod</a>]
                                </td>
                            </tr>
                            {/section}
                        </thead>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col"><p></p></div>
            </div>
        </div>
{include file='acp/footer.tpl'}