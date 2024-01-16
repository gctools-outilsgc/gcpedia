function newUserPage(){

    var newPageContents = "{{subst:NewUserPage}}"; // Replace with your content
    var mw = window.mw;

    function checkForUserPage(newPage) {
    mw.loader.using("mediawiki.util").then(function () {
        var editToken = mw.user.tokens.get("csrfToken");

        function checkPageExists() {
            return new Promise(function (resolve, reject) {
            new mw.Api()
                .get({
                    action: "query",
                    titles: newPage,
                    prop: "deletedrevisions",
                    format: "json",
                })
                .done(function (data) {
                    var page = data.query.pages;
                    var pageId = Object.keys(page)[0];
                    var pageProperties = Object.keys(page[pageId]);
                    resolve(pageId !== "-1" || pageProperties.includes("deletedrevisions") ); // -1 indicates the page does not exist
                })
                .fail(function (error) {
                    reject(error);
                });
            });
        }

        function createIfMissing(exists) {
            if (!exists) {
                new mw.Api()
                .postWithToken("csrf", {
                    action: "edit",
                    title: newPage,
                    text: newPageContents,
                    format: "json",
                })
                .done(function (data) {
                    if (data && data.edit && data.edit.result === "Success") {
                        var link = window.location.protocol + '//' + window.location.host + '/' + newPage;

                        var lang = mw.config.wgUserLanguage;
                        var messageNode = document.createElement("div");
                        messageNode.innerHTML =
                        lang === "fr"
                            ? "Votre nouvelle page utilisateur a été créée avec succès. Modifiez-la <a href='" + link + "'>ici</a>"
                            : 'Your new user page has been created successfully. Edit it <a href="' + link + '">here</a>';
                        mw.notify(messageNode, {
                            title: lang === "fr" ? "Page utilisateur créée" : "User page Created",
                            autoHide: false,
                        });
                    } else {
                        console.error("Failed to create page");
                    }
                })
                .fail(function (error) {
                    console.error("Failed to create page:", error);
                });
            }
        }

        checkPageExists()
            .then(createIfMissing)
            .catch(function (error) {
                console.error("Error checking if page exists:", error);
            });
    });
    }

    function getCookie(name) {
        var value = "; " + document.cookie;
        var parts = value.split("; " + name + "=");
        if (parts.length == 2) return parts.pop().split(";").shift();
    }

    function setCookie(name, value, days) {
        var date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        var expires = "; expires=" + date.toUTCString();
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    if (mw.config.values.wgUserId) {
        const username = mw.config.values.wgUserName;
        if (getCookie("createdNewUserPage") !== 'userPage') {
            var newPage = "User:" + username;
            console.info("checking new user page", newPage);
            checkForUserPage(newPage);
            setCookie("createdNewUserPage", 'userPage', 3650);
        }
    }
}

newUserPage();