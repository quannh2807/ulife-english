<div class="modal fade" id="upload_sub" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-upload" action="{{ route('admin.video.uploadSub') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="video_id" value="{{ $video->id }}">
                <div class="modal-header">
                    <h4 class="modal-title">Import phụ đề</h4>
                    <button type="button" class="close close-modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-result">

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="upload-file">Upload phụ đề<span
                                            class="text-danger">&nbsp;*</span></label>
                                    <input type="file" name="file_upload" id="upload-file" class="form-control"
                                        style="border: none" value="{{ old('file_upload') }}">
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="sub-lang">Chọn ngôn ngữ<span class="text-danger">&nbsp;*</span></label>
                                    <select name="lang" id="lang">
                                        <option value="">-- Chọn ngôn ngữ --</option>
                                        @foreach(config('common.languages') as $key => $lang)
                                        <option value="{{ $key }}" {{ old('lang')===$key ? 'selected' : '' }}>{{ $lang
                                            }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body d-none" id="preview">
                    <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table class="table table-head-fixed table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Start-time</th>
                                    <th>End-time</th>
                                    <th>Phụ đề</th>
                                </tr>
                            </thead>

                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default close-modal"><i class="fa fa-times"></i>&nbsp;Đóng
                    </button>

                    <div class="btn-group-sm">
                        <button class="btn btn-sm btn-info btn-preview">
                            Xem trước
                        </button>

                        <button class="btn btn-sm btn-primary" type="submit">
                            Upload phụ đề
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
