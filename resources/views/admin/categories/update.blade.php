@extends('admin.layouts.master')

@section('page-title', 'Cập nhật danh mục')
@section('breadcrumb', 'Cập nhật danh mục')

@section('main')
    <div class="col-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title"><span class="text-danger">*&nbsp;</span>Không được bỏ trống</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('admin.category.saveUpdate') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $category->id }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="cate-name">Tên danh mục<span class="text-danger">&nbsp;*</span></label>
                                <input type="text" class="form-control" id="cate-name"
                                       placeholder="Điền tên danh mục" name="name" value="{{ $category->name }}">
                                @error('name')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="cate-slug">Slug<span class="text-danger">&nbsp;*</span></label>
                                <div class="row border rounded">
                                    <input type="text" class="form-control col-10 border-0" id="cate-slug"
                                           placeholder="Điền slug" name="slug" value="{{ $category->slug }}">
                                    <button class="col-2 btn border-left" id="create-slug">Tạo slug</button>
                                </div>
                                @error('slug')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="cate-position">Vị trí</label>
                                <input type="text" class="form-control" id="cate-position"
                                       placeholder="Điền vị trí" name="position" value="{{ $category->position }}">
                                @error('position')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="cate-parent">Danh mục cha</label>
                                <select name="parent_id" class="form-control" id="cate-parent">
                                    <option value="0" selected>Danh mục gốc</option>
                                    @foreach($categories as $index => $cate)
                                        <option value="{{ $cate->id }}" {{ $cate->id === $category->parent_id ? 'selected' : '' }} >{{ $cate->name }}</option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="cate-type">Loại danh mục</label>
                                <input type="text" class="form-control" id="cate-type"
                                       placeholder="Điền loại danh mục" name="type" value="{{ $category->type }}">
                                @error('type')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="cate-status">Trạng thái<span class="text-danger">&nbsp;*</span></label>
                                <select name="status" class="form-control" id="cate-status">
                                    @foreach(config('common.status') as $key => $status)
                                    <option value="{{ $status }}" {{ $status === $category->status ? 'selected' : '' }}>{{ $key }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('custom-script')
    <script>
        $('button#create-slug').click((e) => {
            e.preventDefault()
            let currentValue = $('input#cate-name').val()

            let slug = string_to_slug(`${currentValue}`)

            $('input#cate-slug').val(slug);
        });
    </script>
@endsection
