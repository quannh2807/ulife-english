@extends('admin.layouts.master')

@section('page-title', 'Phụ đề')
@section('breadcrumb', 'Phụ đề')

@section('main')
    <div class="card">
        <div class="card-header">
            <h5>Video: {{ $video->title }}</h5>
            <div>
                <img src="{{ $video->ytb_thumbnails->url }}" alt="" width="{{ $video->ytb_thumbnails->width }}"
                     height="{{ $video->ytb_thumbnails->height }}"/>
            </div>
        </div>

        <div class="card-body">
            <button class="btn btn-sm btn-outline-danger btn-remove-all mr-2">
                <i class="fas fa-eraser"></i>
                &nbsp;Xóa phụ đề đã chọn
            </button>

            <button class="btn btn-sm btn-outline-primary btn-upload mr-2">
                <i class="fas fa-upload"></i>
                &nbsp;Import phụ đề
            </button>

            <button class="btn btn-sm btn-outline-primary" id="create-sub">
                <i class="fas fa-plus"></i>
                &nbsp;Tạo phụ đề mới
            </button>
            @if($video->id >0 && count($subtitles) > 0)
                @if(videoHasQuestionSub($video->id))
                    <a href="{{ route('admin.question.editQuestionList',['id' => $video->id]) }}"
                       class="d-inline-block btn btn-sm btn-primary"><i
                            class="fa fa-list"></i>&nbsp;&nbsp;Danh sách câu hỏi</a>
                @else
                    <a href="{{ route('admin.question.createQuestionList',['id' => $video->id]) }}"
                       class="d-inline-block btn btn-sm btn-primary"><i
                            class="fa fa-copy"></i>&nbsp;&nbsp;Tạo danh sách câu hỏi</a>
                @endif
            @endif
        </div>

        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" style="height: 400px;">
            <table class="table table-head-fixed table-hover">
                <thead>
                <tr>
                    <th><input type="checkbox" class="main-checked"></th>
                    <th>#</th>
                    <th width="12%">Start-time</th>
                    <th width="12%">End-time</th>
                    <th>Tiếng việt</th>
                    <th>Tiếng anh</th>
                    <th class="text-center" style="width: 110px; ">Thao tác</th>
                </tr>
                </thead>

                <tbody id="list-subtitles">
                @if(count($subtitles) <= 0)
                    <tr id="have-sub">
                        <td colspan="100%" align="center">Video này chưa có phụ đề</td>
                    </tr>
                @endif

                @php
                    $i = 1
                @endphp

                @foreach($subtitles as $subtitle)
                    <tr style="cursor: pointer" id="row-{{ $subtitle->id }}" data-id="{{ $subtitle->id }}">
                        <td><input type="checkbox" class="sub-checked" data-id="{{ $subtitle->id }}"></td>
                        <td key-data="index">{{ $i++ }}</td>
                        <td>{{ seconds2SRT($subtitle->time_start) }}</td>
                        <td>{{ seconds2SRT($subtitle->time_end) }}</td>
                        <td>{!! $subtitle->vi ?  $subtitle->vi : '<span class="d-inline-block px-1 m-1 bg-danger rounded" style="font-size: 13px">Chưa có phụ đề</span>' !!}</td>
                        <td>{!! $subtitle->en ? $subtitle->en : '<span class="d-inline-block px-1 m-1 bg-danger rounded" style="font-size: 13px">Chưa có phụ đề</span>' !!}</td>
                        <td class="text-center">
                            <button
                                data-id="{{ $subtitle->id }}"
                                class="btn btn-sm btn-warning select-sub">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <a
                                href="{{route('admin.subtitle.destroy', [ 'id' => $subtitle->id ])}}"
                                data-id="{{ $subtitle->id }}"
                                class="btn btn-sm btn-danger btn-remove">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

    <div class="card">
        <div class="card-body ">
            <form id="add-sub">
                <div class="row">
                    <div class="col form-group">
                        <input type="text" id="sub_id" name="sub_id" class="form-control"
                               value="-1" hidden/>
                        <label for="start-time">Start time</label>
                        <input type="text" name="start_time" id="start-time" class="form-control"
                               placeholder="00:00:00,000"
                               data-inputmask="'mask': '99:99:99,999'"/>
                    </div>
                    <div class="col form-group">
                        <label for="end-time">End time</label>
                        <input type="text" name="end_time" id="end-time" class="form-control"
                               placeholder="00:00:00,000"
                               data-inputmask="'mask': '99:99:99,999'"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="vi" class="pr-2">Tiếng việt</label>
                    <input type="text" name="vi" id="vi" class="flex-grow-1 form-control"
                           placeholder="Phụ đề tiếng Việt"/>
                </div>
                <div class="form-group">
                    <label for="en" class="pr-2">Tiếng anh</label>
                    <input type="text" name="en" id="en" class="flex-grow-1 form-control"
                           placeholder="Phụ đề tiếng Anh">
                </div>

                <button type="submit" class="btn btn-primary" id="btn-create"><i class="fas fa-plus"></i>&nbsp;&nbsp;Thêm
                    mới
                </button>
            </form>
        </div>
    </div>
    <!-- /.card -->

    @include('admin.subtitles.modal')
@endsection

@section('custom-script')
    @include('admin.subtitles.script')
@endsection
