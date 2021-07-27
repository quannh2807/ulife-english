@extends('admin.layouts.master')

@section('page-title', 'Câu hỏi')
@section('breadcrumb', 'Câu hỏi')

@section('main')
    <div class="col-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title"><span class="text-danger">*&nbsp;</span>Không được bỏ trống</h3>
            </div>
            <form action="{{ route('admin.category.saveCreate') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Nội dung câu hỏi<span class="text-danger">&nbsp;*</span></label>
                                <input type="text" class="form-control" id="name"
                                       placeholder="Nhập nội dung câu hỏi" name="name" value="{{ old('name') }}">
                                @error('name')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="start_time">Video</label>
                                <div class="input-group input-group-md">
                                    <input id="ytb_id" type="text" class="form-control" hidden>
                                    <input id="ytb_link" type="text" class="form-control" readonly>
                                    <span class="input-group-append">
                                    <button type="button" class="btn btn-info btn-flat">Chọn Video</button>
                                </span>
                                </div>
                            </div>

                            <div id="mVideo" class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="start_time">Start time</label>
                                        <input type="text" class="form-control" id="start_time"
                                               placeholder="00:00:00" name="start_time "
                                               value="{{ old('start_time') }}">
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
                                               value="{{ old('end_time') }}">
                                        @error('end_time')
                                        <p style="color: red;">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="level_id">Level</label>
                                        <select name="level_id" class="form-control" id="level_id">
                                            <option>-- Chọn level --</option>
                                            @foreach($levelData as $index => $item)
                                                @if($item != null)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
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
                                        <label for="cate-topics">Topics</label>
                                        <select name="topics" class="form-control" id="cate-topics">
                                            <option>-- Chọn topics --</option>
                                            @foreach($topicsData as $index => $item)
                                                @if($item != null)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('topics')
                                        <p style="color: red;">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="type">Mức độ</label>
                                        <select name="type" class="form-control" id="type">
                                            <option>-- Chọn mức độ --</option>
                                            @foreach(config('common.question_level') as $key => $level)
                                                <option
                                                    value="{{ $level }}">{{ $key }}</option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                        <p style="color: red;">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="cate-status">Trạng thái<span
                                                class="text-danger">&nbsp;*</span></label>
                                        <select name="status" class="form-control" id="cate-status">
                                            <option>-- Chọn trạng thái --</option>
                                            @foreach(config('common.status') as $key => $status)
                                                <option
                                                    value="{{ $status }}">{{ $key }}</option>
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
                                       placeholder="Nhập câu trả lời" name="answer_1" value="{{ old('answer_1') }}">
                                @error('answer_1')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="answer_2">Câu trả lời 2<span class="text-danger">&nbsp;*</span></label>
                                <input type="text" class="form-control" id="answer_2"
                                       placeholder="Nhập câu trả lời" name="answer_2" value="{{ old('answer_2') }}">
                                @error('answer_2')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="answer_3">Câu trả lời 3<span class="text-danger">&nbsp;*</span></label>
                                <input type="text" class="form-control" id="answer_3"
                                       placeholder="Nhập câu trả lời" name="answer_3" value="{{ old('answer_3') }}">
                                @error('answer_3')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="answer_4">Câu trả lời 4<span class="text-danger">&nbsp;*</span></label>
                                <input type="text" class="form-control" id="answer_4"
                                       placeholder="Nhập câu trả lời" name="answer_4" value="{{ old('answer_4') }}">
                                @error('answer_4')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="answer_correct">Đáp án đúng (Nhập vị trí đáp án VD: 1)<span
                                        class="text-danger">&nbsp;*</span></label>
                                <input type="number" class="form-control" id="answer_correct"
                                       placeholder="Nhập vị trí đáp án đúng" name="answer_correct"
                                       value="{{ old('answer_correct') }}">
                                @error('answer_correct')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-primary"><i
                                class="fa fa-plus"></i>&nbsp;&nbsp;Tạo mới
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
