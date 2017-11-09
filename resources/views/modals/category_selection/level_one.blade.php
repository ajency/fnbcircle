<div class="main-category level-one m-l-30 m-r-30 m-b-30" id="level-one-category">
    <div class="add-container text-center">
        <h5 class="text-medium element-title">Select categories your listing belongs to <span class="text-primary">*</span></h5>
        <div class="text-lighter">
            One category at a time
        </div>
    </div>
    <ul class="interested-options catOptions cat-select flex-row m-t-45">
       @foreach($parents as $category)
        @if(isset($is_parent_select) && !$is_parent_select)
            <input type="checkbox" class="checkbox parent-categories" name="select-categories" data-name="{{$category->name}}" value="{{$category->id}}"/>Select all categories under {{$category->name}}
        @endif
        <input type="hidden" name="hierarchy" id="hierarchy" value="{{ json_encode(generateCategoryHierarchy($category['id'])) }}">
        <li class="catSelect-click">
            <input type="radio" class="radio parent-categories level-two-toggle" name="parent-categories" data-name="{{$category->name}}" value="{{$category->id}}"/>
            <div class="option flex-row">
                <img class="import-icon cat-icon" src="{{ $category->icon_url }}" />
            </div>
            <div class="interested-label">
                {{ $category->name }}
            </div>
        </li>
       @endforeach
    </ul>
</div>