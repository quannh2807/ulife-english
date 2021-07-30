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
                    <form id="frmSearch" method="POST">
                        <div class="row">
                            <div class="col-3 item-search">
                                <input type="text" class="form-control form-control-sm"
                                       id="keyword" name="keyword"
                                       placeholder="Tìm kiếm với tiêu đề hoặc ID"
                                       value="">
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                  </span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm float-right"
                                           id="reservation">
                                </div>
                            </div>
                            <div class="col-2">
                                <select class="form-control form-control-sm">
                                    <option>--Chọn Level--</option>
                                    @foreach($levelData as $index => $item)
                                        @if($item != null)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <select class="form-control form-control-sm">
                                    <option value="0">--Chọn topics--</option>
                                    @foreach($topicsData as $index => $item)
                                        @if($item != null)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <select class="form-control form-control-sm">
                                    <option>--Trạng thái--</option>
                                    @foreach(config('common.status') as $key => $status)
                                        <option
                                            value="{{ $status }}">{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <button name="search" type="submit"
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
                            <th>Nội dung câu hỏi</th>
                            <th>Đáp án</th>
                            <th class="text-center">Level</th>
                            <th>Topics</th>
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
                                <td colspan="9" align="center">Không có dữ liệu</td>
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
                                    <td class="text-center"><span class="lbl-item">{{ $item->created_at }}</span></td>
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
@section('custom-script')
    <script>
        if ($(".btn-remove-question").length > 0) {
            $('.btn-remove-question').click(function (e) {
                e.preventDefault();

                let id = $(this).attr('data-id');

                Swal.fire({
                    title: 'Bạn muốn xóa câu hỏi?',
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
