@extends('admin.layouts.master')

@section('page-title', 'VideoSubtitle')
@section('breadcrumb', 'VideoSubtitle')

@section('main')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><span class="text-danger">*&nbsp;</span>Không được bỏ trống</h3>
        </div>

        <form action="{{ route('admin.video.uploadSub') }}" method="POST" enctype="multipart/form-data" id="form-upload">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="upload-file">Upload phụ đề<span class="text-danger">&nbsp;*</span></label>
                            <input type="file" name="file_upload" id="upload-file" class="form-control"
                                   style="border: none"
                                   value="{{ old('file_upload') }}">
                        </div>

                        @error('file_upload')
                        <p style="color: red;">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col">
                        <div class="form-group">
                            <label for="video-id">Chọn video<span class="text-danger">&nbsp;*</span></label>

                            <select name="video_id" id="video-id" class="form-control">
                                <option selected>-- Chọn video --</option>
                                @foreach($videos as $video)
                                    <option
                                        value="{{ $video->id }}"
                                        {{ old('video_id') == $video->id ? 'selected' : ''}}
                                    >{{ $video->title }}</option>
                                @endforeach
                            </select>

                            @error('video_id')
                            <p style="color: red;">{{$message}}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="sub-lang">Chọn ngôn ngữ<span class="text-danger">&nbsp;*</span></label>
                            <select name="lang" id="lang">
                                <option value="">-- Chọn ngôn ngữ --</option>
                                @foreach(config('common.languages') as $key => $lang)
                                    <option value="{{ $key }}" {{ old('lang') === $key ? 'selected' : ''}}>{{ $lang }}</option>
                                @endforeach
                            </select>

                            @error('lang')
                            <p style="color: red;">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer btn-group-sm">
                <a href="javascript:void(0)" class="btn btn-sm btn-info" id="preview-sub">Preview</a>
                <button class="btn btn-sm btn-primary" type="submit">
                    Load file
                </button>
            </div>
        </form>
    </div>

    @include('admin.modal.file_sub_detail')
@endsection

@section('custom-script')
    <script>
        $('#preview-sub').click(function (e) {
            e.preventDefault()
            // $('#subtitleDetail').modal('show');
            let file = $('#upload-file').val()

            $.ajax({
                type: "POST",
                url: '{{ route('admin.video.preview') }}',
                data: {file_upload: file},
                success: function (response) {
                    console.log(response)
                    // $('.result-content').html(response);
                    // $('#questionDetailModal').modal('show');
                }
            });
        })
    </script>
@endsection
