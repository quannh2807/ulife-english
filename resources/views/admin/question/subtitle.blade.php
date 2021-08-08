@extends('admin.layouts.master')
@section('page-title', 'Tạo câu hỏi')
@section('breadcrumb', 'Tạo câu hỏi')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Tạo câu hỏi cho Video Sub</h3>
                </div>
                <form action="" method="POST">
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
                                {{--<th>Trạng thái</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($subtitles) <= 0)
                                <tr id="have-sub">
                                    <td colspan="100%">Video này chưa có subtitles</td>
                                </tr>
                            @endif
                            @php
                                $i = 1
                            @endphp
                            @foreach($subtitles as $subtitle)
                                <tr style="cursor: pointer" data-id="{{ $subtitle->id }}">
                                    <th key-data="index">{{ $i++ }}</th>
                                    <td>{{ \Carbon\Carbon::parse((int)$subtitle->time_start)->format('H:i:s') }}</td>
                                    <td>{{ \Carbon\Carbon::parse((int)$subtitle->time_end)->format('H:i:s') }}</td>
                                    <td><input value="{{$subtitle->en}}}" name="name[]" type="text"
                                               class="form-control form-control-sm"/>
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
                                                               type="radio" value="1" id="answer_correct_1_{{$i}}"
                                                               name="answer_correct[{{$i}}]" checked>
                                                        <label for="answer_correct_1_{{$i}}"><span
                                                                class="badge badge-question margin-circle">1</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                               type="radio" value="2" id="answer_correct_2_{{$i}}"
                                                               name="answer_correct[{{$i}}]">
                                                        <label for="answer_correct_2_{{$i}}"><span
                                                                class="badge badge-question margin-circle">2</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                               type="radio" value="3" id="answer_correct_3_{{$i}}"
                                                               name="answer_correct[{{$i}}]">
                                                        <label for="answer_correct_3_{{$i}}"><span
                                                                class="badge badge-question margin-circle">3</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                               type="radio" value="4" id="answer_correct_4_{{$i}}"
                                                               name="answer_correct[{{$i}}]">
                                                        <label for="answer_correct_4_{{$i}}"><span
                                                                class="badge badge-question margin-circle">4</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    {{--<td><span class="badge bg-success">Hoàn thành</span></td>--}}
                                </tr>
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
