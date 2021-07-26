@extends('admin.layouts.master')

@section('page-title', 'Thêm mới câu hỏi')
@section('breadcrumb', 'Thêm mới câu hỏi')

@section('main')
    <div class="col-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title"><span class="text-danger">*&nbsp;</span>Không được bỏ trống</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('admin.category.saveCreate') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="cate-name">Tên danh mục<span class="text-danger">&nbsp;*</span></label>
                                <input type="text" class="form-control" id="cate-name"
                                       placeholder="Điền tên danh mục" name="name" value="{{ old('name') }}">
                                @error('name')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="cate-slug">Slug<span class="text-danger">&nbsp;*</span></label>
                                <div class="d-flex border rounded">
                                    <input type="text" class="form-control col-10 border-0" id="cate-slug"
                                           placeholder="Điền slug" name="slug" value="{{ old('slug') }}">
                                    <button class="col-2 btn border-left" id="create-slug">Tạo slug</button>
                                </div>
                                @error('slug')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="cate-position">Vị trí</label>
                                <input type="text" class="form-control" id="cate-position"
                                       placeholder="Điền vị trí" name="position"
                                       value="{{ old('position') ? old('position') : 1 }}">
                                @error('position')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="cate-parent">Danh mục cha</label>
                                <select name="parent_id" class="form-control" id="cate-parent">
                                    @foreach($categories as $index => $category)
                                        @if($category->hasParentCate === null)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endif

                                        @includeWhen(
                                            count($category->hasChildrenCateRecursive) > 0,
                                            'admin.categories.child_cate',
                                            ['childCates' => $category->hasChildrenCateRecursive, 'space' => '--- ']
                                        )
                                    @endforeach
                                </select>

                                @error('parent_id')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="cate-status">Trạng thái<span class="text-danger">&nbsp;*</span></label>
                                <select name="status" class="form-control" id="cate-status">
                                    <option>Chọn trạng thái</option>
                                    <option value="0">Kích hoạt</option>
                                    <option value="1">Không kích hoạt</option>
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
                        <button type="submit" class="btn btn-primary">Tạo mới</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
