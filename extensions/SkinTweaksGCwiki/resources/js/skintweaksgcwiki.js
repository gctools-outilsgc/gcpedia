function addTopBar(){

    var header = document.createElement('div');
    header.id = "collab-fip-header";

    header.innerHTML = '<object type="image/svg+xml" tabindex="-1" role="img" data="extensions/SkinTweaksGCwiki/resources/images/sig-alt-en.svg" aria-label="Symbol of the Government of Canada" style="height:25px; float:left; padding:5px 10px;"></object> \
    <div id="app-brand-name"><span style="font-weight:600">GC</span>wiki</div>';

    document.body.insertBefore(header, document.body.firstChild);
}

addTopBar();