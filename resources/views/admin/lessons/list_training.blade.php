<div class="modal fade" id="listTrainingModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Danh sách</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-result">
                    <div class="result-content">
                        <table class="table text-wrap">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tiếng Việt</th>
                                <th>Tiếng Anh</th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody id="lesson-training-tbody">
                            <tr>
                                <td></td>
                                <td><input type="text" name="vi" placeholder="Nhập câu hỏi tiếng việt" class="form-control form-control-sm"></td>
                                <td><input type="en" placeholder="Nhập câu hỏi tiếng anh" class="form-control form-control-sm"></td>
                                <td><a href="" class="btn btn-sm btn-success"><i class="fas fa-plus"></i>&nbsp;Thêm mới</a></td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td><input type="text" name="vi" placeholder="Nhập câu hỏi tiếng việt" class="form-control form-control-sm"></td>
                                <td><input type="en" placeholder="Nhập câu hỏi tiếng anh" class="form-control form-control-sm"></td>
                                <td>
                                    <a href="" class="btn btn-sm btn-warning"><i class="far fa-edit"></i>&nbsp;Sửa</a>
                                    <a href="" class="btn btn-sm btn-danger"><i class="fas fa-times"></i>&nbsp;Xóa</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Đóng
                </button>
                <button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-check"></i>&nbsp;Hoàn tất
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
