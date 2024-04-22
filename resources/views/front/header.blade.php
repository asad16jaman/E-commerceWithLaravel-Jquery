<header class="bg-dark">
	<div class="container">
		<nav class="navbar navbar-expand-xl" id="navbar">
			<a href="" class="text-decoration-none mobile-logo">
			<span class="h2 text-uppercase text-primary bg-dark">Online</span>
				<span class="h2 text-uppercase text-white px-2">SHOP</span>
			</a>
			<button class="navbar-toggler menu-btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      			<!-- <span class="navbar-toggler-icon icon-menu"></span> -->
				  <i class="navbar-toggler-icon fas fa-bars"></i>
    		</button>
    		<div class="collapse navbar-collapse" id="navbarSupportedContent">
      			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
        			<!-- <li class="nav-item">
          				<a class="nav-link active" aria-current="page" href="index.php" title="Products">Home</a>
        			</li> -->
                    @if(getCatagories()->isNotEmpty())
                        @foreach(getCatagories() as $catagory)
                        <li class="nav-item dropdown">
                            <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                {{$catagory->name}}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                    @if(!empty($catagory->subCats))
                                    @foreach($catagory->subCats as $subcatagory)
                                     <li><a class="dropdown-item nav-link" href="{{ route('front.shop',['catagory'=>$catagory->slug,'subCatagory'=>$subcatagory->slug] )}}">{{ $subcatagory->name }}</a></li>
                                    @endforeach
                                    @else
                                    <li><a class="dropdown-item nav-link" href="#">No subCatagory is there</a></li>
                                    @endif
                            </ul>
                        </li>
                        @endforeach
                    @endif
      			</ul>      			
      		</div>   
			<div class="right-nav py-0">
				<a href="cart.php" class="ml-3 d-flex pt-2">
					<i class="fas fa-shopping-cart text-primary"></i>					
				</a>
			</div> 		
      	</nav>
  	</div>
</header>