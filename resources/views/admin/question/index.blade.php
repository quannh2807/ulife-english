@extends('admin.layouts.master')
@section('page-title', 'Danh sách Câu hỏi')
@section('breadcrumb', 'Danh sách Câu hỏi')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách</h3>
                    <div class="card-tools">
                        <div>
                            <a href="{{ route('admin.question.create') }}"
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
                            <th style="width: 30px;">STT</th>
                            <th style="width: 30px;">#</th>
                            <th>Nội dung câu hỏi</th>
                            <th>Đáp án</th>
                            <th class="text-center">Level</th>
                            <th>Topics</th>
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
                                <td colspan="8" align="center">Không có dữ liệu</td>
                            </tr>
                        @else
                            @foreach($data as $index => $item)
                                <tr id="row-{{ $item->id }}">
                                    <td class="text-center">{{ $i ++ }}</td>
                                    <td class="text-center">{{ $item->id }}</td>
                                    <td>
                                        <span class="lbl-name">{{ $item->name }}</span>
                                        @if($item->start_time)
                                            <div>
                                                <span class="item-child-lbl"><i class="fa fa-clock"></i>&nbsp;Start Time:&nbsp;</span>
                                                <span class="item-child-val">{{ $item->start_time }}</span>
                                            </div>
                                        @endif
                                        @if($item->end_time)
                                            <div>
                                                <span class="item-child-lbl"><i class="fa fa-clock"></i>&nbsp;End Time:&nbsp;</span>
                                                <span class="item-child-val">{{ $item->end_time }}</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <span
                                                class="badge badge-question @if($item->answer_correct == 1)badge-correct@else @endif">1</span>
                                            <span class="lbl-answer">{{ $item->answer_1}}</span>
                                        </div>
                                        <div>
                                            <span
                                                class="badge badge-question @if($item->answer_correct == 2)badge-correct @else @endif">2</span>
                                            <span class="lbl-answer">{{ $item->answer_2}}</span>
                                        </div>
                                        <div>
                                            <span
                                                class="badge badge-question @if($item->answer_correct == 3)badge-correct @else @endif">3</span>
                                            <span class="lbl-answer">{{ $item->answer_3}}</span>
                                        </div>
                                        <div>
                                            <span
                                                class="badge badge-question @if($item->answer_correct == 4)badge-correct @else @endif">4</span>
                                            <span class="lbl-answer">{{ $item->answer_4}}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($item->getLevel)
                                            <label id="status" class="levels">{{ $item->getLevel->name }}</label>
                                        @else
                                            <label id="status" class="no-levels">No Level</label>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->getTopics)
                                            <label id="status" class="levels">{{ $item->getTopics->name }}</label>
                                        @else
                                            <label id="status" class="no-levels">No Topics</label>
                                        @endif
                                    </td>
                                    <td class="text-center">{!! $item->status === 0 ? '<label id="status" class="noActive">Không kích hoạt</label>'
                            : '<label id="status" class="active">Kích hoạt</label>' !!}
                                    </td>
                                    <td align="center" class="text-center">
                                        <a class="btn btn-sm btn-info question-detail-view"
                                           data-id="{{ $item->id }}"
                                           data-toggle="tooltip" data-placement="top" title="Chi tiết"
                                           href="javascript:void(0)"><i class="fa fa-eye"></i><span></span></a>
                                        <a href="{{ route('admin.question.edit', ['id' => $item->id]) }}"
                                           class="btn btn-sm btn-primary"
                                           data-toggle="tooltip" data-placement="top"
                                           title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a class="btn btn-sm btn-danger btn-remove-question"
                                           data-id="{{ $item->id }}"
                                           href="{{ route('admin.question.remove', ['id' => $item->id]) }}"
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
    @include('admin.modal.question_detail')
@endsection
