@extends("front.layout.app")

@section("content")


<section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item">Register</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10">
        <div class="container">
            <div class="login-form">    
                <form action="/examples/actions/confirmation.php" method="post" name="registrationForm" id="registrationForm">
                    <h4 class="modal-title">Register Now</h4>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Name" id="name" name="name">
                        <p class="errorMessages"></p>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Email" id="email" name="email">
                        <p class="errorMessages"></p>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Phone" id="phone" name="phone">
                        <p class="errorMessages"></p>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                        <p class="errorMessages"></p>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Confirm Password" id="password_confirmation" name="password_confirmation">
                        <p class="errorMessages"></p>
                    </div>
                    <div class="form-group small">
                        <!-- <a href="#" class="forgot-link">Forgot Password?</a> -->
                    </div> 
                    <button type="submit" class="btn btn-dark btn-block btn-lg" value="Register">Register</button>
                </form>			
                <div class="text-center small">Already have an account? <a href="{{route('account.login')}}">Login Now</a></div>
            </div>
        </div>
    </section>

@endsection

@section("customJs")
<script>


$("#registrationForm").on("submit",function(e){
    e.preventDefault();

    $.ajax({
        url:"{{ route('account.processRegister') }}",
        type:"post",
        data:$(this).serializeArray(),
        dataType:"json",
        success:function(res){

            if(res.status == false){
                let err = res.errors
                $('.errorMessages').removeClass("invalid-feedback").html('').siblings("input").removeClass('is-invalid')
                for (const key in err) {
                    $(`#${key}`).addClass('is-invalid').siblings("p").addClass("invalid-feedback").html(err[key])
                }
            }else{

                window.location.href = "{{ route('account.login')}}"

            }


           

        },
        error:function(jqxhr,execption){
            console.log("somethikdkd ddkd wrong...")
        }
    })


})

</script>
@endsection