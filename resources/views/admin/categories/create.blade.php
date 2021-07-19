@extends('admin.layouts.master')

@section('page-title', 'Tạo danh mục mới')

@section('main')
    <div class="col-12">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Quick Example</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="cate-name">Tên danh mục</label>
                                <input type="text" class="form-control" id="cate-name"
                                       placeholder="Điền tên danh mục" name="name">
                            </div>
                            <div class="form-group">
                                <label for="cate-slug">Slug</label>
                                <input type="text" class="form-control" id="cate-slug"
                                       placeholder="Slug" name="slug">
                            </div>
                            <div class="form-group">
                                <label for="cate-position">Vị trí</label>
                                <input type="texts" class="form-control" id="cate-position"
                                       placeholder="Position" name="position">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="cate-parent">Danh mục cha</label>
                                <select name="parent_id" class="form-control" id="cate-parent">
                                    <option value="" selected>Bỏ trống</option>
                                    <option value="0">Danh mục cha 1</option>
                                    <option value="1">Danh mục cha 2</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cate-type">Loại danh mục</label>
                                <input type="text" class="form-control" id="cate-type"
                                       placeholder="Loại danh mục" name="type">
                            </div>
                            <div class="form-group">
                                <label for="cate-status">Trạng thái</label>
                                <select name="status" class="form-control" id="cate-status">
                                    <option value="" selected>Bỏ trống</option>
                                    <option value="0">Kích hoạt</option>
                                    <option value="1">Không kích hoạt</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-primary">Tạo mới</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
