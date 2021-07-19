$(document).ready(() => {
    /*** add active class and stay opened when selected ***/
    var url = window.location;

    // for sidebar menu entirely but not cover treeview
    $('ul.nav-sidebar a').filter(function () {
        if (this.href) {
            return this.href === url || url.href.indexOf(this.href) === 0;
        }
    }).addClass('active');

    // for the treeview
    $('ul.nav-treeview a').filter(function () {
        if (this.href) {
            return this.href === url || url.href.indexOf(this.href) === 0;
        }
    }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
});

function getYoutubeId(url) {
    let ytb_id = url.split("v=")[1];

    let positionMoreData = ytb_id.indexOf("&");
    if(positionMoreData !== -1) {
        return ytb_id = ytb_id.substring(0, positionMoreData);
    }
    return ytb_id;
}
