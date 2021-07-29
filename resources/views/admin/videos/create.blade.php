@extends('admin.layouts.master')

@section('page-title', 'Video youtube')
@section('breadcrumb', 'Video youtube')

@section('main')
    <div class="col-12">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title"><span class="text-danger">*&nbsp;</span>Không được bỏ trống</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="POST" action="{{ route('admin.video.saveCreate') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="video-cate">Danh mục<span class="text-danger">&nbsp;*</span></label>
                                <select name="categories[]" multiple class="form-control js-example-basic-multiple" id="video-cate">
                                    @foreach($categories as $index => $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="video-url">Đường dẫn video<span class="text-danger">&nbsp;*</span></label>
                                <div class="d-flex align-items-center border rounded">
                                    <input type="text" class="form-control col-10 border-0" id="video-url"
                                           placeholder="Youtube video url" name="ytb_url"/>
                                    <button class="col-2 btn border-left" id="btn-video-url">Kiểm tra</button>
                                </div>
                            </div>

                            @error('ytb_id')
                            <p style="color: red;">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="row d-none" id="more-info">
                        <input type="hidden" name="ytb_id"/>
                        <input type="hidden" name="description"/>
                        <input type="hidden" name="ytb_thumbnails"/>
                        <input type="hidden" name="publish_at"/>
                        <input type="hidden" name="tags"/>
                        <input type="hidden" name="channel_id"/>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="ytb-title">Title<span class="text-danger">&nbsp;*</span></label>
                                <input type="text" class="form-control" id="ytb-title"
                                       placeholder="Youtube video url" name="title"/>
                            </div>
                            <div class="form-group">
                                <label for="ytb-status">Trạng thái<span class="text-danger">&nbsp;*</span></label>
                                <select name="status" id="ytb-status" class="form-control">
                                    <option value="0">Không hiển thị</option>
                                    <option value="1" selected>Hiển thị</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="ytb-channel">Channel<span class="text-danger">&nbsp;*</span></label>
                                <input type="text" class="form-control" id="ytb-channel"
                                       placeholder="Youtube video url" name="channel_title"/>
                            </div>
                            <div class="form-group">
                                <label for="ytb-thumb">Thumbnail</label>
                                <div class="mt-1">
                                    <img src="" class="d-inline-block" id="ytb-thumb" style="" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-primary" id="btn-create" disabled>Tạo mới</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('custom-script')
    <script>
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2({
                placeholder: "Chọn danh mục video",
                theme: "classic"
            });

            function getYoutubeId(url) {
                let ytb_id = url.split("v=")[1];

                let positionMoreData = ytb_id.indexOf("&");
                if (positionMoreData !== -1) {
                    ytb_id = ytb_id.substring(0, positionMoreData);
                }
                return ytb_id;
            }

            $('button#btn-video-url').click(function (e) {
                e.preventDefault();
                const regex = /^https?:\/\/(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/g;

                let ytbInput = $('input#video-url').val();
                if (ytbInput.length > 0) {
                    const found = ytbInput.match(regex);

                    if (!found) {
                        Swal.fire(
                            'URL không phù hợp?',
                            'Bạn có chắc chắn đây là đường dẫn video youtube, vui lòng kiểm tra lại?',
                            'question'
                        )
                        return
                    }

                    let id = getYoutubeId(ytbInput);
                    $.ajax({
                        url: `https://www.googleapis.com/youtube/v3/videos?part=snippet&key=AIzaSyBM9q0VcZ_Gfp6FcdG56FSBZiEeDP-tWbk&id=${id}`,
                        type: 'GET',
                        dataType: "jsonp",
                        success: async function (res) {
                            const ytb_info = res.items[0];
                            const snippet = ytb_info.snippet;

                            // fill data to input
                            $('input[name=ytb_id]').val(ytb_info.id);
                            $('input[name=ytb_thumbnails]').val(JSON.stringify(snippet.thumbnails))
                            $('input[name=publish_at]').val(snippet.publishedAt)
                            $('input[name=description]').val(snippet.description)
                            $('input[name=tags]').val(JSON.stringify(snippet.tags))
                            $('input[name=channel_id]').val(snippet.channelId)
                            $('input#ytb-channel').val(snippet.channelTitle)
                            $('img#ytb-thumb').attr("src", snippet.thumbnails.default.url)
                            $('input#ytb-title').val(snippet.title)

                            $('#more-info').removeClass('d-none');
                            $('#btn-create').removeAttr('disabled');
                        },
                        fail: function () {

                        }
                    })
                }
            });
        });
    </script>
@endsection
