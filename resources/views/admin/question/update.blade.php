@extends('admin.layouts.master')

@section('page-title', 'Câu hỏi')
@section('breadcrumb', 'Cập nhật câu hỏi')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Cập nhật</h3>
                </div>
                <form action="{{ route('admin.question.update') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Nội dung câu hỏi<span class="text-danger">&nbsp;*</span></label>
                                    <input type="text" class="form-control" id="name"
                                           placeholder="Nhập nội dung câu hỏi" name="name" value="{{ $detail->name }}">
                                    @error('name')
                                    <p style="color: red;">{{$message}}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="start_time">Video</label>
                                    <div style="display: none;">
                                        <input id="video_id" name="video_id" type="text"
                                               value="@if($detail->getVideo) {{ $detail->getVideo->id }} @else 0 @endif"
                                               class="form-control">
                                        <input id="yt_id" type="text"
                                               value="@if($detail->getVideo) {{ $detail->getVideo->ytb_id }} @else @endif"
                                               class="form-control">
                                    </div>
                                    <div class="input-group input-group-md">
                                        <input id="ytb_link" type="text"
                                               value="@if($detail->getVideo) {{ $detail->getVideo->title }} @else @endif"
                                               class="form-control" readonly>
                                        <span class="input-group-append">
                                            <button id="pick_video" type="button" class="btn btn-info btn-flat">Chọn Video</button>
                                        </span>
                                    </div>
                                    <div id="divVideo" style="margin-top: 10px;"></div>
                                </div>

                                <div id="mVideo" class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="start_time">Start time</label>
                                            <input type="text" class="form-control" id="start_time"
                                                   placeholder="00:00:00" name="start_time"
                                                   value="{{ $detail->start_time }}">
                                            @error('start_time')
                                            <p style="color: red;">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="end_time">End time</label>
                                            <input type="text" class="form-control" id="end_time"
                                                   placeholder="00:00:00" name="end_time"
                                                   value="{{ $detail->end_time }}">
                                            @error('end_time')
                                            <p style="color: red;">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="level_id">Level Question</label>
                                            <select name="level_id" class="form-control" id="level_id">
                                                <option value="0">-- Chọn level --</option>
                                                @foreach($levelData as $index => $item)
                                                    @if($item != null)
                                                        <option
                                                            value="{{ $item->id }}" {{ $item->id === $detail->level_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('level_id')
                                            <p style="color: red;">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="topics_id">Topics</label>
                                            <select name="topics_id" class="form-control" id="topics_id">
                                                <option value="0">-- Chọn topics --</option>
                                                @foreach($topicsData as $index => $item)
                                                    @if($item != null)
                                                        <option
                                                            value="{{ $item->id }}" {{ $item->id === $detail->topics_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('topics_id')
                                            <p style="color: red;">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="level_type">Mức độ khó</label>
                                            <select name="level_type" class="form-control" id="level_type">
                                                <option value="0">-- Chọn mức độ --</option>
                                                @foreach(config('common.question_level') as $key => $level)
                                                    <option
                                                        value="{{ $level }}" {{ $level === $detail->level_type ? 'selected' : '' }}>{{ $key }}</option>
                                                @endforeach
                                            </select>
                                            @error('level_type')
                                            <p style="color: red;">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="status">Trạng thái<span
                                                    class="text-danger">&nbsp;*</span></label>
                                            <select name="status" class="form-control" id="status">
                                                @foreach(config('common.status') as $key => $status)
                                                    <option
                                                        value="{{ $status }}" {{ $status === $detail->status ? 'selected' : '' }}>{{ $key }}</option>
                                                @endforeach
                                            </select>
                                            @error('status')
                                            <p style="color: red;">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="answer_1">Câu trả lời 1<span class="text-danger">&nbsp;*</span></label>
                                    <input type="text" class="form-control" id="answer_1"
                                           placeholder="Nhập câu trả lời" name="answer_1"
                                           value="{{ $detail->answer_1 }}"
                                           onkeyup="changeAnswer_1();">
                                    @error('answer_1')
                                    <p style="color: red;">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="answer_2">Câu trả lời 2<span class="text-danger">&nbsp;*</span></label>
                                    <input type="text" class="form-control" id="answer_2"
                                           placeholder="Nhập câu trả lời" name="answer_2"
                                           value="{{ $detail->answer_2 }}"
                                           onkeyup="changeAnswer_2();">
                                    @error('answer_2')
                                    <p style="color: red;">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="answer_3">Câu trả lời 3<span class="text-danger">&nbsp;*</span></label>
                                    <input type="text" class="form-control" id="answer_3"
                                           placeholder="Nhập câu trả lời" name="answer_3"
                                           value="{{ $detail->answer_3 }}"
                                           onkeyup="changeAnswer_3();">
                                    @error('answer_3')
                                    <p style="color: red;">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="answer_4">Câu trả lời 4<span class="text-danger">&nbsp;*</span></label>
                                    <input type="text" class="form-control" id="answer_4"
                                           placeholder="Nhập câu trả lời" name="answer_4"
                                           value="{{ $detail->answer_4 }}"
                                           onkeyup="changeAnswer_4();">
                                    @error('answer_4')
                                    <p style="color: red;">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="answer_correct">Chọn đáp án đúng<span
                                            class="text-danger">&nbsp;*</span></label>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="answer_correct"
                                                   id="answer_correct_1" value="1"
                                                {{ $detail->answer_correct === '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" id="lbl_answer_1">1</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="answer_correct"
                                                   id="answer_correct_2" value="2"
                                                {{ $detail->answer_correct === '2' ? 'checked' : '' }}>
                                            <label class="form-check-label" id="lbl_answer_2">2</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="answer_correct"
                                                   id="answer_correct_3" value="3"
                                                {{ $detail->answer_correct === '3' ? 'checked' : '' }}>
                                            <label class="form-check-label" id="lbl_answer_3">3</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="answer_correct"
                                                   id="answer_correct_4" value="4"
                                                {{ $detail->answer_correct === '4' ? 'checked' : '' }}>
                                            <label class="form-check-label" id="lbl_answer_4">4</label>
                                        </div>
                                        @error('answer_correct')
                                        <p style="color: red;">{{$message}}</p>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-end">
                            <button type="submit" class="btn btn-primary"><i
                                    class="fa fa-edit"></i>&nbsp;&nbsp;Cập nhật
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@include('admin.modal.videolist')