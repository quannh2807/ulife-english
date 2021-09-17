@extends('admin.layouts.master')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('main')
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $countLesson }}</h3>

                <p>Bài học</p>
            </div>
            <div class="icon">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <a href="{{ route('admin.lesson.index') }}" class="small-box-footer">Danh sách <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $countCourse }}</h3>

                <p>Khóa học</p>
            </div>
            <div class="icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <a href="{{ route('admin.course.index') }}" class="small-box-footer">Danh sách <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $countVideo }}</h3>

                <p>Videos</p>
            </div>
            <div class="icon">
                <i class="far fa-closed-captioning"></i>
            </div>
            <a href="{{ route('admin.video.index') }}" class="small-box-footer">Danh sách <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
@endsection
