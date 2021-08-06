@extends('admin.layouts.master')
@section('page-title', 'Tạo câu hỏi')
@section('breadcrumb', 'Tạo câu hỏi')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Tạo câu hỏi cho Sub</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th style="width: 30px;">#</th>
                            <th style="width: 100px;">Start-time</th>
                            <th style="width: 100px;">End-time</th>
                            <th>Tiếng việt</th>
                            <th>Tiếng anh</th>
                            <th style="width: 30px;">Trạng thái</th>
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
                                <td><input value="{{$subtitle->vi}}}" type="text" class="form-control"/></td>
                                <td><input value="{{$subtitle->en}}}" type="text" class="form-control"/></td>
                                <td><span class="badge bg-success">Hoàn thành</span></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-primary"><i
                                class="fa fa-save"></i>&nbsp;&nbsp;Lưu lại
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.modal.video_list')
@endsection
