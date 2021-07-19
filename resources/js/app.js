import Swal from "sweetalert2";

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

window.basicAlert = (msg) => {
    Swal.fire(msg);
};

window.confirmDelete = (id, route) => {
    console.log(route)
    $(id).click(event => {
        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (!result.isConfirmed) return


            Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            )
        })
    })
}
