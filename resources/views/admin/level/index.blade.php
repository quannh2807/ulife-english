@extends('admin.layouts.master')
@section('page-title', 'Levels')
@section('breadcrumb', 'Levels')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách</h3>
                    <div class="card-tools">
                        <div>
                            <a href="{{ route('admin.level.create') }}"
                               class="d-inline-block btn btn-sm btn-primary"><i
                                    class="fa fa-plus"></i>&nbsp;&nbsp;Thêm
                                mới</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('admin.level.search') }}" method="GET">
                        <div class="row">
                            <div class="col-3 item-search">
                                <input type="text" class="form-control form-control-sm"
                                       id="keyword" name="keyword"
                                       placeholder="Tìm kiếm với tiêu đề hoặc ID"
                                       value="{{ request()->has('keyword') ? request()->get('keyword') : '' }}">
                            </div>
                            <div style="margin: 0px 6px;">
                                <div class="input-group">
                                    <input id="valRangeDate" name="rangeDate" type="text"
                                           value="{{ request()->has('rangeDate') ? request()->get('rangeDate') : '' }}"
                                           hidden>
                                    <button type="button" class="btn btn-sm btn-default float-right btn-block text-left"
                                            id="daterange-btn">
                                        <i class="far fa-calendar-alt"></i>&nbsp;&nbsp;<span
                                            id="txtDateRange">{{ request()->has('rangeDate') && !empty(request()->get('rangeDate')) ? request()->get('rangeDate') : 'Từ ngày - Đến ngày' }}</span>
                                        <i class="fas fa-caret-down"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-2">
                                <select class="form-control form-control-sm" name="status">
                                    <option value="-1">--Trạng thái--</option>
                                    @foreach(config('common.status') as $key => $status)
                                        <option
                                            value="{{ $status }}" {{ request()->has('status') && request()->get('status') == $status  ? 'selected' : '' }}>{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <button type="submit"
                                        class="btn btn-sm btn-success"><i
                                        class="fa fa-search"></i><span>&nbsp; Tìm kiếm</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th style="width: 30px;">STT</th>
                            <th style="width: 30px;">#</th>
                            <th>Tên</th>
                            <th align="center" class="text-center" style="width: 120px;">Trạng thái</th>
                            <th class="text-center" style="width: 110px;">Ngày tạo</th>
                            <th align="right" class="text-center" style="width: 150px;">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i = 1
                        @endphp

                        @if($data->isEmpty())
                            <tr>
                                <td colspan="6" align="center">Không có dữ liệu</td>
                            </tr>
                        @else
                            @foreach($data as $index => $item)
                                <tr id="row-{{ $item->id }}">
                                    <td class="text-center">{{ $i ++ }}</td>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td class="text-center">{!! $item->status === 0 ? '<label id="status" class="noActive">Không kích hoạt</label>'
                            : '<label id="status" class="active">Kích hoạt</label>' !!}
                                    </td>
                                    <td class="text-center"><span class="lbl-item">{{ $item->created_at }}</span></td>
                                    <td align="center" class="text-center">
                                        <a href="{{ route('admin.level.edit', ['id' => $item->id]) }}"
                                           class="btn btn-sm btn-primary"
                                           data-toggle="tooltip" data-placement="top"
                                           title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a class="btn btn-sm btn-danger btn-remove-level"
                                           data-id="{{ $item->id }}"
                                           href="{{ route('admin.level.remove', ['id' => $item->id]) }}"
                                           data-toggle="tooltip" data-placement="top"
                                           title="Xóa">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $data->links() }}
                    {{--<ul class="pagination pagination-sm m-0 float-right">
                        <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                    </ul>--}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom-script')
    <script>
        if ($(".btn-remove-level").length > 0) {
            $('.btn-remove-level').click(function (e) {
                e.preventDefault();

                let id = $(this).attr('data-id');

                Swal.fire({
                    title: 'Bạn muốn xóa level này?',
                    text: "Dữ liệu bị xoá sẽ không thể khôi phục được!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    cancelButtonText: 'Đóng',
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
        }
    </script>
@endsection
