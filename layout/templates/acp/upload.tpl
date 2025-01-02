{include file='acp/header.tpl'}
        <div class="container mt-5 text-center">
            <div class="row g-3">
                <div class="col-sm">
                    <div id="afterUpload" style="display:none;">
                        <p>
                            Upload Complete. Mods have been added and indexed.<br />
                            Click <a href="{$baseUrl}/acp/home.php?p=modList">here</a> to view the mods.<br />
                            Or <a href="{$baseUrl}/acp/home.php?p=upload">Here</a> to upload another file.
                        </p>
                    </div>
                    <div id="upload_indexer">
                        <div class="alert alert-info">
                            Running Indexer. Please Wait.<br />
                            Page will refresh once done.
                        </div>
                        <p></p>
                    </div>
                    <div class="row g-3">
                        <div class="" id="uploadFormDiv">
                            <p>Here you can upload new mods. <br /><br />
                            Files with the same name will be overwritten!<br />
                            Max files: 5 <br />
                            Max Filesize: {$postMaxSize}<br />
                            <span class="infoText_small">This value is from php.ini.</span>
                            {if $postMaxSize < 2048} <br />
                                <div class="alert alert-info">
                                    Your server isn't configured to upload large files.<br />
                                    Set these php.ini values to 2048: 'upload_max_filesize' & 'post_max_size'.
                                    <br />
                                </div>
                            {/if}
                            </p>
                            </div>
                        </div>
                        <div id="dropzoneFormWrapper">
                            <form id="dropzoneForm" action="{$baseUrl}/acp/upload.php" method="POST" enctype="multipart/form-data">
                                <div id="dropzone" class="dropzone"></div>
                                <p></p>
                                <button id="submit-dropzone" class="btn btn-info" type="submit" name="submitDropzone">Upload</button>
                                <!-- <input id="submit-dropzone" class="btn btn-info" type="submit" name="submitDropzone" value="Submit" /> -->
                            </form>
                        </div>
                        <p></p>
                    </div>
                
                </div>
            </div>
        </div>
        <script src="{$baseUrl}/core/js/dropzone.js"></script>
{include file='acp/footer.tpl'}