<div class="card border-0 shadow-lg">
    <div class="card-header  text-white">
        Welcome, {{ Auth::user()->name }}                        
    </div>
    <div class="card-body">
        <div class="text-center mb-3">
            @if (Auth::user()->image !="")
            <img src="{{ asset('uploads/profile/thumb/'.Auth::user()->image) }}" class="img-fluid rounded-circle" alt="Luna John">                            
                
            @endif
        </div> 
        <div class="h5 text-center">
            <strong>{{ Auth::user()->name }}</strong>
            <p class="h6 mt-2 text-muted">{{ (Auth::user()->reviews->count()>1)?Auth::user()->reviews->count(). ' Reviews':Auth::user()->reviews->count().' Review' }}</p>
        </div>
    </div>
</div>
<div class="card border-0 shadow-lg mt-3">
    <div class="card-header  text-white">
        Navigation
    </div>
    <div class="card-body sidebar">
        <ul class="nav flex-column">
            @if (Auth::user()->role== 'admin')
            <li class="nav-item">
                <a href="{{ route('books.index') }}"><i class="fa-solid fa-book-journal-whills"></i> Books</a>                               
            </li>
            <li class="nav-item">
                <a href="{{ route('account.reviews') }}"><i class="fa fa-star-half-alt"></i> Reviews</a>                               
            </li>  
            @endif
            
            <li class="nav-item">
                <a href="{{ route('account.profile') }}"><i class="fa-solid fa-user"></i> Profile</a>                               
            </li>
            <li class="nav-item">
                <a href="{{ route('account.myReview') }}"><i class="fa fa-star-half-alt"></i> My Reviews</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('account.password.changePassword') }}"><i class="fa-solid fa-key"></i> Change Password</a>
            </li> 
            <li class="nav-item">
                <a href="{{ route('account.logout') }}"><i class="fa-solid fa-delete-left"></i> Logout</a>
            </li>                           
        </ul>
    </div>
</div>