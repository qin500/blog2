<form method="post" action="{{ route("Admin::category.store") }}">
    <div class="q5input">
        <label class="lab" for="">名称</label>
        <input name="name" class="form-control" type="text">
    </div>
    <div class="q5row">
        <input class="q5button" type="submit" value="添加">
    </div>
</form>


