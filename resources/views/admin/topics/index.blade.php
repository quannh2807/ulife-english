@extends('admin.layouts.master')
@section('page-title', 'Topics')
@section('breadcrumb', 'Topics')

@section('main')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách Topics</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 300px;">
                        <input type="text" name="table_search" class="form-control float-right"
                               placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>

                        <div style="margin-left: 15px;">
                            <a href="{{ route('admin.topics.create') }}"
                               class="d-inline-block btn btn-sm btn-primary"><i
                                    class="fa fa-plus"></i>&nbsp;&nbsp;Thêm
                                mới</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th style="width: 50px;">STT</th>
                        <th style="width: 50px;">#</th>
                        <th>Tên</th>
                        <th>Level</th>
                        <th align="center" class="text-center" style="width: 120px;">Trạng thái</th>
                        <th align="right" class="text-center" style="width: 150px;">Thao tác</th>
                    </tr>
                    </thead>

                    @php
                        $i = 1
                    @endphp

                    <tbody>
                    @if($data->isEmpty())
                        <tr>
                            <td colspan="6" align="center">Không có dữ liệu</td>
                        </tr>
                    @else
                        @foreach($data as $index => $item)
                            <tr id="row-{{ $item->id }}">
                                <td>{{ $i ++ }}</td>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    @if($item->hasLevel)
                                        {{ $item->hasLevel->name }}
                                    @else
                                        NO LEVEL
                                    @endif
                                </td>
                                <td class="text-center">{!! $item->status === 0 ? '<label id="status" class="noActive">Không kích hoạt</label>'
                            : '<label id="status" class="active">Kích hoạt</label>' !!}
                                </td>
                                <td align="center" class="text-center">
                                    <a href="{{ route('admin.topics.edit', ['id' => $item->id]) }}"
                                       class="d-inline-block btn btn-sm btn-warning">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a class="d-inline-block btn btn-sm btn-danger ml-2 btn-remove-topics"
                                       data-id="{{ $item->id }}"
                                       href="{{ route('admin.topics.remove', ['id' => $item->id]) }}">
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
            </div>
        </div>
        <!-- /.card -->
    </div>
@endsection
