@extends('admin.layouts.master')
@section('page-title', 'Danh sách Câu hỏi')
@section('breadcrumb', 'Danh sách Câu hỏi')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách câu hỏi</h3>

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
                                <a href="{{ route('admin.question.create') }}" class="d-inline-block btn btn-primary">Thêm
                                    mới</a>
                            </th>
                        </tr>
                        </thead>

                        {{--@php
                            $i = 1
                        @endphp

                        <tbody>
                        @foreach($categories as $index => $category)
                            <tr id="row-{{ $category->id }}">
                                <th>{{ $i ++ }}</th>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug}}</td>
                                <td>{{ $category->position }}</td>
                                <td>{{ $category->hasParentCate !== null ? $category->hasParentCate->name : '/' }}</td>
                                <td>{{ $category->type }}</td>
                                <td>{{ $category->status === 0 ? 'Không kích hoạt' : 'Kích hoạt' }}</td>
                                <td align="center" class="text-center">
                                    <a href="{{ route('admin.category.update', ['id' => $category->id]) }}"
                                       class="d-inline-block btn btn-sm btn-warning">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a class="d-inline-block btn btn-sm btn-danger ml-2 btn-remove"
                                       data-id="{{ $category->id }}"
                                       href="{{ route('admin.category.remove', ['id' => $category->id]) }}">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>--}}
                    </table>
                </div>
                <!-- /.card-body -->
                {{--<div class="card-footer clearfix">
                    {{ $categories->links() }}
                </div>--}}
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
