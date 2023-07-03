<form method="post" action="{{ route("Admin::category.update",[$category]) }}">
    <div class="q5input">
        <label class="lab" for="">名称</label>
        @method('PUT')
        <input name="name" value="{{ $category->name }}" class="form-control" type="text">
    </div>
    <div class="q5row">
        <input class="q5button" type="submit" value="更新">
    </div>
</form>


