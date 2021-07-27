@extends('admin.layouts.master')
@section('page-title', 'Topics')
@section('breadcrumb', 'Topics')

@section('main')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách</h3>
                    <div class="card-tools">
                        <div>
                            <a href="{{ route('admin.topics.create') }}"
                               class="d-inline-block btn btn-sm btn-primary"><i
                                    class="fa fa-plus"></i>&nbsp;&nbsp;Thêm
                                mới</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
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
                                    <td>{{ $i ++ }}</td>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        @if($item->hasLevel)
                                            <label id="status" class="levels">{{ $item->hasLevel->name }}</label>
                                        @else
                                            <label id="status" class="no-levels">NO LEVEL</label>
                                        @endif
                                    </td>
                                    <td class="text-center">{!! $item->status === 0 ? '<label id="status" class="noActive">Không kích hoạt</label>'
                            : '<label id="status" class="active">Kích hoạt</label>' !!}
                                    </td>
                                    <td align="center" class="text-center">
                                        <a href="{{ route('admin.topics.edit', ['id' => $item->id]) }}"
                                           class="d-inline-block btn btn-sm btn-warning"
                                           data-toggle="tooltip" data-placement="top"
                                           title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a class="d-inline-block btn btn-sm btn-danger ml-2 btn-remove-topics"
                                           data-id="{{ $item->id }}"
                                           href="{{ route('admin.topics.remove', ['id' => $item->id]) }}"
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
                </div>
            </div>
        </div>
    </div>
@endsection
