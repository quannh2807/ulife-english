@extends('admin.layouts.master')
@section('page-title', 'Tạo câu hỏi')
@section('breadcrumb', 'Tạo câu hỏi')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách câu hỏi (Tổng: {{count($subtitles)}} - Sub)</h3>
                </div>
                <form action="{{ route('admin.question.storeQuestionList', $videoId)}}" method="POST">
                    @csrf
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th style="width: 30px;">STT</th>
                                <th style="width: 100px;">Start Time</th>
                                <th style="width: 100px;">End Time</th>
                                <th>Câu hỏi (EN)</th>
                                <th>Câu trả lời</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($subtitles) <= 0)
                                <tr id="have-sub">
                                    <td colspan="100%" align="center">Không có dữ liệu</td>
                                </tr>
                            @endif
                            @php
                                $i = 1;
                                $index = 0;
                            @endphp
                            @foreach($subtitles as $subtitle)
                                <tr style="cursor: pointer" data-id="{{ $subtitle->id }}">
                                    <th key-data="index">{{ $i++ }}</th>
                                    <td>{{ formatTimeSub($subtitle->time_start, FM_TIME_SUB_VIDEO) }}</td>
                                    <td>{{ formatTimeSub($subtitle->time_end, FM_TIME_SUB_VIDEO) }}</td>
                                    <td style="max-width: 200px;">
                                        <label id="status" class="bg-info">{{ $subtitle->en}}</label>
                                        <input class="form-control form-control-sm"
                                               type="text" name="name[]"
                                               placeholder="Nhập nội dung câu hỏi"
                                               value="{{ $subtitle->en ? $subtitle->en : old('name') }}"/>
                                        <div style="display:none;">
                                            <input class="form-control form-control-sm"
                                                   style="background: none; border: 0px"
                                                   type="text" name="name_origin[]"
                                                   value="{{ $subtitle->en}}"/>
                                            <input value="{{$subtitle->time_start}}"
                                                   class="form-control form-control-sm"
                                                   type="text" name="time_start[]"/>
                                            <input value="{{$subtitle->time_end}}"
                                                   class="form-control form-control-sm"
                                                   type="text" name="time_end[]"/>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row questionItem">
                                            <span class="badge badge-question">1</span>
                                            <input value="" type="text" class="form-control form-control-sm"
                                                   placeholder="Nhập câu trả lời 1" name="answer_1[]"/>
                                        </div>
                                        <div class="row questionItem">
                                            <span class="badge badge-question">2</span>
                                            <input value="" type="text" class="form-control form-control-sm"
                                                   placeholder="Nhập câu trả lời 2" name="answer_2[]"/>
                                        </div>
                                        <div class="row questionItem" style="margin-bottom: 10px;">
                                            <span class="badge badge-question">3</span>
                                            <input value="" type="text" class="form-control form-control-sm"
                                                   placeholder="Nhập câu trả lời 3" name="answer_3[]"/>
                                        </div>
                                        <div class="row questionItem" style="margin-bottom: 10px;">
                                            <span class="badge badge-question">4</span>
                                            <input value="" type="text" class="form-control form-control-sm"
                                                   placeholder="Nhập câu trả lời 4" name="answer_4[]"/>
                                        </div>
                                        <div class="form-group">
                                            <label style="width: 100%;">Chọn đáp án đúng</label>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                               type="radio" id="answer_correct_1_{{$index}}"
                                                               name="answer_correct[{{$index}}]" value="1" checked>
                                                        <label for="answer_correct_1_{{$index}}"><span
                                                                class="badge badge-question margin-circle">1</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                               type="radio" id="answer_correct_2_{{$index}}"
                                                               name="answer_correct[{{$index}}]" value="2">
                                                        <label for="answer_correct_2_{{$index}}"><span
                                                                class="badge badge-question margin-circle">2</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                               type="radio" id="answer_correct_3_{{$index}}"
                                                               name="answer_correct[{{$index}}]" value="3">
                                                        <label for="answer_correct_3_{{$index}}"><span
                                                                class="badge badge-question margin-circle">3</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                               type="radio" id="answer_correct_4_{{$index}}"
                                                               name="answer_correct[{{$index}}]" value="4">
                                                        <label for="answer_correct_4_{{$index}}"><span
                                                                class="badge badge-question margin-circle">4</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <div style="display: none">{{ $index++ }}</div>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-end">
                            <button type="submit" class="btn btn-primary"><i
                                    class="fa fa-save"></i>&nbsp;&nbsp;Lưu lại
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('admin.modal.video_list')
@endsection
