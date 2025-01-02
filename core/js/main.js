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

// Document Ready
$(document).ready(function() {
    
    $('#acp_indexBtn').on('click', function() {
        refreshModList();
    })

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

    setNavBreadcrumb();
}); 