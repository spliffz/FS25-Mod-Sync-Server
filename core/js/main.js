//####################
// 
// Main.js
// As one would expect: this handles javascript stuff.
//

var baseUrlDomain = 'https://fs25.rotjong.xyz' // Change this domain. If it's in a subfolder then just include that like so: 'https://fs25.rotjong.xyz/fs25_mods/'






//######################
// Don't Touch
//######################
var baseUrlPath = '/acp/ajax.php' 
var baseUrl = baseUrlDomain + baseUrlPath


// Main Functions
function delThisMod(id) {
    $.post(baseUrl, {'request': 'dtm', mid: id}, (data) => {
        // console.log(data);
        if(data.status == 'ok') {
            refreshModList();
        }
    },'json')
}

function setNavBreadcrumb() {
    $('.nav-link').each(function(d) {
        $(this).removeClass('active');        
    })
    const windowLocation = window.location.search;
    //console.log(windowLocation);
    if(windowLocation == '') {
        var crumb = 'dashboard';
    } else {
        const urlParams = new URLSearchParams(windowLocation);
        const page = urlParams.get('p');
        //console.log(page);
        var crumb = page;

    }
    $('.crumb-'+crumb+'').addClass('active');
    $('.crumb-'+crumb+'').addClass('fw-bold');
    //console.log(crumb);

}

function show_IndexerUpdateText(text) {
    $('.indexer_updateInfo').html(text);
    $('.indexer_updateInfo').show();
    setTimeout(() => {
        $('.indexer_updateInfo').hide();
    }, 3000)
}

function refreshModList() {
    $('.acp_modlistTableTBody').html('');
    // start spinner
    $('#acp_indexBtn').html('<div class="spinner-border text-light" role="status"><span class="visually-hidden">Loading...</span></div>');
    $('#indexer_updateInfo').html('Indexing... Please wait.');
    $('#indexer_updateInfo').css('display', 'inline-block');
    $.post(baseUrl, { 'request': 'reindex'}, function(data) {
        // console.log(data)
        if(data.status == 'OK') {
            $('#acp_indexBtn').html('Run Indexer');
            $('#indexer_updateInfo').html('Indexer Done!');
            setTimeout(() => {
                $('#indexer_updateInfo').hide();
            }, 3000)
            // repopulate list
            $('#acp_modListTableWrapper').load(baseUrl + ' #acp_modlistTable', { 'request': 'ajax_loadModList'})
        } else {
            console.log(data);
        }
    }, 'json');
    
}


function writeLog(msg) {
    const txt = msg + '\r\n';
    let logBox = $('#logBoxContents');
    let logboxContents = logBox.val();
    let newContents = logboxContents + txt;
    // console.log('NC: ' + newContents);
    logBox.val(newContents);
    
    setTimeout(() => {
      const elem = document.getElementById('logBoxContents');
      elem.scrollTop = elem.scrollHeight;
    }, 1);
  }

// Document Ready
$(document).ready(function() {
    
    $('#acp_indexBtn').on('click', function() {
        refreshModList();
    })
    
    setNavBreadcrumb();

    $('#acp_changePassButton').on('click', function() {
        $.post(baseUrl, { 'request': 'changePass', 'p': $('#acp_changePassInput').val()}, function(data) {
            if(data.status == 'OK') {
                $('#info_popupWrapper').show();
                $('#info_popup_OK').show();
                setTimeout(() => {
                    $('#info_popupWrapper').hide();
                    $('#info_popup_OK').hide();
                }, 3000);
            } else {
                console.log(data.status);
            }
        }, 'json')
    })

    $('#acp_importModsFromGPortalButton').on('click', function() {
        $('#info_popup_OK_FTP').hide();
        $('#info_popup_SpinnerWrapper_FTP').hide();
        writeLog('You clicked \'Import Mods\'. This means you have time. Time to grab some coffee. This will take time and there will be no progress bars until it\'s finished. ')
        writeLog('');
        writeLog('Don\'t close the window or refresh the page. It will tell notify you when it is done.')
        $('#info_popup_SpinnerWrapper_FTP').show();
        
        $.post(baseUrl, { 'request': 'importMods' }, function(data) {
            if(data.status == 'OK') {
                writeLog('Successfully imported all active mods from GPortal.');
                $('#info_popup_SpinnerWrapper_FTP').hide();
                $('#info_popup_OK_FTP').show();
                // setTimeout(() => {
                //     $('#info_popup_OK_FTP').hide();
                // }, 20000);
            }
        }, 'json')
    })
    
    $('#acp_saveChangeImportMods').on('click', function() {
        $('#acp_ftp_hostname').removeClass('redBorder');
        $('#acp_ftp_uname').removeClass('redBorder');
        $('#acp_ftp_pword').removeClass('redBorder');
        $('#acp_ftp_careerSavegameLink').removeClass('redBorder');

        let ftp_host = $('#acp_ftp_hostname').val();
        let ftp_user = $('#acp_ftp_uname').val();
        let ftp_pass = $('#acp_ftp_pword').val();
        let CSLink = $('#acp_ftp_careerSavegameLink').val();
        
        if (ftp_pass == '') {
            $('#acp_ftp_pword').addClass('redBorder');
        }
        if (ftp_user == '') {
            console.log('ftp_user')
            $('#acp_ftp_uname').addClass('redBorder');
        }
        if (ftp_host == '') {
            $('#acp_ftp_hostname').addClass('redBorder');
        }
        if (CSLink == '') {
            $('#acp_ftp_careerSavegameLink').addClass('redBorder');
        }

        if(ftp_host == '' || ftp_user == '' || ftp_pass == '' || CSLink == '') {
            return;
        }

        $.post(baseUrl, { 'request': 'importMods_saveChanges', 'formdata': $('#acp_ftp_form').serializeArray() }, function(data) {
            if(data['status'] == 'ok') {
                $('#info_popup_INFO_OK_FTP').show();
                setTimeout(() => {
                    $('#info_popup_INFO_OK_FTP').hide();
                }, 3000);
                writeLog(data['msg']);
                writeLog('Click \'Import Mods\' to start importing them from your GPortal server.')
            }
            
            // console.log(data)
        }, 'json')
    })



}); 