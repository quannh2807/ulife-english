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
                                <label for="video-url">Đường dẫn video<span class="text-danger">&nbsp;*</span></label>
                                <div class="input-group input-group-sm">
                                    <input id="video-url" name="ytb_url" type="text"
                                           class="form-control"
                                           placeholder="Youtube video url">
                                    <span class="input-group-append">
                                            <button id="btn-video-url" type="button" class="btn btn-info btn-flat">Kiểm tra</button>
                                        </span>
                                </div>
                                @error('ytb_id')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                                <div id="divVideo" style="margin-top: 10px;"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="video-cate">Danh mục<span class="text-danger">&nbsp;*</span></label>
                                <select name="categories[]" multiple
                                        class="form-control form-control-sm js-example-basic-multiple"
                                        id="video-cate">
                                    @foreach($categories as $index => $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row d-none" id="more-info">
                        <div class="col-12" hidden>
                            <input name="ytb_id" placeholder="ytb_id here" class="form-control"/>
                            <input name="ytb_thumbnails" placeholder="ytb_thumbnails here" class="form-control"/>
                            <input name="publish_at" placeholder="publish_at here" class="form-control"/>
                            <input name="tags" placeholder="tags here" class="form-control"/>
                            <input name="channel_id" placeholder="channel_id here" class="form-control"/>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="ytb-title">Title<span class="text-danger">&nbsp;*</span></label>
                                <input type="text" class="form-control form-control-sm" id="ytb-title"
                                       placeholder="Youtube video url" name="title"/>
                            </div>
                            <div class="form-group">
                                <label for="video-description">Mô tả<span class="text-danger">&nbsp;*</span></label>
                                <textarea name="description" class="form-control"
                                          id="video-description"></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="ytb-channel">Channel<span class="text-danger">&nbsp;*</span></label>
                                <input type="text" class="form-control form-control-sm" id="ytb-channel"
                                       placeholder="Youtube video url" name="channel_title"/>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="ytb-type">Loại video<span class="text-danger">&nbsp;*</span></label>
                                    <select name="type" id="ytb-type" class="form-control form-control-sm select-type">
                                        @foreach(config('common.video_types') as $key => $type)
                                            <option value="{{ $type }}">{{ $key }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label for="topic_id">Chủ đề</label>
                                    <select class="form-control form-control-sm"
                                            name="topic_id" id="topic_id">
                                        <option value="0">-- Chọn chủ đề --</option>
                                        @foreach($topicData as $index => $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="ytb-status">Vị trí</label>
                                    <input type="text" class="form-control form-control-sm"
                                           id="position" name="position"
                                           value="0"
                                           placeholder="Nhập vào vị trí"/>
                                </div>
                                <div class="form-group col-6">
                                    <label for="ytb-status">Trạng thái<span class="text-danger">&nbsp;*</span></label>
                                    <select class="form-control form-control-sm" name="status" id="ytb-status">
                                        @foreach(config('common.status') as $key => $status)
                                            <option
                                                value="{{ $status }}" {{ request()->has('status') && request()->get('status') == $status  ? 'selected' : '' }}>{{ $key }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ytb-thumb">Thumbnail</label>
                                <div class="mt-1">
                                    <img id="ytb-thumb" src="" class="d-inline-block">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-sm btn-primary" id="btn-create" disabled><i
                                class="fa fa-plus"></i>&nbsp;&nbsp;Tạo mới
                        </button>
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
            });

            // Summernote
            $('#video-description').summernote({
                height: 200,
                minHeight: 200,
                maxHeight: 300,
                focus: false
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
                            $('textarea#video-description').summernote("code", snippet.description);
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

                    let ytbId = id;
                    let playUrl = "https://www.youtube.com/watch?v=" + ytbId;
                    $('#divVideo').empty()
                    $('#divVideo').append('<a id="viewVideo" title="Play Video" class="video html5lightbox" href="' + playUrl + '" data-width="640" data-height="360" ><span class="icon fa fa-play">&nbsp;&nbsp;Xem Video</span></a>');
                    if (ytbId === "" || ytbId === null) {
                        $("#divVideo").hide(1000);
                    } else {
                        $("#divVideo").show("slow");
                    }
                    $(".html5lightbox").html5lightbox();
                }
            });
        });
    </script>
@endsection
