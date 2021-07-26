@extends('admin.layouts.master')
@section('page-title', 'Levels')
@section('breadcrumb', 'Levels')

@section('main')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách Level</h3>

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
                        <th style="width: 50px;">#</th>
                        <th>Tên</th>
                        <th>Trạng thái</th>
                        <th align="right" class="text-right" style="width: 150px;">
                            <a href="{{ route('admin.level.create') }}" class="d-inline-block btn btn-sm btn-primary"><i
                                    class="fa fa-plus"></i>&nbsp;&nbsp;Thêm
                                mới</a>
                        </th>
                    </tr>
                    </thead>

                    @php
                        $i = 1
                    @endphp

                    <tbody>
                    @foreach($data as $index => $item)
                        <tr id="row-{{ $item->id }}">
                            <th>{{ $i ++ }}</th>
                            <td>{{ $item->name }}</td>
                            <td>{!! $item->status === 0 ? '<label id="status" class="noActive">Không kích hoạt</label>'
                            : '<label id="status" class="active">Kích hoạt</label>' !!}
                            </td>
                            <td align="center" class="text-center">
                                <a href="{{ route('admin.level.edit', ['id' => $item->id]) }}"
                                   class="d-inline-block btn btn-sm btn-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a class="d-inline-block btn btn-sm btn-danger ml-2 btn-remove-level"
                                   data-id="{{ $item->id }}"
                                   href="{{ route('admin.level.remove', ['id' => $item->id]) }}">
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
                {{ $data->links() }}
            </div>
        </div>
        <!-- /.card -->
    </div>
@endsection
