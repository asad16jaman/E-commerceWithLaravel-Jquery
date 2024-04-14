@extends("admin.layout.adminlayout")

@section("content")
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Sub Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="subcategory.html" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
            <form action="" method="post" id="catagoryform">
                <div class="card">  
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name">Category</label>
                                    <select name="category" id="category" class="form-control">
                                        @if(!empty($catagories))
                                        @foreach($catagories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name}}</option>
                                        @endforeach

                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                </div>
                                <p></p>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug">
                                </div>
                                <p></p>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name">Status</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary" type="submit">Update</button>
                    <a href="{{ route(" catagories.index") }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
            
    </div>
    <!-- /.card -->
</section>

@endsection



@section("customJs")
<script>
    $("#catagoryform").submit(function (e) {
        






    })




    $("#name").on("keyup", function (e) {
        let vv = $(this).val();
        vv = vv.trim().split(" ");
        vv = vv.join("-")
        $("#slug").val(vv)
    })


</script>
@endsection