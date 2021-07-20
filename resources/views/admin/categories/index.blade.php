@extends('admin.layouts.master')
@section('page-title', 'Danh mục video')
@section('breadcrumb', 'Danh mục video')

@section('main')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Đây sẽ là nơi đặt các filter</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 200px;">
                        <input type="text" name="table_search" class="form-control float-right"
                               placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-wrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên</th>
                        <th>Slug</th>
                        <th>Vị trí</th>
                        <th>Danh mục cha</th>
                        <th>Loại danh mục</th>
                        <th>Trạng thái</th>
                        <th align="center" class="text-center">
                            <a href="{{ route('admin.category.create') }}" class="d-inline-block btn btn-primary">Thêm
                                mới</a>
                        </th>
                    </tr>
                    </thead>

                    @php
                        $i = 1
                    @endphp

                    <tbody>
                    @foreach($categories as $index => $category)
                        <tr id="row-{{ $category->id }}">
                            <th>{{ $i ++ }}</th>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug}}</td>
                            <td>{{ $category->position }}</td>
                            <td>{{ $category->parent !== null ? $category->parent->name : 'Danh mục gốc' }}</td>
                            <td>{{ $category->type }}</td>
                            <td>{{ $category->status === 0 ? 'Không kích hoạt' : 'Kích hoạt' }}</td>
                            <td align="center" class="text-center">
                                <a href="{{ route('admin.category.update', ['id' => $category->id]) }}"
                                   class="d-inline-block btn btn-sm btn-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a class="d-inline-block btn btn-sm btn-danger ml-2 btn-remove"
                                   data-id="{{ $category->id }}">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{ $categories->links() }}
            </div>
        </div>
        <!-- /.card -->
    </div>
@endsection

@section('custom-script')
    <script>
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
                    let url = window.location.href;
                    $.ajax({
                        url: `${url}/remove/${id}`,
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
                        }
                    });
                } else {
                    Swal.fire(
                        'Có vấn đề xảy ra',
                        'Dữ liệu chưa được xoá',
                        'question'
                    )
                }
            })
        });
    </script>
@endsection
