@extends('admin.layouts.master')

@section('page-title', 'Tạo video mới')

@section('main')
    <div class="col-12">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Quick Example</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form>
                <div class="card-body">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="video-cate">Danh mục</label>
                            <select name="cate_id" class="form-control" id="video-cate">
                                <option value="" selected>Bỏ trống</option>
                                <option value="0">Danh mục cha 1</option>
                                <option value="1">Danh mục cha 2</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="video-url">Đường dẫn video</label>
                            <input type="text" class="form-control" id="video-url"
                                   placeholder="Slug"name="url" onblur="parseYtbId()">
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-start">
                        <button type="submit" class="btn btn-primary">Tạo mới</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('custom-script')
    <script>
        function getYoutubeId(url) {
            let ytb_id = url.split("v=")[1];

            let positionMoreData = ytb_id.indexOf("&");
            if(positionMoreData !== -1) {
                ytb_id = ytb_id.substring(0, positionMoreData);
            }
            return ytb_id;
        }

        function parseYtbId() {
            let ytbInput = $('input#video-url');
            if (ytbInput.val().length > 0) {
                let id = getYoutubeId(ytbInput.val());
                console.log(id)
            }
        }
    </script>
@endsection
