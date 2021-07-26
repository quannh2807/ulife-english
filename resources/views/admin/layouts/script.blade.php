{{--Laravel Mix - Include Bootstrap 4, jQuery, Admin LTE, see webpack.mix.js--}}
<script src="{{ asset('js/all.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src=""{{ asset('js/moment.js') }}></script>

<script>
    function getYoutubeId(url) {
        let ytb_id = url.split("v=")[1];

        let positionMoreData = ytb_id.indexOf("&");
        if (positionMoreData !== -1) {
            return ytb_id = ytb_id.substring(0, positionMoreData);
        }
        return ytb_id;
    }

    function string_to_slug(str) {
        let title, slug

        //Đổi chữ hoa thành chữ thường
        slug = str.toLowerCase()

        //Đổi ký tự có dấu thành không dấu
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a')
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e')
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i')
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o')
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u')
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y')
        slug = slug.replace(/đ/gi, 'd')
        //Xóa các ký tự đặt biệt
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\|_/gi, '')
        //Đổi khoảng trắng thành ký tự gạch ngang
        slug = slug.replace(/ /gi, "-")
        //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
        //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
        slug = slug.replace(/\-\-\-\-\-/gi, '-')
        slug = slug.replace(/\-\-\-\-/gi, '-')
        slug = slug.replace(/\-\-\-/gi, '-')
        slug = slug.replace(/\-\-/gi, '-')
        //Xóa các ký tự gạch ngang ở đầu và cuối
        slug = '@' + slug + '@'
        slug = slug.replace(/\@\-|\-\@|\@/gi, '')
        //In slug ra textbox có id “slug”
        return slug
    }

    $('.btn-remove').click(function (e) {
        e.preventDefault();

        let id = $(this).attr('data-id');

        Swal.fire({
            title: 'Bạn chắc chắn chưa?',
            text: "Dữ liệu bị xoá sẽ không thể khôi phục được!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Huỷ',
            confirmButtonText: 'Đồng ý xoá!'
        }).then(async (result) => {
            if (result.isConfirmed) {
                let url = $(this).attr('href');
                $.ajax({
                    url: `${url}`,
                    type: 'GET',
                    success: function () {
                        Swal.fire(
                            'Xoá thành công!',
                            'Dữ liệu đã được xoá hoàn toàn.',
                            'success'
                        ).then(() => {
                            $(`#row-${id}`).fadeOut(500, function () {
                                $(this).remove();
                            })
                        })
                    },
                    fail: function () {
                        Swal.fire(
                            'Có vấn đề xảy ra',
                            'Dữ liệu chưa được xoá',
                            'question'
                        )
                    }
                });
            }
        })
    });

    $('.btn-remove-level').click(function (e) {
        e.preventDefault();

        let id = $(this).attr('data-id');

        Swal.fire({
            title: 'Bạn chắc chắn chưa?',
            text: "Dữ liệu bị xoá sẽ không thể khôi phục được!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Huỷ',
            confirmButtonText: 'Đồng ý xoá!',
            width: 350
        }).then(async (result) => {
            if (result.isConfirmed) {
                let url = $(this).attr('href');
                $.ajax({
                    url: `${url}`,
                    type: 'GET',
                    success: function () {
                        Swal.fire(
                            'Xoá thành công!',
                            'Dữ liệu đã được xoá hoàn toàn.',
                            'success'
                        ).then(() => {
                            $(`#row-${id}`).fadeOut(500, function () {
                                $(this).remove();
                            })
                        })
                    },
                    fail: function () {
                        Swal.fire(
                            'Có vấn đề xảy ra',
                            'Dữ liệu chưa được xoá',
                            'question'
                        )
                    }
                });
            }
        })
    });

</script>
