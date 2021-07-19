@extends('admin.layouts.master')
@section('page-title', 'Danh mục video')

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
            <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-hover text-wrap">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Tên</th>
                        <th>Slug</th>
                        <th>Vị trí</th>
                        <th>Danh mục cha</th>
                        <th>Loại danh mục</th>
                        <th>Trạng thái</th>
                        <th class="row align-content-center justify-content-center">
                            <button class="btn btn-primary">Thêm mới</button>
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>183</td>
                        <td>John Doe</td>
                        <td>11-7-2014</td>
                        <td>11-7-2014</td>
                        <td>11-7-2014</td>
                        <td><span class="tag tag-success">Approved</span></td>
                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                        <td class="row align-content-center justify-content-center">
                            <button class="btn btn-warning"><i class="fas fa-pencil-alt"></i></button>
                            <button class="btn btn-secondary ml-2"><i class="far fa-trash-alt"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>183</td>
                        <td>John Doe</td>
                        <td>11-7-2014</td>
                        <td>11-7-2014</td>
                        <td>11-7-2014</td>
                        <td><span class="tag tag-success">Approved</span></td>
                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                        <td>
                            <div class="row align-content-center justify-content-center">
                                <a href="{{ route('admin.category.update') }}" class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a>
                                <a href="{{ route('admin.category.remove') }}" class="btn btn-secondary ml-2"><i class="far fa-trash-alt"></i></a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
            </div>
        </div>
        <!-- /.card -->
    </div>
@endsection
