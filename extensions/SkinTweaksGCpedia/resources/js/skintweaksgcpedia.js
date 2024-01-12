function addTopBar(){
    const mw = window.mw;
    const lang = {
        "lang3Code": mw.msg( 'wet:lang3Code' ),
        "searchBoxPlaceholder": mw.msg( 'searchsuggest-search-tools' ),
        "pedia": mw.msg( 'pedia' ),
        "gcdirectoryLink": mw.msg( 'wet:gcdirectoryLink' ),
        "barDirectory": mw.msg( 'wet:barDirectory' ),
        "gcintranetLink": mw.msg( 'wet:gcintranetLink' ),
        "gcconnexLink": mw.msg( 'wet:gcconnexLink' ),
        "gccollabLink": mw.msg( 'wet:gccollabLink' ),
        "langlink": mw.msg( 'topbar:langlink' )
    }

    var header = document.createElement('header');
    header.role = "banner"

    // the federated search form
    const searchbox = "<div class='col-sm-5 col-lg-3 col-md-4 col-xs-5 text-right'><section id='wb-srch' class='text-right'> \
    <h2>Search</h2> \
    <form action='http://intranet.canada.ca/search-recherche/query-recherche-" + lang.lang3Code + ".aspx' method='get' name='cse-search-box' role='search' class='form-inline'> \
    <div class='form-group'> \
    <label for='wb-srch-q' class='wb-inv'>Search website</label> \
    <input id='search' list='wb-srch-q-ac' class='wb-srch-q form-control' name='q' type='search' value='' size='21' maxlength='150' placeholder='" + lang.searchBoxPlaceholder + "'> \
    <datalist id='wb-srch-q-ac'> \
    <!--[if lte IE 9]><select><![endif]--> \
    <!--[if lte IE 9]></select><![endif]--> \
    </datalist> \
                   <!-- hidden forms for federated search --> \
                   <input type='hidden' name='a'  value='s'> \
                   <input type='hidden' name='s'  value='2'> \
                   <input type='hidden' name='chk3'  value='True'> \
    </div> \
    <div class='form-group submit'> \
    <button type='submit' id='wb-srch-sub' class='btn btn-small' name='wb-srch-sub'><span class='glyphicon-search glyphicon'></span><span class='wb-inv'>Search</span></button> \
    </div> \
    </form> \
    </section></div>";
    
    header.innerHTML = "<div id='app-brand'> \
    <div class='container-fluid'> \
        <div class='row'> \
            <div class='col-lg-2 col-md-2 col-xs-7'> \
                <div class='app-name'> \
                <a href='/'> \
                    <span><span class='bold-gc'>GC</span>" + lang.pedia + " \
                </a> \
                </div> \
            </div> \
            <div class='col-lg-6 col-md-5 col-sm-7 hidden-sm hidden-xs'> \
                <ul id='tool-link' class='pull-left list-unstyled mrgn-bttm-0'> \
                    <li class='pull-left tool-link'> \
                        <a href=' " + lang.gcdirectoryLink + "'> \
                        <span class='bold-gc'>GC</span>" + lang.barDirectory + "</a> \
                    </li> \
                    <li class='pull-left tool-link'> \
                        <a href='" + lang.gcintranetLink + "'> \
                        <span class='bold-gc'>GC</span>intranet</a> \
                    </li> \
                    <li class='pull-left tool-link'> \
                        <a href='" + lang.gcconnexLink + "'> \
                        <span class='bold-gc'>GC</span>connex</a> \
                    </li> \
                    <li class='pull-left tool-link'> \
                        <a href='" + lang.gccollabLink + "'> \
                        <span class='bold-gc'>GC</span>collab</a> \
                    </li> \
                </ul> \
            </div> \
            <div id='wb-lng' class='visible-md visible-lg text-right col-sm-1'> \
                <div class='col-md-12'> \
                    <ul class='list-inline margin-bottom-none'> \
                        <li>" + lang.langlink + "</li> \
                    </ul> \
                </div> \
            </div> \
            " + searchbox + "\
        </div> \
    </div> \
</div>";
    
    document.body.insertBefore(header, document.body.firstChild);
}

addTopBar();