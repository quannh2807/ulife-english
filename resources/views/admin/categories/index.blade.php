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
                        <th></th>
                        <th>Tên</th>
                        <th>Slug</th>
                        <th>Vị trí</th>
                        <th>Danh mục cha</th>
                        <th>Loại danh mục</th>
                        <th>Trạng thái</th>
                        <th>Người tạo</th>
                        <th>Người cập nhật</th>
                        <th class="row align-content-center justify-content-center">
                            <a href="{{ route('admin.category.create') }}" class="btn btn-primary">Thêm mới</a>
                        </th>
                    </tr>
                    </thead>

                    @php
                        $i = 1
                    @endphp

                    <tbody>
                    @foreach($categories as $index => $category)
                    <tr>
                        <th>{{ $i ++ }}</th>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug}}</td>
                        <td>{{ $category->position }}</td>
                        <td>{{ $category->parent_id }}</td>
                        <td>{{ $category->type }}</td>
                        <td>{{ $category->status }}</td>
                        <td>{{ $category->createdBy->acc_name }}</td>
                        <td>{{ $category->updatedBy->acc_name }}</td>
                        <td class="row align-content-center justify-content-center">
                            <a href="{{ route('admin.category.update', ['id' => $category->id]) }}" class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a>
                            <a id="btn-delete" class="btn btn-secondary ml-2" onclick="confirmDelete('.btn-delete', '{{ route('admin.category.remove', ['id' => $category->id]) }}')">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <!--
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
            </div>
            -->
        </div>
        <!-- /.card -->
    </div>
@endsection

@section('custom-script')
    <script>
        confirmDelete('.btn-delete')
    </script>
@endsection
