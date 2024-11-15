@extends("front.layout.app")

@section("content")

<section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                    <li class="breadcrumb-item">Settings</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-11 ">
        <div class="container  mt-5">
            <div class="row">
                <div class="col-md-12">
                    @include("front.messages")
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">

                    @include("front.account.common.sidebar")
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">Change Password</h2>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <form action="" method="post" id="updatePassword">
                                        <div class="mb-3">               
                                            <label for="">Current Password</label>
                                            <input type="password"  name="c_password" id="c_password" placeholder="Enter Current Password" class="form-control">
                                            <p class="error"></p>
                                        </div>

                                        <div class="mb-3">               
                                            <label for="">New Password</label>
                                            <input type="password"  name="password" id="password" placeholder="Enter New Password" class="form-control">
                                            <p class="error"></p>
                                        </div>

                                        <div class="mb-3">               
                                            <label for="">Confirm Password</label>
                                            <input type="password"  name="password_confirmation" id="password_confirmation" placeholder="Enter New Password Again" class="form-control">
                                            <p class="error"></p>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-dark">Update</button>
                                        </div>
                                        
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


@section('customJs')
<script>
    $("#updatePassword").submit(function(e){
        e.preventDefault();
        
        $.ajax({
            url:"{{ route('account.edit_password') }}",
            type:"post",
            data:$(this).serializeArray(),
            dataType:'json',
            success:function(res){
               
                $(".error").removeClass("invalid-feedback").html("").siblings("input").removeClass('is-invalid');
                if(res.status == false){
                    $.each(res.errors,function(key,value){
                        $(`#${key}`).addClass('is-invalid').siblings('p').addClass("invalid-feedback").html(value)
                    })
                    
                }else{
                    window.location.href = "{{ route('account.edit_password') }}"
                }
                
            }
        })







    })
</script>

@endsection

