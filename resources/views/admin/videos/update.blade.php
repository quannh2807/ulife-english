@extends('admin.layouts.master')

@section('page-title', 'Cập nhật thông tin')
@section('breadcrumb', 'update youtube video')

@section('main')
    <div class="col-12">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title"><span class="text-danger">*&nbsp;</span>Không được bỏ trống</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="POST" action="{{ route('admin.video.saveUpdate') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $video->id }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="video-cate">Danh mục<span class="text-danger">&nbsp;*</span></label>
                                <select name="categories[]" multiple class="form-control js-example-basic-multiple" id="video-cate">
                                    @foreach($categories as $index => $category)
                                        <option
                                            value="{{ $category->id }}"
                                            {{ $video->hasCategories->contains('id', $category->id) ? 'selected' : '' }}
                                        >
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="video-id">Tên video<span class="text-danger">&nbsp;*</span></label>
                                <input type="text" class="form-control" id="video-id"
                                       placeholder="Youtube video id" name="ytb_id" value="{{ $video->title }}">
                            </div>
                            <div class="form-group">
                                <label for="ytb-status">Trạng thái<span class="text-danger">&nbsp;*</span></label>
                                <select name="status" id="ytb-status" class="form-control">
                                    <option value="0">Không hiển thị</option>
                                    <option value="1" selected>Hiển thị</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="ytb-thumb">Ảnh thumb<span class="text-danger">&nbsp;*</span></label>
                                    <div>
                                        <img src="{{ $video->ytb_thumbnails['url'] }}"
                                             width="{{ $video->ytb_thumbnails['width'] }}"
                                             height="{{ $video->ytb_thumbnails['height'] }}" alt=""/>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-checkbox pb-1">
                                        <input class="custom-control-input" type="checkbox" id="customCheckbox1">
                                        <label for="customCheckbox1" class="custom-control-label">Tuỳ chọn ảnh
                                            thumb</label>
                                    </div>

                                    <div class="form-group d-none" id="custom-thumb">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile"
                                                       name="custom_thumbnails">
                                                <label class="custom-file-label" for="exampleInputFile">Chọn ảnh</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="video-description">Mô tả<span class="text-danger">&nbsp;*</span></label>
                                <textarea name="description" class="form-control"
                                          id="video-description">{!! $video->description !!}</textarea>
                            </div>
                        </div>

                        @error('ytb_id')
                        <p style="color: red;">{{$message}}</p>
                        @enderror
                    </div>
                </div>

                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-primary" id="btn-create">Cập nhật</button>
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

            // Summernote
            $('#video-description').summernote();

            // custom thubmnail
            $('input[type=checkbox]#customCheckbox1').change(function (e) {
                let isChecked = $(this).is(':checked');
                if (isChecked) {
                    $('#custom-thumb').removeClass('d-none')
                } else if (!isChecked) {
                    $('#custom-thumb').addClass('d-none')
                }
            })

            // youtube url
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
