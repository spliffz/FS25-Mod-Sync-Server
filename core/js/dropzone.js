// disable autodiscover
Dropzone.autoDiscover = false;

var myDropzone = new Dropzone("#dropzone", {
    url: "upload.php",
    method: "POST",
    paramName: "file",
    autoProcessQueue : false,
    acceptedFiles: ".zip",
    maxFiles: 10,
    maxFilesize: 4096, // MB
    uploadMultiple: true,
    parallelUploads: 100, // use it with uploadMultiple
    createImageThumbnails: true,
    thumbnailWidth: 120,
    thumbnailHeight: 120,
    addRemoveLinks: true,
    timeout: 18000000,
    dictRemoveFileConfirmation: "Are you Sure?", // ask before removing file
    // Language Strings
    dictFileTooBig: "File is to big ({{filesize}}mb). Max allowed file size is {{maxFilesize}}mb",
    dictInvalidFileType: "Invalid File Type",
    dictCancelUpload: "Cancel",
    dictRemoveFile: "Remove",
    dictMaxFilesExceeded: "Only {{maxFiles}} files are allowed",
    dictDefaultMessage: "Drop files here to upload, or click here to select",
});

myDropzone.on("addedfile", function(file) {
    // console.log(file);
});

myDropzone.on("removedfile", function(file) {
    // console.log(file);
});

// Add mmore data to send along with the file as POST data. (optional)
myDropzone.on("sending", function(file, xhr, formData) {
    //console.log(formData)
    formData.append("dropzone", "1"); // $_POST["dropzone"]
    formData.append('acp_upload_gportal_enabled', $('#acp_upload_gportal_enabled').val());
    //formData.append('ulFormDate', $('#ulFormDate').val());
});

myDropzone.on("error", function(file, response) {
    // console.log(response);
});

// on success
myDropzone.on("success", function(file, response) {
    // div magic
    // console.log('success.file: ' + file);
    // console.log('success.response: ' + response);
    // $('#uploadFormDiv').hide();
    // $('#afterUpload').show();

});
myDropzone.on("successmultiple", function(file, response) {
    // get response from successful ajax request
    //console.log(response);

    // submit the form after images upload
    // (if u want yo submit rest of the inputs in the form)

    // uncomment this to reload the page instead of ajax response
    //document.getElementById("dropzone-form").submit();

    // div magic
    // console.log(file);
    // console.log(response);
    $('#uploadFormDiv').hide();
    $('#dropzoneFormWrapper').hide();
    $('#submit-dropzone').hide();
    $('#upload_indexer').show();

    $.post(baseUrl, { 'request': 'reindex'}, function(data) {
        // console.log(data)
        if(data.status == 'OK') {
            $('#upload_indexer').hide();
            $('#afterUpload').show();
        } else {
            console.log(data);
        }    
    }, 'json');    

});

// button trigger for processingQueue
var submitDropzone = document.getElementById("submit-dropzone");
submitDropzone.addEventListener("click", function(e) {
    // Make sure that the form isn't actually being sent.
    e.preventDefault();
    e.stopPropagation();

    //console.log($('#ulFormClinicName').val());
    $('#submit-dropzone').html('<div class="spinner-border text-light" role="status"><span class="visually-hidden">Loading...</span></div>');

    myDropzone.processQueue();

});