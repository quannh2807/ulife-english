@foreach($childCates as $key => $childCate)
    @if($category->hasParentCate == null)
    <option value="{{ $childCate->id }}">{{ $space . $childCate->name }}</option>
    @endif

    @if(count($childCate->hasChildrenCateRecursive) > 0)
        @include(
            'admin.categories.child_cate',
            ['childCates' => $childCate->hasChildrenCateRecursive, 'space' => $space . '--- ']
        )
    @endif
@endforeach
